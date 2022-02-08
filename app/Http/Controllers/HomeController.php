<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\PhoneNumber;


class HomeController extends Controller
{
    // view input page
    public function input(Request $request)
    {
        return view('main.input', [
            'page' => 'INPUT'
        ]);
    }

    // view output page
    public function output(Request $request)
    {
        return view('main.output', [
            'page' => 'OUTPUT'
        ]);
    }

}
