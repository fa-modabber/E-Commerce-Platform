<?php

namespace App\Http\Controllers\Shop;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\StoreContactUsRequest;
use Illuminate\Contracts\View\View;


class ContactUsController extends Controller
{
    public function index(): View
    {
        return view('Shop.contact-us');
    }

    public function store(StoreContactUsRequest $request)
    {
        ContactUs::create($request->validated());

        return redirect()
            ->back()
            ->with('success', 'پیام با موفقیت ارسال شد');
    }
}
