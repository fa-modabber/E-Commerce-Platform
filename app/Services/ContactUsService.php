<?php

namespace App\Services;

use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Collection;

class ContactUsService
{
    public function all(): Collection
    {
        return ContactUs::all();
    }

    public function destroy(ContactUs $contact): void
    {
        $contact->delete();
    }
}
