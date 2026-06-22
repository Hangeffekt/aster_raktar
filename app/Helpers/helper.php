<?php

use App\Models\Transaction;

if (!function_exists('currentStock')) {
    
    function currentStock(string $product_id)
    {
        $currentStock = 0;

        $transactions = Transaction::where('product_id', $product_id)
            ->where('created_at', '>=', function ($query) use ($product_id)
            {
                $query->selectRaw("COALESCE(MAX(created_at), '1970-01-01 00:00:00')")
                    ->from('transactions')
                    ->where('type', 'SETTLE')
                    ->where('product_id', $product_id);
            })
            ->where('status', '!=', 'PENDING')
            ->select('id', 'type', 'qty', 'sale_price', 'net_price', 'created_at')
            ->orderBy('created_at', 'ASC')
            ->get();

            foreach ($transactions as $t) {
                $currentStock += $t->qty;
        }

        return $currentStock;
    }
}