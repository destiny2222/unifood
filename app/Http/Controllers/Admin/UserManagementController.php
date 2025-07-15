<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(){
      $user = User::all();
      return view('admin.userManagement.index',[
        'users'=>$user
      ]);
   }
}
