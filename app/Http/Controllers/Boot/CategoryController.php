<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;


use App\Http\Requests\StoreArticle;
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

        //article value
        $categorys = $builder->paginate(10);



        return view('boot.category.index', [
            'categoryOrm' => new Category(),
            'categorys' => $categorys,
            'recover' => $recover,
            'search' => $search,
            'order' => $order,
            'type' => $type,
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
        //view show recommend and status
        $articles = new Category();

        //all category
        $category = Category::all('id', 'category');

        return view('boot.category.create', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        //get request
        $param = $request->toArray();

        //format article key => value
        $param['views'] = $param['views'] == null ? rand(100, 500) : $param['views'];
        $param['sort']  = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['tips']  = 'aslkdjflsakdjfk';

        //create article key => value
        $result = Category::create($param);

        //save article
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('article-index')]);
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
        //view show recommend and status
        $articles = new Article();

        //find the id show article info
        $articles = $articles->find($id);

        //all category
        $category = Category::all('id', 'category');

        return view('boot.category.edit', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreArticle $request)
    {

        //get request
        $param = $request->toArray();

        //format article key => value
        $param['views'] = $param['views'] == null ? rand(100, 500) : $param['views'];
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['photo'] = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];
        $param['tips']  = 'aslkdjflsakdjfk';

        //create article key => value
        $article = Category::find($param['id']);

        //save article
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('article-index')]);
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

        // databases operating
        if (Category::destroy($id)) {

            return redirect()->back()->with('success', '删除成功！');
        } else {

            return redirect()->back()->with('error', '删除失败！');
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
        //format delete id
        $id = FormatDelete($id);

        // databases operating
        if (Category::withTrashed()->whereIn('id', $id)->forceDelete()) {
            return redirect()->back()->with('success', '永久删除成功！');
        } else {
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
        //find the id article
        $article = Category::withTrashed()->find($id);

        //restore the id article
        if ($article->restore()) {
            return redirect()->back()->with('success', '恢复成功！');
        } else {
            return redirect()->back()->with('error', '恢复失败！');
        }
    }


}