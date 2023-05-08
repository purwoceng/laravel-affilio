<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('profile.detail',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => '|string|min:4',
            'name' => '|string|min:4',
        ]);

        if (empty($id)) {
            return back()->with('error', 'Member Id Not found !!!');
        }

        $results =  User::where('id', $id)->update([
            'password' => Hash::make($request->password),
            'username' => ($request->username),
            'name' => ($request->name),
        ]);



        if ($results) {
            return back()->with('success', 'Pengaturan User telah berhasil diubah');
        } else {
            return back()->with('info', 'Gagal mengubah data');
        }
    }
}
