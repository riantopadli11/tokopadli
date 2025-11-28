<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService
{
    protected $apiKey;
    protected $privateKey;
    protected $merchantCode;
    protected $mode;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('TRIPAY_API_KEY');
        $this->privateKey = env('TRIPAY_PRIVATE_KEY');
        $this->merchantCode = env('TRIPAY_MERCHANT_CODE');
        $this->mode = env('TRIPAY_MODE', 'sandbox');
        
        $this->baseUrl = $this->mode === 'production' 
            ? 'https://tripay.co.id/api' 
            : 'https://tripay.co.id/api-sandbox';
    }

    public function requestTransaction($method, $data)
    {
        $amount = $data['amount'];
        $merchantRef = $data['merchant_ref'];

        // Hitung Signature sesuai dokumentasi Tripay
        $signature = hash_hmac('sha256', $this->merchantCode . $merchantRef . $amount, $this->privateKey);

        $payload = [
            'method'         => $method, // Contoh: 'QRIS'
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => 'Gamers TokoPadli',
            'customer_email' => 'user@tokopadli.com',
            'customer_phone' => '081234567890',
            'order_items'    => [
                [
                    'sku'      => $data['sku'],
                    'name'     => $data['product_name'],
                    'price'    => $amount,
                    'quantity' => 1
                ]
            ],
            'expired_time' => (time() + (24 * 60 * 60)), // 24 Jam
            'signature'    => $signature
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey
        ])->post($this->baseUrl . '/transaction/create', $payload);

        return $response->json();
    }
}