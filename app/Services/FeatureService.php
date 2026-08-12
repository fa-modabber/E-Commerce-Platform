<?php

namespace App\Services;

use App\Models\Feature;
use Illuminate\Database\Eloquent\Collection;

class FeatureService
{
    public function all(): Collection
    {
        return Feature::all();
    }

    public function store(array $data): Feature
    {
        return Feature::create($data);
    }

    public function update(
        Feature $feature,
        array $data
    ): Feature {
        $feature->update($data);

        return $feature->refresh();
    }

    public function destroy(Feature $feature): void
    {
        $feature->delete();
    }
}
