<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($order_uuid)
    {
        return view('orders.detail', [
            'order_uuid' => $order_uuid
        ]);
    }
}
