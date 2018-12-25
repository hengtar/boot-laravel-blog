<?php

namespace App\Http\Controllers\Boot;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeo;
use App\Http\Requests\StoreUser;
use App\Models\Config;
use App\Models\User;
use Illuminate\Http\Request;


class ConfigController extends Controller
{

    /**
     * [seo]
     * @Notes  : [ seo ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\12\25 0025 -- 14:55
     * @return   \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seo()
    {
        $config = [];
        foreach (Config::all() as $k => $v) {
            $config[trim($v['key'])] = $v['value'];
        }

        return view('boot.config.seo', [
            'config' => (object)$config,
        ]);
    }

    /**
     * [store]
     * @Notes  : [ save seo ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\12\25 0025 -- 14:55
     * @param StoreSeo $request
     * @return   \Illuminate\Http\JsonResponse
     */
    public function store(StoreSeo $request)
    {
        try {
            $param = $request->toArray();

            unset($param['_token']);
            unset($param['file']);

            foreach ($param as $key => $value) {
                Config::where('key', $key)->update(['value' => $value]);
            }

            return response()->json(['success' => true, 'msg' => '设置成功', 'url' => route('config-seo')]);

        } catch (\Exception $e) {

            return response()->json(['success' => false, 'msg' => '设置失败', 'url' => route('config-seo')]);

        }
    }


    /**
     * [admin]
     * @Notes  : [ admin ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\12\25 0025 -- 14:55
     * @param Request $request
     * @return   \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin(Request $request)
    {
        return view('boot.config.admin', [
            'user' => $request->users,
        ]);
    }

    /**
     * [admin_store]
     * @Notes  : [ save admin ]
     * @Author : [lao.zh-ang] [852952656@qq.com]
     * @Time   : 2018\12\25 0025 -- 14:55
     * @param StoreUser $request
     * @return   \Illuminate\Http\JsonResponse
     */
    public function admin_store(StoreUser $request)
    {
        //get request
        $param = $request->toArray();

        $userInfo = User::find($param['id']);

        if ($userInfo->password !== $param['password']) $param['password'] = bcrypt($param['password']);

        //use transaction add roles and users
        if ($userInfo->update($param)) {

            return response()->json(['success' => true, 'msg' => '编辑成功', 'url' => route('config-admin')]);

        } else {

            return response()->json(['success' => false, 'msg' => '编辑失败，请重试！']);

        }
    }


}
