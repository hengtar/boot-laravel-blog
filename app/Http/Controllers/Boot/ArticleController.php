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

class ArticleController extends CommonController
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($recover = false, $type = null, $order = null, $search = null)
    {

        //builder
        $builder = Article::query();

        //recover status
        if ($recover) {
            $builder->onlyTrashed();
        } else {
            $builder->with(['category' => function($query){
                $query -> select('id','category');
            }]);
        }

        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('title', 'like', '%' . $search . '%');
        }

        //article value
        $articles = $builder->paginate(10);

        return view('boot.article.index', [
            'articleOrm' => new Article(),
            'articles' => $articles,
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

                Article::withTrashed()->where('id', $key)->update(['sort' => $value]);
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
        $articles = new Article();

        //all category
        $category = tree(Category::all('id', 'category','p_id'));

        return view('boot.article.create', [
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
        $param['views']  = $param['views'] == null ? rand(100, 500) : $param['views'];
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['photo']  = $param['photo'] == null ? "/static/boot/img/no_img.jpg" : $param['photo'];

        $param['status'] = empty($param['status'])  ? 0 : 1;
        $param['tips']   = 'aslkdjflsakdjfk';

        //create article key => value
        $result = Article::create($param);

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
        $category = tree(Category::all('id', 'category','p_id'));

        return view('boot.article.edit', [
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
        $param['status'] = empty($param['status'])  ? 0 : 1;
        $param['tips']  = 'aslkdjflsakdjfk';

        //create article key => value
        $article = Article::find($param['id']);

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
        if (Article::destroy($id)) {

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
        if (Article::withTrashed()->whereIn('id', $id)->forceDelete()) {
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
        $builder = Article::query();
        $builder -> withTrashed();

        //validate category deleted
        $category = Category::withTrashed()->where('id',$builder ->find($id)['category_id'])->first();

        //restore the id article
        if ($category -> deleted_at) {
            $result = ['success' => false, 'msg' => '此分类已被删除，如恢复数据，请先恢复分类'];

        } else {
            if ($builder ->restore()){
                $result = ['success' => true, 'url' => route('article-index'), 'msg' => '成功'];

            }else{
                $result = ['success' => false, 'url' => route('article-index'), 'msg' => '恢复失败'];
            }
        }

        return response()->json($result);
    }


}