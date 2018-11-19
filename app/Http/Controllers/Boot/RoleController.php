<?php
/**
 * Created by PhpStorm.
 * Role: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreRole;
use Illuminate\Http\Request;
use Mockery\Exception;
use App\Models\Role;

class RoleController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {


        //builder
        $builder = Role::query();



        //order
        if ($type && $order) {
            $builder->orderBy($type, $order);
        } else {
            $builder->orderBy('created_at', 'desc');
        }

        //search
        if ($search) {
            $builder->where('name', 'like', '%' . $search . '%');
        }

        //Role value
        $Roles = $builder->paginate(10);


        return view('boot.role.index', [
            'RoleOrm' => new Role(),
            'Roles' => $Roles,
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
                    return redirect()->back()->with('error', 'ID：' . $key . '排序值错误!');
                }
                Role::where('id', $key)->update(['sort' => $value]);
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
        return view('boot.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRole $request)
    {
        //get request
        $param = $request->toArray();

        //format Role key => value
        $param['sort']   = $param['sort']  == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;

        //create Role key => value
        $result = Role::create($param);

        //save Role
        if ($result->save()) {
            return response()->json(['success' => true, 'url' => route('role-index')]);
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

        return view('boot.role.edit', [
            'role' => Role::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRole $request)
    {

        //get request
        $param = $request->toArray();

        //format Role key => value
        $param['sort']  = $param['sort'] == null ? 50 : $param['sort'];
        $param['status'] = empty($param['status'])  ? 0 : 1;


        //create Role key => value
        $article = Role::find($param['id']);

        //save Role
        if ($article->update($param)) {

            return response()->json(['success' => true, 'url' => route('role-index')]);
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
        if (Role::destroy($id)) {
            return redirect()->back()->with('success', '删除成功！');

        } else {
            return redirect()->back()->with('error', '删除失败！');

        }
    }

}