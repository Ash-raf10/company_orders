<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Order\OrderCreateRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('orderImages', 'company')->simplePaginate(100);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all('id', 'name');

        return response()->view('orders.form', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderCreateRequest $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\Response
     */
    public function store(OrderCreateRequest $request, OrderService $orderService)
    {
        try {
            DB::beginTransaction();
            $requestData = $orderService->processOrderCreateRequest($request);
            $order = Order::create($requestData);

            if ($order) {
                if (isset($requestData['images']) && !empty($requestData['images'])) {
                    $orderImages = $orderService->saveOrderImage($requestData['images']);
                    if (!empty($orderImages)) {
                        $order->orderImages()->saveMany($orderImages);
                    }
                }
            }

            DB::commit();

            session()->flash('notification.success', 'Oder created successfully!');
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            session()->flash('notification.error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
