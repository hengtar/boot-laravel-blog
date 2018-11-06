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
use App\Models\ArticleCategory;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Deprecated;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $articles = Article:: with('category')
                           ->orderBy('created_at','desc')
                           ->paginate(10);

       return view('boot.article.index', [
           'articles' => $articles,
           ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $articles = new Article();

        $category = ArticleCategory::all('id','category');

        return view('boot.article.create', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        $param = $request ->toArray();

        $param['views']     =  !empty($param['vies']) ? rand(100,500)                     : $param['views'];
        $param['sort']      =  !empty($param['sort']) ? 50                                : $param['sort'];
        $param['photo']     =  empty($param['photo']) ? "/static/boot/img/no_img.jpg"    : $param['photo'];
        $param['tips']      = 'aslkdjflsakdjfk';


        $result             =  Article::create($param);

        if ($result -> save()){

            return response()->json(['success' => true,'url' => route('article-index')]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Article::destroy($id)){
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteForce($id)
    {
        if (Article::forceDelete($id)){
            return redirect()->back();
        }
    }


}