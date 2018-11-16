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
        $Permissions = $builder->paginate(10);


        return view('boot.Permission.index', [
            'PermissionOrm' => new Permission(),
            'Permissions' => $Permissions,
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
        return view('boot.Permission.create', [
            //view show recommend and status
            'Permission' => new Permission(),
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
        $param['views']  = $param['views'] == null ? rand(100, 500) : $param['views'];
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create Permission key => value
        $result = Permission::create($param);

        //save Permission
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('Permission-index')]);
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
        $Permission = new Permission();

        //find the id show Permission info
        $Permission = $Permission->find($id);

        return view('boot.Permission.edit', [
            'Permission' => $Permission,
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
        $param['views'] = $param['views'] == null ? rand(100, 500) : $param['views'];
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;


        //create Permission key => value
        $article = Permission::find($param['id']);

        //save Permission
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('Permission-index')]);
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
        if (Permission::withTrashed()->whereIn('id', $id)->forceDelete()) {
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
        //find the id Permission
        $builder = Permission::withTrashed()->find($id);

        if ($builder->restore()) {
            return redirect()->back()->with('success', '恢复成功！');
        } else {
            return redirect()->back()->with('error', '恢复失败！');
        }
    }


}