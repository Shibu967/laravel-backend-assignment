<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $onlineAdmins = Admin::where('is_online', true)->get();
        $onlineCustomers = User::where('is_online', true)->get();
        
        return view('admin.dashboard', compact('onlineAdmins', 'onlineCustomers'));
    }
}