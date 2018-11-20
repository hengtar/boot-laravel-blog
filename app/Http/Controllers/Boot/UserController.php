<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreUser;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {
        //builder
        $builder = User::query();

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

        //User value
        $Users = $builder->paginate(10);

        return view('boot.user.index', [
            'UserOrm' => new User(),
            'RoleOrm' => new \App\Models\Role(),
            'Users' => $Users,
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

                User::where('id', $key)->update(['sort' => $value]);
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
        return view('boot.user.create', [
            //view show recommend and status
            'User' => new User(),
            'roles' => $this->getAllRole(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        //get request
        $param = $request->toArray();

        //format User key => value
        $param['sort']   = 50;
        $param['status'] = empty($param['status'])  ? 0 : 1;
        $param['password'] =bcrypt($param['password']);

        //use transaction add roles and users

        DB::beginTransaction();

        try{
            //create User key => value
            $result = User::create($param);
            $result->save();

            $auth = ['role_id' => $param['role_id'],'model_type' =>'App\User','model_id' => $result->id];
            DB::table('model_has_roles')->insert($auth);

            DB::commit();
        }catch (QueryException $exception){
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => '添加失败，请重试！']);
        }

        return response()->json(['success' => true, 'url' => route('user-index')]);

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
        $User = new User();

        //find the id show User info
        $user = $User->find($id);

        return view('boot.user.edit', [
            'user' => $user,
            'roles' => $this->getAllRole(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUser $request)
    {

        //get request
        $param = $request->toArray();

        //format User key => value
        $param['sort']   = 50;
        $param['status'] = empty($param['status'])  ? 0 : 1;

        $userInfo = User::find($param['id']);


        if ($userInfo -> password !== $param['password']) $param['password'] = bcrypt($param['password']);

        //use transaction add roles and users
        DB::beginTransaction();

        try{
            //create User key => value
            $userInfo -> update($param);

            $auth = ['role_id' => $param['role_id'],'model_type' =>'App\User'];
            DB::table('model_has_roles')->where('model_id',$param['id'])->update($auth);

            DB::commit();
        }catch (QueryException $exception){
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => '编辑失败，请重试！']);
        }

        return response()->json(['success' => true, 'url' => route('user-index')]);
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
        if (User::destroy($id)) {
            DB::table('model_has_roles')->whereIn('model_id',$id)->delete();
            return redirect()->back()->with('success', '删除成功！');
        } else {

            return redirect()->back()->with('error', '删除失败！');
        }
    }


    /**
     * [getAllRole]
     * @Notes  : [ getAllRole ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\11\19 0019 -- 15:47
     * @return   \Illuminate\Support\Collection
     */
    public function getAllRole()
    {
        return DB::table('roles')->get();
    }


}