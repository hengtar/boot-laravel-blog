<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreAdvertCategory;
use App\Models\Article;
use App\Models\AdvertCategory;
use Illuminate\Http\Request;
use Mockery\Exception;

class AdvertCategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($recover = false, $type = null, $order = null, $search = null)
    {

        //builder
        $builder = AdvertCategory::query();

        //recover status
        if ($recover) {
            $builder->onlyTrashed();
        }

        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('category', 'like', '%' . $search . '%');
        }

        //advertCategory value
        $advertCategorys = $recover || $search ?  $builder->get() : tree($builder->get());


        return view('boot.advertCategory.index', [
            'advertCategoryOrm'   => new AdvertCategory(),
            'advertCategorys'     => $advertCategorys,
            'recover'       => $recover,
            'search'        => $search,
            'order'         => $order,
            'type'          => $type,
        ]);
    }

    /**
     * Sort articles is post
     *
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {

        try {
            foreach ($request->sort as $key => $value) {
                if (!is_numeric($value) || strlen($value) > 11) {
                    return redirect()->back()->with('error', '文章ID：' . $key . '排序值错误!');
                }


                AdvertCategory::withTrashed()->where('id', $key)->update(['sort' => $value]);
            }

            return redirect()->back()->with('success', '排序成功!');

        } catch (Exception $e) {

            return redirect()->back()->with('error', '排序失败!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //all advertCategory
        $advertCategory = tree(AdvertCategory::all('id', 'category','p_id'));

        return view('boot.advertCategory.create', [
            'advertCategory' => $advertCategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertCategory $request)
    {
        //get request
        $param = $request->toArray();

        //format advertCategory key => value
        $param['sort']  = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create advertCategory key => value
        $result = AdvertCategory::create($param);

        //save advertCategory
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('advertCategory-index')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //all advertCategory
        $advertCategory_list = tree(AdvertCategory::all('id', 'category','p_id'));

        //find advertCategory info
        $advertCategory = AdvertCategory::find($id);

        return view('boot.advertCategory.edit', [
            'advertCategory'      => $advertCategory,
            'advertCategory_list' => $advertCategory_list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAdvertCategory $request)
    {

        //get request
        $param = $request->toArray();

        //format advertCategory key => value
        $param['sort']  = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create advertCategory key => value
        $AdvertCategory = AdvertCategory::find($param['id']);

        //save advertCategory
        if ($AdvertCategory->update($param)) {

            return response()->json(['success' => true, 'url' => route('advertCategory-index')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //format delete id
        $id = FormatDelete($id);
        foreach ($id as $value){

            if (AdvertCategory::where('p_id',$value)->first()){
                return redirect()->back()->with('error', '删除失败！当前ID:' . $value .'还存在下级分类');
            }else{
                // databases operating
                if (AdvertCategory::destroy($value)) {

                    return redirect()->back()->with('success', '删除成功！');
                } else {

                    return redirect()->back()->with('error', '删除失败！');
                }
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deleteForce($id)
    {
        try {
            //format delete id
            $id = FormatDelete($id);

            // databases operating
            AdvertCategory::withTrashed()->whereIn('id', $id)->forceDelete();
            foreach ($id as  $value) {
                Article::withTrashed()->where('advertCategory_id', $value)->forceDelete();
            }

            return redirect()->back()->with('success', '永久删除成功！');

        } catch (Exception $e) {

            return redirect()->back()->with('error', '永久删除失败！');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        //find the id advertCategory
        $article = AdvertCategory::withTrashed()->find($id);

        //restore the id advertCategory
        if ($article->restore()) {
            return redirect()->back()->with('success', '恢复成功！');

        } else {
            return redirect()->back()->with('error', '恢复失败！');
        }
    }


}