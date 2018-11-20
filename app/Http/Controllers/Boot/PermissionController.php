<?php
/**
 * Created by PhpStorm.
 * Permission: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StorePermission;
use Illuminate\Http\Request;
use Mockery\Exception;
use App\Models\Permission;

class PermissionController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {


        //builder
        $builder = Permission::query();

        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('Permission', 'like', '%' . $search . '%');
        }

        //Permission value
        $Permissions = $builder->get();


        return view('boot.Permission.index', [
            'PermissionOrm' => new Permission(),
            'Permissions' => tree($Permissions),
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

                Permission::withTrashed()->where('id', $key)->update(['sort' => $value]);
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
        $permissions = tree(Permission::all('id', 'chinese_name','p_id'));

        return view('boot.Permission.create', [
            //view show recommend and status
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermission $request)
    {
        //get request
        $param = $request->toArray();

        //format Permission key => value
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create Permission key => value
        $result = Permission::create($param);

        //save Permission
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('permission-index')]);
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

        return view('boot.Permission.edit', [
            'permission'  => Permission::find($id),
            'permissions' => tree(Permission::all('id', 'chinese_name','p_id'))
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

        //format Permission key => value
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create Permission key => value
        $article = Permission::find($param['id']);

        //save Permission
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('permission-index')]);
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
        if (Permission::destroy($id)) {

            return redirect()->back()->with('success', '删除成功！');
        } else {

            return redirect()->back()->with('error', '删除失败！');
        }
    }

}