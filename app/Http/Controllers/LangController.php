<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    public function changeLang($lang){
        Session::put('lang', $lang);
        return redirect()->back();
    }
}
