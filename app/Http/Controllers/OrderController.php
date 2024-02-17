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
        $order->load('orderImages', 'company');

        return response()->view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $companies = Company::all('id', 'name');

        return response()->view('orders.form', compact('companies', 'order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderCreateRequest $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\Response
     */
    public function update(OrderCreateRequest $request, Order $order, OrderService $orderService)
    {
        try {
            DB::beginTransaction();
            $requestData = $orderService->processOrderCreateRequest($request);

            $order->update($requestData);

            if (isset($requestData['images']) && !empty($requestData['images'])) {
                $orderImages = $orderService->saveOrderImage($requestData['images']);
                if (!empty($orderImages)) {
                    $orderService->deletePreviousImage($order);
                    $order->orderImages()->saveMany($orderImages);
                }
            }


            DB::commit();

            session()->flash('notification.success', 'Oder updated successfully!');
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            session()->flash('notification.error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @param OrderService $orderService
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order, OrderService $orderService)
    {
        $order->load('orderImages');
        $oldOrder = $order->replicate();
        $delete = $order->delete();

        if ($delete) {
            $orderService->deletePreviousImage($oldOrder);
            session()->flash('notification.success', 'Order deleted successfully!');

            return redirect()->route('orders.index');
        } else {
            session()->flash('notification.error', 'Something went wrong');

            return redirect()->back();
        }
    }
}
