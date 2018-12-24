<?php
/**
 * Created by PhpStorm.
 * BootMenu: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreMenu;
use App\Http\Requests\StorePermission;
use Illuminate\Http\Request;
use Mockery\Exception;
use App\Models\BootMenu;

class MenuController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {


        //builder
        $builder = BootMenu::query();

        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('BootMenu', 'like', '%' . $search . '%');
        }

        //BootMenu value
        $menus = $builder->get();

        return view('boot.menu.index', [
            'menuOrm' => new BootMenu(),
            'menus' => list_to_tree_parent($menus->toArray()),
            'menusTree' => treeParent($menus->toArray()),
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

                BootMenu::where('id', $key)->update(['sort' => $value]);
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
        $menus = treeParent(BootMenu::all('id', 'title','parent_id'));

        return view('boot.menu.create', [
            //view show recommend and status
            'menus' => $menus,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenu $request)
    {
        //get request
        $param = $request->toArray();


        //format BootMenu key => value
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;
       // dd($param);
        //create BootMenu key => value
        $result = BootMenu::create($param);

        //save BootMenu
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('menu-index')]);
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

        return view('boot.menu.edit', [
            'BootMenu'  => BootMenu::find($id),
            'permissions' => tree(BootMenu::all('id', 'chinese_name','p_id'))
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

        //format BootMenu key => value
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create BootMenu key => value
        $article = BootMenu::find($param['id']);

        //save BootMenu
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('BootMenu-index')]);
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
        if (BootMenu::destroy($id)) {

            return redirect()->back()->with('success', '删除成功！');
        } else {

            return redirect()->back()->with('error', '删除失败！');
        }
    }

}