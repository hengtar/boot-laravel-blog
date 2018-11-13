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
            $config[trim($v['key'])]   = $v['value'];
        }

        return view('boot.config.seo',[
            'config' => (object)$config,
        ]);
    }

    public function store(StoreSeo $request)
    {
        $param = $request -> toArray();
        dd($param);
    }
}
