<?php

namespace App\Http\Controllers\Shop;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ContactUsController extends Controller
{
    public function index()
    {
        return view('Store.contact-us');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'body' => 'required',
        ]);

        ContactUs::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('success', 'پیام با موفقیت ارسال شد');
    }
}
