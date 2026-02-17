<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use App\Models\Domain;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        Log::info('SendProductWebhook: evento recebido', ['product_id' => $event->productId]);

        $domains = Domain::where('is_active', true)
            ->whereHas('products', fn ($q) =>
                $q->where('products.id', $event->productId)
            )
            ->get();

        Log::info('SendProductWebhook: domínios encontrados', ['count' => $domains->count()]);

        $domains->each(function (Domain $domain) use ($event) {
            try {
                $response = Http::post("{$domain->name}/api/webhook", [
                    'event'      => 'product.updated',
                    'product_id' => $event->productId,
                ]);

                Log::info('SendProductWebhook: resposta', [
                    'domain' => $domain->name,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            } catch (\Exception $e) {
                Log::error('SendProductWebhook: erro ao enviar webhook', [
                    'domain' => $domain->name,
                    'error'  => $e->getMessage(),
                ]);
            }
        });
    }
}
