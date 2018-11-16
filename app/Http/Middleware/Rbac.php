<?php

namespace App\Http\Middleware;

use App\Models\BootMenu;
use Closure;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class Rbac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {

          /*
          |--------------------------------------------------------------------------
          | Auth Permission
          |--------------------------------------------------------------------------
          |
          | 但false对$user->hasDirectPermission('edit articles')。
          | 如果为应用程序中的角色和用户设置权限并希望限制或更改用户角色的继承权限（即，仅允许更改用户的直接权限），则此方法非常有用。
          | 您可以列出所有这些权限：
          | 直接权限
          | $user -> getDirectPermissions() 或 $user-> permissions;
          | 从用户角色继承的权限
          | $user -> getPermissionsViaRoles();
          | 所有适用于用户的权限（继承和直接）
          | $user -> getAllPermissions();
          | 所有这些响应都是Spatie\Permission\Models\Permission对象的集合。
          |
          */

        if (config('auth.auth_permission.auth')){

            $user = Auth::user();
            $user ->assignRole('editor');
            if ($user -> hasRole('super-admin')){
                $menu = BootMenu::all()->toArray();
            }else {
                $permissions = $user->getPermissionsViaRoles()->toArray();
                foreach ($permissions as $key => $v) {
                    $permission[] = $v['name'];
                }

                $menu = BootMenu::whereIn('route', $permission)->get()->toArray();

                $route = strtolower($request->route()->getAction()['as']);

                $permission = $this->noAuth($permission);

                if (!in_array($route, $permission))
                    if ($request->ajax()) {
                        return response()->json(['success' => false, 'msg' => '您暂未获取当前的操作权限!']);
                    } else {
                        return redirect()->back()->with('error', '您暂未获取当前的操作权限!');
                    }


            }


        }else{
            $menu = BootMenu::all()->toArray();
        }


        $request -> menu  = prepareMenu($menu);

        return $next($request);
    }


    public function noAuth($permission)
    {
        $permission[] = 'boot';
        $permission[] = 'show';

        return $permission;
    }
}
