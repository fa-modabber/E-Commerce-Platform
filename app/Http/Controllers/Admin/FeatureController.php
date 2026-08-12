<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFeatureRequest;
use App\Http\Requests\Admin\UpdateFeatureRequest;
use App\Services\FeatureService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class FeatureController extends Controller
{
    public function __construct(
        protected FeatureService $featureService
    ) {}

    public function index(): View
    {
        $features = $this->featureService->all();

        return view(
            'Admin.features.index',
            compact('features')
        );
    }

    public function create(): View
    {
        return view('Admin.features.create');
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        $this->featureService->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.features.index')
            ->with('success', 'ویژگی با موفقیت ساخته شد');
    }

    public function edit(Feature $feature): View
    {
        return view(
            'Admin.features.edit',
            compact('feature')
        );
    }

    public function update(
        UpdateFeatureRequest $request,
        Feature $feature
    ): RedirectResponse {
        $this->featureService->update(
            $feature,
            $request->validated()
        );

        return redirect()
            ->route('admin.features.index')
            ->with('success', 'ویژگی با موفقیت ویرایش شد');
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $this->featureService->destroy($feature);
        return redirect()
            ->route('admin.features.index')
            ->with('warning', 'ویژگی با موفقیت حذف شد');
    }
}
