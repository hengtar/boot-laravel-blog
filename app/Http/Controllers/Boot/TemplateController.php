<?php
/**
 * Created by PhpStorm.
 * template: Administrator
 * Date: 2018\11\2 0002
 * Time: 13:02
 */

namespace App\Http\Controllers\Boot;

use App\Http\Requests\StoreRole;
use App\Models\Permission;
use App\Models\RoleHasPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use App\Models\Template;

class TemplateController extends CommonController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type = null, $order = null, $search = null)
    {


        //builder
        $builder = Template::query();



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

        //template value
        $templates = $builder->paginate(10);


        return view('boot.template.index', [
            'TemplateOrm' => new Template(),
            'templates' => $templates,
            'search' => $search,
            'order' => $order,
            'type' => $type,
        ]);
    }
}