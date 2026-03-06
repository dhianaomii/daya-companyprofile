<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function index()
    {
        $baseUrl = config('services.backend.url');
        $headers = [
            'X-Scope-Service' => 'local_place',
            'Accept' => 'application/json',
        ];

        try {
            // Fetch Company Config
            $companyResponse = Http::withHeaders($headers)->get($baseUrl . '/config/company');
            $company = [];
            if ($companyResponse->successful()) {
                $company = $companyResponse->json()['data'] ?? [];

                if (isset($company['company_phone'])) {
                    $phone = preg_replace('/[^0-9]/', '', $company['company_phone']);
                    if (str_starts_with($phone, '0')) {
                        $phone = '62' . substr($phone, 1);
                    } elseif (str_starts_with($phone, '8')) {
                        $phone = '62' . $phone;
                    }
                    $company['company_phone_display'] = '+' . substr($phone, 0, 2) . ' ' . substr($phone, 2, 3) . '-' . substr($phone, 5, 4) . '-' . substr($phone, 9);
                    $company['company_phone_wa'] = $phone;
                }
            }

            // Fetch Products
            $productResponse = Http::withHeaders($headers)->get($baseUrl . '/options/product', [
                'channel' => 'HORECA',
                'scope_type' => 'daya',
            ]);
            $products = [];
            if ($productResponse->successful()) {
                $products = $productResponse->json()['data']['products'] ?? [];
            }

            Log::info('API Data Fetched:', ['company' => $company, 'product_count' => count($products)]);
        } catch (\Exception $e) {
            Log::error('API Connection Error: ' . $e->getMessage());
            $company = [];
            $products = [];
        }

        return view('landing', compact('products', 'company'));
    }
}
