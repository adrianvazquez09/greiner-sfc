<?php

namespace App\Controllers;


use Twilio\Rest\Client;

class Notifications extends BaseController
{

    //--------------------------------------------------------------------
    public function whatsApp()
    {
        $sid    = "ACe016c7408f8708956ba071a545a7c69d";
        $token  = "[AuthToken]";
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
            ->create(
                "whatsapp:+5218183961833", // to 
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => "Your Twilio code is 1238432"
                )
            );

        print($message->sid);
    }
}
