<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\role;

class AdminController extends Controller
{
    public function dashboard()
{

    $user = Auth::user();
    $role = Role::all();
    return view('admin.pages.dashboards', compact('user',));
}


}
