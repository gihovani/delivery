<?php

namespace App\Http\Controllers;

use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
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
        return view('reports');
    }

    public function transactions(Request $request)
    {
        $request->validate(['date' => 'required|size:10']);
        $date = $this->removeMaskDate($request->get('date'));
        $transactions = Transaction::where('created_at', '>=', $date. ' 00:00:00')
            ->where('created_at', '<=', $date. ' 23:59:59')->get();
        $columns = [
            __('id'),
            __('type'),
            __('payment_method'),
            __('value'),
            __('description'),
        ];
        return response()->streamDownload(function() use ($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->id,
                    __($transaction->type),
                    __($transaction->payment_method),
                    $transaction->value,
                    $transaction->description
                ]);
            }
            fclose($file);
        }, 'transactions-'.$date.'.csv');
    }
    public function orders(Request $request)
    {
        $request->validate([
            'start' => 'required|size:10',
            'end' => 'required|size:10',
        ]);
        $start = $this->removeMaskDate($request->get('start'));
        $end = $this->removeMaskDate($request->get('end'));
        $orders = Order::where('created_at', '>=', $start. ' 00:00:00')
            ->where('created_at', '<=', $end. ' 23:59:59')->get();
        $columns = [
            __('id'),
            __('status'),
            __('payment_method'),
            __('subtotal'),
            __('total'),
            __('discount'),
            __('shipping_amount'),
            __('cash_amount'),
            __('back_change'),
            __('customer_name'),
            __('customer_telephone'),
            __('deliveryman_name'),
            __('deliveryman_telephone'),
            __('address_zipcode'),
            __('address_street'),
            __('address_number'),
            __('address_city'),
            __('address_state'),
            __('address_neighborhood'),
            __('address_complement')
        ];
        return response()->streamDownload(function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($orders as $order) {
                fputcsv($file, [
                    $order->id,__($order->status),__($order->payment_method),
                    $order->subtotal_formated,$order->total_formated,$order->discount_formated,
                    $order->shipping_amount_formated,$order->cash_amount_formated,
                    $order->back_change_formated,$order->customer_name,$order->customer_telephone,
                    $order->deliveryman_name,$order->deliveryman_telephone,$order->address_zipcode,
                    $order->address_street,$order->address_number,$order->address_city,
                    $order->address_state,$order->address_neighborhood,
                    $order->address_complement
                ]);
            }
            fclose($file);
        }, 'orders-'.$start.'-'.$end.'.csv');
    }
}