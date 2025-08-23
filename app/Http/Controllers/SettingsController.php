<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can Access Settings')->only('settings');
    }
    public function settings()
    {
        return view('backend.settings.index');
    }
}
