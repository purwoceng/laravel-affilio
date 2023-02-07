<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\MemberAccount;
use App\Repositories\Member\MemberAccountRepository;
use Illuminate\Http\Request;

class MemberAccountController extends Controller
{
    private $memberAccountRepository;

    public function __construct(MemberAccountRepository $memberAccountRepository)
    {
        $this->memberAccountRepository = $memberAccountRepository;
    }


    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->memberAccountRepository->getDataTable($request);
        }

        return view('members.account.index');
    }


    public function verification(Request $request)
    {
        if (!empty($request->id)) {

            $data = [
                'publish' => 1,
            ];
            MemberAccount::where('id',$request->id)->update($data);
            return response()->json([
                'status' => 'true',
                'title' => 'Berhasil aktivasi',
                'message' => 'Berhasil melakukan aktivasi data rekening',
                'icon' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'title' => 'Gagal Aktivasi !!',
                'message' => 'Gagal melakukan aktivasi data rekening',
                'icon' => 'warning',
            ]);
        }
    }
}
