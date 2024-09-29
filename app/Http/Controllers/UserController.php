<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\userRepository;
use App\Http\Repository\PermissionRepository;
use App\Models\Group;
use App\Models\UserGroup;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $user, $permission;

    public function __construct(UserRepository $user, PermissionRepository $permission)
    {

        $this->user = $user;
        $this->permission = $permission;
        $this->middleware(function ($request, $next) {
            Session::put('active', '/user');
            return $next($request);
        });
    }

    public function index()
    {
        if ($this->permission->cekAkses(Auth::user()->id, "User", "view") !== true) {
            return view('error.403');
        }

        $data = $this->user->user();
        $group = Group::get();

        return view('user.list', compact('data', 'group'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->first());
            return redirect()->back();
        }

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            Alert::error('Error', 'Email sudah terdaftar.');
            return redirect()->back();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $group_id = $request->group_id;
        $user_id = $user->id;

        UserGroup::create([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ]);

        Alert::success('Success', 'Berhasil ditambahkan.');
        return redirect()->back();
    }

    public function show($id)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail data',
            'data' => $this->user->detail_user($id)
        ]);
    }

    public function destroy($id)
    {
        $data = User::find($id);

        $data->delete();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Berhasil dihapus'
        ]);
    }

    public function changeStatus($id)
    {
        $item = User::find($id);

        if (!$item) {
            Toast('User tidak ditemukan.', 'error')->width('400px');
            return redirect()->back();
        }

        $item->status = ($item->status == 1) ? 0 : 1;
        $item->save();

        Toast('Status berhasil diubah.', 'success')->width('400px');
        return redirect()->back();
    }
}
