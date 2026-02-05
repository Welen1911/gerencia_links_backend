<?php

namespace App\Observers;

use App\Models\Domain;

class DomainObserver
{
    public function creating(Domain $domain): void
    {
        $domain->api_key = bin2hex(random_bytes(16));
    }
}
