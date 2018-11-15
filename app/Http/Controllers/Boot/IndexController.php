<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IndexController extends CommonController
{
    public function index()
    {
        return view('boot.common.common');
    }

    public function show(Request $request)
    {

        return view('boot.index.show');


    }
}