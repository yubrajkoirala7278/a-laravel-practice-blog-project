<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Twilio\Rest\Client; // make sure to import the Twilio client

class SmsTwilioController extends Controller
{
    public function sendSms()
    {
        $receiverNumber = '+9779811761742'; // Replace with the recipient's phone number
        $message = 'hi testing'; // Replace with your desired message

        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_TOKEN');
        $fromNumber = getenv('TWILIO_FROM');

        try {
            $client = new Client($sid, $token);
            $client->messages->create($receiverNumber, [
                'from' => $fromNumber,
                'body' => $message
            ]);

            return 'SMS Sent Successfully.';
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return 'Error: ' . $th->getMessage();
        }
    }
}
