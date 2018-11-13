<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreCategory;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Mockery\Exception;

class CategoryController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($recover = false, $type = null, $order = null, $search = null)
    {

        //builder
        $builder = Category::query();

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

        //category value
        $categorys = $recover || $search ?  $builder->get() : tree($builder->get());


        return view('boot.category.index', [
            'categoryOrm'   => new Category(),
            'categorys'     => $categorys,
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


                Category::withTrashed()->where('id', $key)->update(['sort' => $value]);
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
        //all category
        $category = tree(Category::all('id', 'category','p_id'));

        return view('boot.category.create', [
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        //get request
        $param = $request->toArray();

        //format category key => value
        $param['sort']  = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create category key => value
        $result = Category::create($param);

        //save category
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('category-index')]);
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
        //all category
        $category_list = tree(Category::all('id', 'category','p_id'));

        //find category info
        $category = Category::find($id);

        return view('boot.category.edit', [
            'category'      => $category,
            'category_list' => $category_list,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request)
    {

        //get request
        $param = $request->toArray();

        //format category key => value
        $param['sort']  = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create category key => value
        $Category = Category::find($param['id']);

        //save category
        if ($Category->update($param)) {

            return response()->json(['success' => true, 'url' => route('category-index')]);
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

            if (Category::where('p_id',$value)->first()){
                return redirect()->back()->with('error', '删除失败！当前ID:' . $value .'还存在下级分类');
            }else{
                // databases operating
                if (Category::destroy($value)) {

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
            Category::withTrashed()->whereIn('id', $id)->forceDelete();
            foreach ($id as  $value) {
                Article::withTrashed()->where('category_id', $value)->forceDelete();
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
        //find the id category
        $article = Category::withTrashed()->find($id);

        //restore the id category
        if ($article->restore()) {
            return redirect()->back()->with('success', '恢复成功！');

        } else {
            return redirect()->back()->with('error', '恢复失败！');
        }
    }


}