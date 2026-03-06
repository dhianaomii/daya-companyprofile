<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    public function index()
    {
        try {
            // company profile
            $keys = [
                "config:company_name",
                "config:company_logo",
                "config:company_address",
                "config:company_phone",
                "config:company_email"
            ];

            $configs = DB::table('configurations')->whereIn('key', $keys)->get();

            $company = [
                'company_name' => $configs->firstWhere('key', 'config:company_name')->value ?? null,
                'company_logo' => $configs->firstWhere('key', 'config:company_logo')->value ?? null,
                'company_address' => $configs->firstWhere('key', 'config:company_address')->value ?? null,
                'company_phone' => $configs->firstWhere('key', 'config:company_phone')->value ?? null,
                'company_email' => $configs->firstWhere('key', 'config:company_email')->value ?? null,
            ];

            if (!empty($company['company_phone'])) {
                $phone = preg_replace('/[^0-9]/', '', $company['company_phone']);
                if (str_starts_with($phone, '0')) {
                    $phone = '62' . substr($phone, 1);
                } elseif (str_starts_with($phone, '8')) {
                    $phone = '62' . $phone;
                }
                $company['company_phone_display'] = '+' . substr($phone, 0, 2) . ' ' . substr($phone, 2, 3) . '-' . substr($phone, 5, 4) . '-' . substr($phone, 9);
                $company['company_phone_wa'] = $phone;
            }

            // Products
            $targetChannel = 1;
            $scopeType = 'daya';
            $scopeService = 'local_place';

            $rawProducts = DB::table('products')
                ->whereJsonContains('scope_service', $scopeService)
                ->whereJsonContains('scope_type', $scopeType)
                ->whereNull('deleted_at')
                ->orderBy('name')
                ->get();

            $products = [];
            foreach ($rawProducts as $product) {
                if ($product->has_package) {
                    $packages = DB::table('product_packages')
                        ->where('product_id', $product->id)
                        ->whereNull('deleted_at')
                        ->get();

                    foreach ($packages as $package) {
                        $items = DB::table('product_items')
                            ->where('product_package_id', $package->id)
                            ->whereNull('deleted_at')
                            ->get();

                        $totalQty = $items->sum('quantity');
                        $pricePerPcs = $totalQty > 0 ? ($package->price / $totalQty) : 0.0;

                        $products[] = [
                            'id' => $package->id,
                            'name' => $package->name,
                            'brand' => $product->brand,
                            'sku' => $product->sku,
                            'code' => $product->code,
                            'image' => $product->image ? (str_starts_with($product->image, 'http') ? $product->image : Storage::url($product->image)) : null,
                            'price' => $pricePerPcs
                        ];
                    }
                } else {
                    $specificPrice = DB::table('product_prices')
                        ->where('product_id', $product->id)
                        ->where('channel', $targetChannel)
                        ->first();

                    $products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'brand' => $product->brand,
                        'sku' => $product->sku,
                        'code' => $product->code,
                        'image' => $product->image ? (str_starts_with($product->image, 'http') ? $product->image : Storage::url($product->image)) : null,
                        'price' => $specificPrice ? (float)$specificPrice->price : (float)$product->price
                    ];
                }
            }

            Log::info('Database Data Fetched:', ['company' => $company, 'product_count' => count($products)]);
        } catch (\Exception $e) {
            Log::error('Database Connection Error: ' . $e->getMessage());
            $company = [];
            $products = [];
        }

        return view('landing', compact('products', 'company'));
    }
}
