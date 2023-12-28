<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
class WhatsAppController extends Controller
{
    //

    public function sendWhatsAppMessage(Request $request)
    {
        
        $user = User::where('phone_number', $request->phoneNumber)->first();
        // dd($user);
        $phone_number = $request->phoneNumber;
        if($user){
            $otp = Str::random(6); // Generate a random 6-digit OTP
            // $expiresAt = 60; // Expiration timestamp: current time + 180 seconds
            // Store a variable in the session with a 60-second expiration time
            Session::put('otp',  $otp);
            Session::put('user',  $user);
            // dd($otp);
            $twilioSid = env('TWILIO_SID');
            $twilioToken = env('TWILIO_AUTH_TOKEN');
            $twilioWhatsAppNumber = env('TWILIO_WHATSAPP_NUMBER'); //Sender Number
            $recipientNumber = 'whatsapp:' .  $phone_number; //  recipient's phone number in WhatsApp format (e.g., "whatsapp:+1234567890")
            $message = "this is your verification code: " . $otp;

            // dd($twilioSid , $twilioToken ,$twilioWhatsAppNumber ,$recipientNumber ,$message);
            $twilio = new Client($twilioSid, $twilioToken);

            try {
                $twilio->messages->create(
                    $recipientNumber,
                    [
                        "from" => $twilioWhatsAppNumber,
                        "body" => $message,
                    ]
                );
                
                // return redirect()->back()->with('success', 'WhatsApp message sent successfully');
                // return response()->json(['message' => 'WhatsApp message sent successfully']);
                return view('auth.verfcation_code', compact('phone_number', 'user'));
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            // dd("User already exists");
           
            // Auth::login($user);
            // return redirect()->route($user->role . '-profile');
        } else {
            // dd("User does not exists");
            return redirect()->back()->with('error', 'the user does not exists');
        }
        
    }

    public function codeVerfication(Request $request ){

        
        $otp = Session::get('otp');
        $user = Session::get('user');
        // dd($user);
        if ($otp == $request->otp) {
             Auth::login($user);
            return redirect()->route($user->role . '-profile');
        }
        else{
            return redirect()->back()->with('error', 'Invalid OTP');
        }

    }
}
