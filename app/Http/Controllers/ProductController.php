<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $domain = $request->get('domain');

        $products = $domain->products()
            ->where('status', 'active')
            ->wherePivot('is_active', true)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'checkout_url' => $product->pivot->checkout_url,
                ];
            });

        return response()->json($products);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $domain = $request->get('domain');

        $product = $domain->products()
            ->where('product_id', $id)
            ->where('status', 'active')
            ->wherePivot('is_active', true)
            ->firstOrFail();

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'checkout_url' => $product->pivot->checkout_url,
        ]);
    }
}
