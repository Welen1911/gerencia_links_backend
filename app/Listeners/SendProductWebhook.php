<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use App\Models\Domain;
use App\Models\Webhook;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendProductWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductUpdated $event): void
    {
         Domain::where('is_active', true)
            ->whereHas('products', fn ($q) =>
                $q->where('products.id', $event->productId)
            )
            ->each(function (Domain $domain) use ($event) {
                Http::withToken($domain->api_key)
                    ->post("{$domain->name}api/webhooks/product", [
                        'event'      => 'product.updated',
                        'product_id' => $event->productId,
                    ]);
            });
    }
}
