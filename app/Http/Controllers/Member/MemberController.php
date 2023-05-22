<?php

namespace App\Http\Controllers\Member;

use App\Exports\MemberExport;
use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberAddress;
use App\Repositories\Member\MemberRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //nganggo iki yo iso
        // $getMemberBlockeds = Member::with('member_addresses')->where('id')->where('publish', 1)->get();

        // $getMemberBlockeds = DB::table('members')->where('members.publish','1')
        //                     ->join('member_addresses','members.id', '=', 'member_addresses.member_id')
        //                     ->get();
        $getMemberBlockeds = DB::table('members')
            ->leftjoin('member_addresses', 'members.id', '=', 'member_addresses.member_id')
            ->where('members.publish', '1')
            ->get();

        $member_type = MemberType::get();
        if ($request->ajax()) {
            return $this->memberRepository->getDataTable($request);
        }
        return view('members.member.index', compact('member_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Member::findOrFail($id);
        $isMemberExists = !!$data;

        return view('members.member.detail', compact('data', 'isMemberExists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Member::findOrFail($id);

        if ($data) {
            $member_types = MemberType::whereNull('deleted_at')->get();

            return view(
                'members.member.edit',
                compact('data', 'member_types'),
            );
        } else {
            return redirect()
                ->route('members.member.index')
                ->with([
                    'error' => "Gagal mengedit data - member dengan id {$id} tidak ditemukan.",
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $regex_phone = '/^(\+62|62|0)8[1-9][0-9]{6,9}$/';
        $validation_messages = [
            'name.required' => 'Nama member wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email tidak tersedia atau telah dipakai oleh member lain',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username tidak tersedia atau telah dipakai oleh member lain',
            'phone.required' => 'Nomor Telepon / HP tidak valid!',
            'phone.regex' => 'Nomor telepon / HP harus diisi dengan nomor telepon indonesia',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',
            'image.image' => 'File yang diinput wajib gambar!',
            'image.mimes' => 'Gambar yang diinput wajib berformat PNG atau JPEG!',
            'image.max' => 'Gambar maksimal berukuran 2MB!',
            'image.dimensions' => 'Resolusi gambar maksimal 1000 pixel!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'email' => [
                    'required',
                    'email:dns',
                    Rule::unique('members', 'email')
                        ->ignore($id),
                ],
                'username' => [
                    'required',
                    Rule::unique('members', 'username')
                        ->ignore($id),
                ],
                'phone' => ['required', "regex:{$regex_phone}"],
                'member_type_id' => [
                    'required',
                    Rule::exists('member_types', 'id'),
                ],
                'image' => [
                    'nullable',
                    'image',
                    'mimes:jpg,png,jpeg',
                    'max:2048',
                    'dimensions:max_width=1000,max_height=1000',
                ],
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::findOrFail($id);
        $member->name = $request->name;
        $member->email = $request->email;
        $member->username = $request->username;
        $member->phone = $request->phone;
        $member->member_type_id = $request->member_type_id;
        // $member->referral = $request->referral;
        $member->is_founder = $request->is_founder;
        $member->is_transaction = $request->is_transaction;


        $image = $request->file('image');

        if ($image) {
            $new_file_name = 'profile_pic_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/category/'), $new_file_name);
            $member->image = 'member/' . $new_file_name;
        }

        $member->save();

        if ($member) {
            return redirect()
                ->route('members.index')
                ->with([
                    'success' => 'Berhasil memperbarui data member.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat memperbarui data. Mohon coba kembali!'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // public function exportexcel(Request $request)
    // {
    //     $dateRange = [];
    //     $status = '';

    //     if (isset($request->daterange1)) {
    //         $dateRange = explode('-', $request->daterange1);
    //         $dateRange = array_map(function ($item) {
    //             $date = trim($item);
    //             $date = strtotime($date);
    //             $date = date('Y-m-d H:i:s', $date);

    //             return $date;
    //         }, $dateRange);
    //     }

    //     if (isset($request->status1)) {
    //         $status = $request->status1;
    //     }

    //     return Excel::download(new MemberExport($status, $dateRange), 'member.xlsx');
    // }

    public function network($id)
    {
        $avatars = [
            url('/static/avatars/avatar-1.jpg'),
            url('/static/avatars/avatar-2.jpg'),
            url('/static/avatars/avatar-3.jpg'),
            url('/static/avatars/avatar-4.jpg'),
            url('/static/avatars/avatar-5.jpg'),
        ];

        $member = $this->memberRepository->getDataById($id);
        $first_gen_members = $this->memberRepository->getDownline($member->id);
        $downlines = [];

        foreach ($first_gen_members as $gen_one) {
            $second_gen_members = $this->memberRepository->getDownline($gen_one->member_id, $member->id);
            $gen_one_downlines = [];

            foreach ($second_gen_members as $gen_two) {
                $third_gen_members = $this->memberRepository->getDownline($gen_two->member_id, $member->id);
                $gen_two_downlines = [];

                foreach ($third_gen_members as $gen_three) {
                    $gen_two_downlines[] = [
                        'id' => $gen_three->member_id,
                        'name' => $gen_three->name,
                        'member_type_id' => $gen_three->member_type_id,
                        'member_type' => $gen_three->type ?? '',
                        'image' => $avatars[rand(0, count($avatars) - 1)],
                    ];
                }

                $gen_one_downlines[] = [
                    'id' => $gen_two->member_id,
                    'name' => $gen_two->name,
                    'member_type_id' => $gen_two->member_type_id,
                    'member_type' => $gen_two->type ?? '',
                    'image' => $avatars[rand(0, count($avatars) - 1)],
                    'downlines' => $gen_two_downlines,
                ];
            }

            $downlines[] = [
                'id' => $gen_one->member_id,
                'name' => $gen_one->name,
                'member_type_id' => $gen_one->member_type_id,
                'member_type' => $gen_one->type ?? '',
                'image' => $avatars[rand(0, count($avatars) - 1)],
                'downlines' => $gen_one_downlines,
            ];
        }

        $networks = [
            'id' => $member->id,
            'name' => $member->name,
            'member_type_id' => $member->member_type_id,
            'member_type' => $member->member_type->type ?? '',
            'image' => $avatars[rand(0, count($avatars) - 1)],
            'downlines' => $downlines,
        ];

        return view('members.member.network', compact('member', 'networks'));
    }
}
