<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Order\OrderCreateRequest;

class OrderService
{
    public function processOrderCreateRequest(OrderCreateRequest $request): array
    {
        $requestData = $request->validated();
        $requestData['order_number'] = Str::random(10);

        return $requestData;
    }

    public function saveOrderImage(array $images): array
    {
        foreach ($images as $image) {
            $filePath = $this->saveImage('orders', $image);
            $imageData[] = new OrderImage(['image_path' => $filePath]);
        }

        return $imageData;
    }

    public function saveImage(string $folderName, $file): string
    {
        return Storage::put($folderName, $file);
    }

    public function processOrderUpdateRequest(OrderCreateRequest $request): array
    {
        $requestData = $request->validated();

        return $requestData;
    }

    public function deletePreviousImage(Order $order)
    {
        $order->loadMissing('orderImages');

        if ($order->orderImages && !empty($order->orderImages)) {
            foreach ($order->orderImages as $image) {
                Storage::exists($image->image_path) ? Storage::delete($image->image_path) : "";
                OrderImage::whereId($image->id)->delete();
            }
        }
    }
}
