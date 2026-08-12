<?php

namespace App\Http\Controllers\Admin;

use App\Models\Footer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateFooterRequest;
use App\Services\FooterService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FooterController extends Controller
{
    public function __construct(
        protected FooterService $footerService
    ) {}

    public function show(): View
    {
        $footer = $this->footerService->get();

        return view(
            'Admin.footer.index',
            compact('footer')
        );
    }

    public function edit(): View
    {
        $footer = $this->footerService->get();

        return view(
            'Admin.footer.edit',
            compact('footer')
        );
    }

    public function update(
        UpdateFooterRequest $request
    ): RedirectResponse {
        $this->footerService->update(
            $request->validated()
        );

        return redirect()
            ->route('admin.footer.index')
            ->with('success', 'فوتر با موفقیت ویرایش شد');
    }
}
