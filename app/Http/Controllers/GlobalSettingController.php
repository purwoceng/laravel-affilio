<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\content\GlobalSettingRepository;

class GlobalSettingController extends Controller
{
    protected $GlobalSettingRepository;

    public function __construct(GlobalSettingRepository $GlobalSettingRepository)
    {
        $this->GlobalSettingRepository = $GlobalSettingRepository;
    }

    public function index(Request $request)
    {
    }
    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $this->GlobalSettingRepository->getDataById(1);
        return view('content.globalsetting.edit', compact(['data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // dd();
        // exit;

        $messages = [
            'globalsetting.required' => 'Markup tidak boleh kosong',
            'globalsetting.unique' => 'Markup sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric|min:10|max:1000',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $global_settings = $request->value;

        $updateData = [
            'value' => $global_settings,
        ];

        $result = $this->GlobalSettingRepository->update(1, $updateData);

        if ($result) {
            return redirect()->route('markup.edit')
                ->with('success', 'Data Markup telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data markup');
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
    }
}
