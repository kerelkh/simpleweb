<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\PhoneNumber;
use App\Events\SendGlobalNotification;

class PhoneNumberController extends Controller
{
    // handle api odd & even data from DB to client
    public function getOddEvenPhone(Request $request)
    {
        // get All data & decript data
        $rawData = $this->decriptNumber(PhoneNumber::all());

        // get odd even data
        $data = $this->getOddEven($rawData);

        //assign data to array associate
        $result = [
            'oddNumbers' => $data['odd'],
            'evenNumbers' => $data['even']
        ];

        // return data to client
        return response()->json($result);
    }

    // handle proccesing raw data phone number for editing purpose
    public function getPhoneNumber(Request $request)
    {

        $getData = $this->getDataSearch(PhoneNumber::all(), $request->searchphone);
        $final = [];
        if(count($getData) > 0){
            $final = [
                'nohandphone' => $getData[0],
                'provider' => $getData[1],
                'id' => $getData[2]
            ];
        }
        return response()->json($final);
        
    }

    // handle update data with encription
    public function updatePhoneNumber(Request $request)
    {
        $id = $request->id;

        // encrypt
        $phone = Crypt::encryptString($request->phone);
        $provider = Crypt::encryptString($request->provider);

        // update data
        $result = PhoneNumber::whereId($id)->update([
            'nohandphone' => $phone,
            'provider' => $provider
        ]);
        if($result){

            // push notification to pusher
            $msg = "Phone Number with ID = " . $id . " Has been updated!";
            event(new SendGlobalNotification($msg));

            //redirect
            return response()->json(['message' => 'berhasil'], 200);
        }

        // return 404 code not found
        return response()->json(404);
    }

    // handle delete data phone number with ID
    public function deletePhoneNumber(Request $request)
    {
        // search then delete data phone
        $result = PhoneNumber::whereId($request->id_phone)->delete();

        if($result)
        {
            // push notification delete to pusher
            $msg = "Phone Number with ID = " . $request->id_phone . " Has been deleted!";
            event(new SendGlobalNotification($msg));

            // redirect with success flash message
            return redirect('/output')->with('message', 'Phone Number has been deleted');
        }

        // redirect with flash message (ERROR)
        return redirect('/output')->with('error', 'Failed to delete data!!!');
    }

    // handle searching data with decription
    protected function getDataSearch($phoneNumbers, $search)
    {
        $result = [];
        // foreach decript -> check plain -> push ? redirect / skip
        foreach($phoneNumbers as $phone){
            $decript = Crypt::decryptString($phone->nohandphone);
            if($decript == $search){
                array_push($result, $decript);
                array_push($result,  Crypt::decryptString($phone->provider));
                array_push($result, $phone->id);
                return $result;
            }
        }

        return $result;

    }

    // handle decription for phone number
    protected function decriptNumber($phoneNumber)
    {
        $result = [];
        foreach($phoneNumber as $phone)
        {
            array_push($result, [Crypt::decryptString($phone->nohandphone), Crypt::decryptString($phone->provider)]);
        }

        return $result;
    }

    // handle proccesing data odd & even
    protected function getOddEven($phoneNumber, $odd = false)
    {
        $result = [
            'odd' => [], 'even' => []
        ];
        foreach($phoneNumber as $phone)
        {
            // check if odd or even with Modulo Operation
            (int)$phone[0] % 2 == 0 ? array_push($result['even'], [$phone[0],$phone[1]]) : array_push($result['odd'], [$phone[0],$phone[1]]);
        }

        return $result;
    }
}
