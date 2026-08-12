<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAboutUsRequest;
use App\Services\AboutUsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AboutUsController extends Controller
{
    public function __construct(
        protected AboutUsService $aboutUsService
    ) {}

    public function show(): View
    {
        $aboutUs = $this->aboutUsService->get();

        return view('Admin.about-us.show', compact('aboutUs'));
    }

    public function edit(): View
    {
        $aboutUs = $this->aboutUsService->get();

        return view('Admin.about-us.edit', compact('aboutUs'));
    }

    public function update(UpdateAboutUsRequest $request): RedirectResponse
    {
        $this->aboutUsService->update($request->validated());

        return redirect()
            ->route('admin.about-us.show')
            ->with('success', 'درباره ما با موفقیت ویرایش شد');
    }
}
