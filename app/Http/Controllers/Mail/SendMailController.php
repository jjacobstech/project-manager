<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\UserVerify;
use Illuminate\Support\Facades\Mail;

class SendMailController extends Controller
{
      public function sendmail()
      {
            Mail::to('jacobsjoshua81@gmail.com')->send(new UserVerify());

            return response()->json(['status' => "sent"], 200);
      }
}