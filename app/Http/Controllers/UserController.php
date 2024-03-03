<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    public function __construct()
    {

    }

    public function me(Request $request)
    {
      $user = Auth::user();
      return response()->json([
          'message'=>'Amount added Successfully!!',
          'status' => 200,
          'data' => $user
      ]);
    }
}