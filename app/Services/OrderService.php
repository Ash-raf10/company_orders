<?php

namespace App\Services;

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
}
