<?php

namespace App\Http\Controllers\Boot;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeo;
use App\Models\Config;
use Illuminate\Http\Request;


class ConfigController extends Controller
{

    public function seo()
    {
        $config = [];
        foreach (Config::all() as $k => $v) {
            $config[trim($v['key'])]  = $v['value'];
        }

        return view('boot.config.seo',[
            'config' => (object)$config,
        ]);
    }

    public function store(StoreSeo $request)
    {
        try{
            $param = $request -> toArray();

            unset($param['_token']);
            unset($param['file']);

            foreach ($param as $key =>$value){
                Config::where('key',$key)->update(['value' => $value]);
            }

            return response()->json(['success' => true, 'msg' => '设置成功', 'url' => route('config-seo')]);
        }catch (\Exception $e){
            return response()->json(['success' => false, 'msg' => '设置失败', 'url' => route('config-seo')]);
        }
    }


    public function admin()
    {
        return view('boot.config.admin');
    }


}
