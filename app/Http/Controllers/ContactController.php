<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Mail;

class ContactController extends Controller
{
    public function sendEmail(Request $request){
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'msg' => $request->msg,
        ];

        Mail::to('fillbottleproject@gmail.com')->send(new ContactMail($details));
        return back()->with('success','Your message has been sent successfully');
    }
}
