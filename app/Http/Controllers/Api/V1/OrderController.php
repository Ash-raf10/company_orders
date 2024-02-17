<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Order\OrderCreateRequest;

class OrderController extends Controller
{
    use ApiResponse;

    public function __construct(private OrderService $orderService)
    {
    }

    public function index()
    {
        $orderQuery = Order::query()->with('company', 'orderImages');

        [$orderData, $pagination] = $this->paginateData($orderQuery);

        return $this->sendPaginationResponse(OrderResource::collection($orderData), $pagination);
    }

    public function show(Order $order)
    {
        $order->load('company', 'orderImages');

        return $this->sendResponse(true, new OrderResource($order));
    }

    public function store(OrderCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $requestData = $this->orderService->processOrderCreateRequest($request);
            $order = Order::create($requestData);

            if ($order) {
                if (isset($requestData['images']) && !empty($requestData['images'])) {
                    $orderImages = $this->orderService->saveOrderImage($requestData['images']);
                    if (!empty($orderImages)) {
                        $order->orderImages()->saveMany($orderImages);
                    }
                }
            }

            DB::commit();

            return $this->sendResponse(true, new OrderResource($order), __("Successfully created"), 200);
        } catch (Exception $e) {
            Log::error($e);

            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }

    public function update(Order $order, OrderCreateRequest $request)
    {
        try {
            DB::beginTransaction();
            $requestData = $this->orderService->processOrderCreateRequest($request);

            $order->update($requestData);

            if (isset($requestData['images']) && !empty($requestData['images'])) {
                $orderImages = $this->orderService->saveOrderImage($requestData['images']);
                if (!empty($orderImages)) {
                    $this->orderService->deletePreviousImage($order);
                    $order->orderImages()->saveMany($orderImages);
                }
            }

            DB::commit();

            return $this->sendResponse(true, new OrderResource($order), __("Successfully updated"), 200);
        } catch (Exception $e) {
            Log::error($e);
            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }

    public function destroy(Order $order)
    {
        $order->load('orderImages');
        $oldOrder = $order->replicate();
        $delete = $order->delete();

        if ($delete) {
            $this->orderService->deletePreviousImage($oldOrder);

            return $this->sendResponse(true, "", __("Successfully deleted"), 200);
        } else {
            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }
}
