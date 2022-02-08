<?php

namespace App\Http\Controllers;

use App\Models\GenerateNumber;
use Illuminate\Http\Request;


class GenerateNumberController extends Controller
{
   public function getRandomPhoneNumber(Request $request)
   {
       // get random phone number between 1 and 500 in DB
       $phoneNumber = GenerateNumber::whereId(rand(1,500))->first();

       $result = [
           'nohandphone' => $phoneNumber->nohandphone,
           'provider' => $phoneNumber->provider
       ];

       return response()->json($result);

   }
}
