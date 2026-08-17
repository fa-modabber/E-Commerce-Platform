<?php

namespace App\Services;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Collection;

class SliderService
{
    public function all(): Collection
    {
        return Slider::all();
    }

    public function store(array $data): Slider
    {
        return Slider::create($data);
    }

    public function update(
        Slider $slider,
        array $data
    ): Slider {
        $slider->update($data);

        return $slider->refresh();
    }

    public function destroy(Slider $slider): void
    {
        $slider->delete();
    }
}
