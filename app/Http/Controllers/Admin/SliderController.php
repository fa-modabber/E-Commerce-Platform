<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Services\SliderService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SliderController extends Controller
{
    public function __construct(
        protected SliderService $sliderService
    ) {}

    public function index(): View
    {
        $sliders = $this->sliderService->all();
        return view(
            'Admin.sliders.index',
            compact('sliders')
        );
    }

    public function create(): View
    {
        return view('Admin.sliders.create');
    }

    public function store(StoreSliderRequest $request): RedirectResponse
    {
        $this->sliderService->store($request->validated());

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت ساخته شد');
    }

    public function edit(Slider $slider): View
    {
        return view(
            'Admin.sliders.edit',
            compact('slider')
        );
    }

    public function update(
        UpdateSliderRequest $request,
        Slider $slider
    ): RedirectResponse {

        $slider = $this->sliderService->update(
            $slider,
            $request->validated()
        );

        return redirect()
            ->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت ویرایش شد');
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $this->sliderService->destroy($slider);
        return redirect()
            ->route('admin.sliders.index')
            ->with('warning', 'اسلایدر با موفقیت حذف شد');
    }
}
