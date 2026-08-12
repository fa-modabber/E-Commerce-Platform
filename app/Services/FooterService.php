<?php

namespace App\Services;

use App\Models\Footer;
use Illuminate\Database\Eloquent\Collection;

class FooterService{
     public function get(): Footer
    {
        return Footer::firstOrFail();
    }

    public function update(array $data): Footer
    {
        $footer = $this->get();

        $footer->update($data);

        return $footer->refresh();
    }
}