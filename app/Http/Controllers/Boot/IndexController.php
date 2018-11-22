<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Models\BootMenu;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IndexController extends CommonController
{

    public function index(Request $request)
    {

        return view('boot.common.common',[
            'menu' => $request -> menu,
            'user' => $request -> users,
        ]);
    }



    public function show(Request $request)
    {

        return view('boot.index.show');

    }
}