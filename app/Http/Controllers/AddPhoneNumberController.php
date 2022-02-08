<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneNumber;
use Illuminate\Support\Facades\Crypt;
use App\Events\SendGlobalNotification;

class AddPhoneNumberController extends Controller
{
    public function addPhoneNumber(Request $request)
    {
        // validate input
        $request->validate([
            'nohandphone' => ['required', 'min:3', 'numeric']
        ]);
        
        // get data from DB and Decript phone number
        $getPhoneNumbersDecript = $this->decriptNumber(PhoneNumber::select('nohandphone')->get());

        //check if phone number exist
        $check = in_array($request->nohandphone, $getPhoneNumbersDecript);

        if(!$check)
        {
            // create new phone number with Encryption key
            PhoneNumber::create([
                'nohandphone' => Crypt::encryptString($request->nohandphone),
                'provider' => Crypt::encryptString($request->provider)
            ]);

            // send notification adding phone number to pusher
            $msg = "Phone Number " . $request->nohandphone . " Has been added!";
            event(new SendGlobalNotification($msg));

            //redirect to input page with flash message 
            return redirect()->route('index.input')->with('message', 'Success Add Phone Number!!!');
        }

        //redirect with flash message (ERROR)
        return redirect()->route('index.input')->with('error', "Phone Number Already Exist");
    }


    // Decript phone number from db
    protected function decriptNumber($phoneNumber)
    {
        $result = [];
        foreach($phoneNumber as $phone)
        {
            array_push($result, Crypt::decryptString($phone->nohandphone));
        }

        return $result;
    }
}
