<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $member = $request->session()->get('member', '');
        if(!empty($member))
        {
            return redirect('/category');
        }
        return view('login')->with('return_url', '/category');
    }


    public function toLogin(Request $request)
    {
        $member = $request->session()->get('member', '');
        if(!empty($member))
        {
        return redirect('/category');
        }

        $return_url = $request->input('return_url', '/category');
        return view('login')->with('return_url', urldecode($return_url));
    }

    public function toRegister($value='')
    {
        return view('register');
    }
}
