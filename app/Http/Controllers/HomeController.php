<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;

class HomeController extends Controller
{
    private $categories = [];
    private $productsValues = [];
    private $totalOrders = 0;
    private $daysValues = [];
    private $totalCanceled = 0;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $start = date('Y-m-d', strtotime('-7 day'));
        $end = date('Y-m-d', time());
        $this->count($start, $end);
        $countDays = count($this->daysValues);
        if ($countDays) {
            $amount = array_sum($this->daysValues);
            $avgLast7Days = Order::formatMoney($amount / $countDays);
            $amountLast7Days = Order::formatMoney($amount);
            $conversionRate = Order::formatMoney(100 - ((100 * $this->totalCanceled) / $this->totalOrders), '');
        } else {
            $avgLast7Days = 0;
            $amountLast7Days = 0;
            $conversionRate = 0;
        }
        return view('home', [
            'countDays' => $countDays,
            'totalOrders' => $this->totalOrders,
            'productsValues' => $this->productsValues,
            'daysValues' => $this->daysValues,
            'amountLast7Days' => $amountLast7Days,
            'conversionRate' => $conversionRate,
            'avgLast7Days' => $avgLast7Days
        ]);
    }

    private function count($start, $end)
    {
        $orders = Order::where('created_at', '>=', $start . ' 00:00:00')
            ->where('created_at', '<=', $end . ' 23:59:59')
            ->whereIn('status', [Order::STATUS_COMPLETE, Order::STATUS_CANCELED])
            ->get();
        $this->totalOrders = $orders->count();
        foreach ($orders as $order) {
            if (!isset($this->daysValues[$order->created_at->format('d/m/Y')])) {
                $this->daysValues[$order->created_at->format('d/m/Y')] = 0;
            }
            if ($order->status === Order::STATUS_COMPLETE) {
                $this->daysValues[$order->created_at->format('d/m/Y')] += $order->amount;
                $this->countItems($order);
            } else {
                $this->totalCanceled++;
            }
        }
    }

    private function countItems(Order $order)
    {
        foreach ($order->items as $item) {
            $category = '-';
            if (isset($this->categories()[$item->product->category_id])) {
                $category = $this->categories()[$item->product->category_id];
            }

            if (!isset($this->productsValues[$category])) {
                $this->productsValues[$category] = 0;
            }
            $this->productsValues[$category] += $item->quantity;
        }
    }

    private function categories()
    {
        if (empty($this->categories)) {
            $this->categories = Category::toOptionList();
        }
        return $this->categories;
    }
}
