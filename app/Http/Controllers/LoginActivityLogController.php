<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginActivityLog;

class LoginActivityLogController extends Controller
{
    public function index()
    {
        $loginLogs = LoginActivityLog::latest()->get();
        return view('admin.login_logs.index', compact('loginLogs'));
    }
}
