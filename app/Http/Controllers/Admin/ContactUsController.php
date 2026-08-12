<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Services\ContactUsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ContactUsController extends Controller
{
    public function __construct(
        protected ContactUsService $contactUsService
    ) {}

    public function index(): View
    {
        $messages = $this->contactUsService->all();

        return view(
            'Admin.contacts.index',
            compact('messages')
        );
    }

    public function show(ContactUs $contact): View
    {
        return view(
            'Admin.contacts.show',
            ['message' => $contact]
        );
    }

    public function destroy(ContactUs $contact): RedirectResponse
    {
        $this->contactUsService->destroy($contact);

        return redirect()
            ->route('admin.contact-us.index')
            ->with('warning', 'پیام با موفقیت حذف شد');
    }
}
