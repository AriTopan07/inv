<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Repository\GroupRepository;
use App\Http\Repository\PermissionRepository;
use App\Models\Group;
use App\Models\UserGroup;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    protected $group, $permission;

    public function __construct(GroupRepository $group, PermissionRepository $permission)
    {
        $this->group = $group;
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/group');
            return $next($request);
        });
    }

    public function index()
    {
        // if ($this->permission->cekAkses(Auth::user()->id, "Group", "view") !== true) {
        //     return view('error.403');
        // }

        $data = $this->group->group();

        return view('group.list', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);

        $this->group->store($request);

        Alert::success('Success', 'Berhasil ditambahkan');
        return redirect()->back();
    }

    public function show($id)
    {
        $data = $this->group->detail_group($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data group',
            'data'    => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $data = $this->group->update($request, $id);

        Alert::success('Success', 'Berhasil ditambahkan');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $data = Group::findOrFail($id);

        if (UserGroup::where('group_id', $data->id)->exists()) {

            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus, Data sedang digunakan!',
            ]);
        } else {
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus',
            ]);
        }
    }
}
