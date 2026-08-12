<?php

namespace App\Services;

use App\Models\AboutUs;

class AboutUsService
{
    public function get(): AboutUs
    {
        return AboutUs::firstOrFail();
    }

    public function update(array $data): AboutUs
    {
        $aboutUs = $this->get();

        $aboutUs->update($data);

        return $aboutUs->refresh();
    }
}