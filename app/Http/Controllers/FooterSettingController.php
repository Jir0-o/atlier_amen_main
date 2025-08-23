<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FooterSetting;
use DataTables;
use Cache;
use Yajra\DataTables\Facades\DataTables as FacadesDataTables;

class FooterSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can Access Settings')->only('index', 'data', 'show', 'update');
    }
    public function index()
    {
        return view('backend.settings.footer');
    }

    public function data()
    {
        // Single row, but DataTables-friendly
        $q = FooterSetting::query();
        return FacadesDataTables::of($q)
            ->addIndexColumn()
            ->addColumn('action', fn(FooterSetting $fs) =>
                '<button type="button" class="btn btn-sm btn-primary btn-edit" data-id="'.$fs->id.'">Edit</button>'
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show()
    {
        $fs = FooterSetting::current();
        if (!$fs) {
            // auto-create if somehow missing
            $fs = FooterSetting::create([]);
        }
        return response()->json($fs);
    }

    public function update(Request $request)
    {
        $fs = FooterSetting::current() ?? FooterSetting::create([]);

        // No validation rules per your requirement
        $fs->fill($request->only([
            'footer_text','facebook_url','instagram_url','website_url','address','email'
        ]))->save();

        Cache::forget('footer_settings_cache');

        return response()->json([
            'success' => true,
            'message' => 'Footer settings updated.',
            'data'    => $fs,
        ]);
    }
}
