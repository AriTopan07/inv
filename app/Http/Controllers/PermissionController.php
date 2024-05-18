<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\Action;
use App\Models\ActionGroup;
use App\Models\MasterAction;
use App\Models\MenuSection;
use App\Http\Repository\MenuRepository;
use App\Http\Repository\PermissionRepository;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $menu;
    protected $permission;

    public function __construct(MenuRepository $menu, PermissionRepository $permission)
    {
        $this->menu = $menu;
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/group');
            return $next($request);
        });
    }

    public function data_akses($id)
    {
        $groups = Group::find($id);
        $master_action = MasterAction::get();
        $menus = $this->menu->get_all_menu();
        $menu_sections = MenuSection::get();

        return view('group.permission', compact('groups', 'master_action', 'menus', 'menu_sections'));
    }


    public function edit_akses(Request $request, Action $actions, ActionGroup $actionGroups)
    {
        $this->permission->actionId($request, $actions, $actionGroups);

        return response()->json([
            'status'  => 'success',
            'message' => 'Akses berhasil di ubah.'
        ]);
    }

    public function all_access(Request $request)
    {
        $this->permission->all_access($request);

        return response()->json([
            'status'  => 'success',
            'message' => 'Akses berhasil di ubah.'
        ]);
    }
}
