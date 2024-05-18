<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = Auth::check() ? Auth::user()->id : null;

        if ($userId) {
            $user = User::find($userId);

            if ($user) {
                return view('profile.index', compact('user'));
            } else {
                return redirect()->route('home')->with('error', 'User not found.');
            }
        } else {
            return redirect()->route('login')->with('error', 'User not authenticated.');
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current_password' => 'required|string',
            'new_password' => 'required|confirmed|min:8|string'
        ]);

        #Match The Old Password
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            Alert::error('Error', 'Kata sandi saat ini tidak valid.');
            return redirect()->back();
        }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        Alert::success('Success', 'Kata sandi berhasil diubah.');
        return redirect()->back();
    }
}
