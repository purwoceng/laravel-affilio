<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MemberResetPassword extends Controller
{

    public function resetPassword($id)
    {
        $data = Member::where('id', $id)->first();
        return view('members.reset-password.edit', compact(['data']));
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        if (empty($id)) {
            return back()->with('error', 'Member Id Not found !!!');
        }

        $results =  Member::where('id', $id)->update([
            'hash' => Hash::make($request->password),
        ]);

        if ($results) {
            return back()->with('success', 'Password has been successfully changed!');
        } else {
            return back()->with('error', 'Failed Change new password !');
        }
    }
}
