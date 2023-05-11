<?php

namespace App\Http\Controllers\Member;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MemberResetPin extends Controller
{
    public function resetPin($id)
    {
        $data = Member::where('id',$id)->first();
        return view('members.reset-pin.edit', compact(['data']));
    }

    public function updatePin(Request $request, $id)
    {
        $request->validate([
            'kode_pin' => 'required|string|min:6|max:6',
        ]);

        if (empty($id)) {
            return back()->with('error', 'Member Id Not found !!!');
        }

        $results = DB::table('pins')->where('id_member', $id)->update([
            'pin' => Hash::make($request->kode_pin),
        ]);

        if ($results) {
            return back()->with('success', 'Pin has been successfully changed!');
        } else {
            return back()->with('error', 'Failed Change new pin !');
        }
    }
}
