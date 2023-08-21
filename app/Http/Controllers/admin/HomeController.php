<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Paper;


class HomeController extends Controller
{
    public function index(){
        return view('admin.index');
    }
}
