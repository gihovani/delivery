<?php

namespace App\Http\Controllers;

use App\Category;
use App\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $categories = [];
    private $productsValues = [];
    private $paymentMethodValues = [];
    private $shippingTaxValues = [];
    private $totalOrders = 0;
    private $daysValues = [];
    private $totalCanceled = 0;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->get('start')) {
            $start = Order::removeMaskDate($request->get('start'));
        }
        if ($request->get('end')) {
            $end = Order::removeMaskDate($request->get('end'));
        }
        if (empty($start)) {
            $start = date('Y-m-d', strtotime('-7 day'));
        }
        if (empty($end)) {
            $end = date('Y-m-d', time());
        }

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
            'start' => date('d/m/Y', strtotime($start)),
            'end' => date('d/m/Y', strtotime($end)),
            'countDays' => $countDays,
            'totalOrders' => $this->totalOrders,
            'productsValues' => $this->productsValues,
            'paymentMethodValues' => $this->paymentMethodValues,
            'shippingTaxValues' => $this->shippingTaxValues,
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
        /** @var Order $order */
        foreach ($orders as $order) {
            if (!isset($this->daysValues[$order->created_at->format('d/m/Y')])) {
                $this->daysValues[$order->created_at->format('d/m/Y')] = 0;
            }
            if (!isset($this->shippingTaxValues[$order->created_at->format('d/m/Y')])) {
                $this->shippingTaxValues[$order->created_at->format('d/m/Y')] = 0;
            }
            if (!isset($this->paymentMethodValues[$order->payment_method])) {
                $this->paymentMethodValues[__($order->payment_method)] = 0;
            }

            if ($order->status === Order::STATUS_COMPLETE) {
                $this->paymentMethodValues[__($order->payment_method)] += $order->amount;
                $this->shippingTaxValues[$order->created_at->format('d/m/Y')] += $order->shipping_amount;
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

    private function paymentMethods()
    {
        return Order::getPaymentMethodToOptionList(false);
    }
}
