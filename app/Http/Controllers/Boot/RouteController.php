<?php
/**
 * Created by PhpStorm.
 * Route: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreRoute;
use App\Http\Requests\StorePermission;
use App\Models\Template;
use Illuminate\Http\Request;
use Mockery\Exception;
use App\Models\Route;

class RouteController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {


        //builder
        $builder = Route::query();

        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('Route', 'like', '%' . $search . '%');
        }

        //Route value
        $routes = $builder->get();

        return view('boot.route.index', [
            'routeOrm' => new Route(),
            'routes' => list_to_tree_parent($routes->toArray()),
            'routesTree' => treeParent($routes->toArray()),
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

                Route::where('id', $key)->update(['sort' => $value]);
            }

            return redirect()->back()->with('success', '排序成功!');

        } catch (Exception $e) {

            return redirect()->back()->with('error', '排序失败!');
        }
    }

    /**
     * Show the form for creating a new reso urce.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes = treeParent(Route::all('id', 'title','parent_id'));

        $templates = Template::all('id','name');
        return view('boot.route.create', [
            //view show recommend and status
            'routes' => $routes,
            'templates' => $templates,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoute $request)
    {
        //get request
        $param = $request->toArray();



        //format Route key => value
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;
       // dd($param);
        //create Route key => value
        $template =  Template::where('id',$param['template_id'])->first();

        $param['route'] = '/'.$template->route.'/'.$param['id'];


        $result = Route::create($param);

        //save Route
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('route-index')]);
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

        return view('boot.route.edit', [
            'Route'  => Route::find($id),
            'permissions' => tree(Route::all('id', 'chinese_name','p_id'))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePermission $request)
    {
        //get request
        $param = $request->toArray();

        //format Route key => value
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create Route key => value
        $article = Route::find($param['id']);

        //save Route
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('Route-index')]);
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
        if (Route::destroy($id)) {

            return redirect()->back()->with('success', '删除成功！');
        } else {

            return redirect()->back()->with('error', '删除失败！');
        }
    }

}