<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function getPrices(Request $request)
    {
        $currency = strtoupper($request->input('currency', 'RUB'));
        
        $rates = [
            'RUB' => 1,
            'USD' => 90,
            'EUR' => 100,
        ];
        
        if (!array_key_exists($currency, $rates)) {
            $currency = 'RUB'; 
        }
        
        $products = [
            ['id' => 1, 'title' => 'машинка', 'price' => 1000],
            ['id' => 2, 'title' => 'куколка', 'price' => 2000],
            ['id' => 3, 'title' => 'зеркальце', 'price' => 1500],
        ];
        
        $result = array_map(function($product) use ($currency, $rates) {
            
            $convertedPrice = $product['price'] / $rates[$currency];

            switch ($currency) {
                case 'USD':
                    $formattedPrice = '$' . number_format($convertedPrice, 2, '.', '');
                    break;
                case 'EUR':
                    $formattedPrice = '€' . number_format($convertedPrice, 2, '.', '');
                    break;
                case 'RUB':
                default:
                    $formattedPrice = number_format($convertedPrice, 0, '', ' ') . ' ₽';
                    break;
            }
            
            return [
                'id' => $product['id'],
                'title' => $product['title'],
                'price' => $formattedPrice,
                'original_price' => $product['price'],
                'currency' => $currency,
            ];
        }, $products);
        
        return response()->json($result);
    }
}