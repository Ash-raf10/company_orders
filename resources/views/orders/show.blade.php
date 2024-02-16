<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $order->order_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Order Number' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->order_number }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'From City' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->city_from }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'To City' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->city_to }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Price' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->price }}
                        </p>
                    </div>
                    @foreach ($order->orderImages as $image)
                        <div class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ "Order Image # $loop->iteration " }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                <img class="h-64 w-128" src="{{ Storage::url($image->image_path) }}"
                                    alt="{{ $order->order_number }}" srcset="">
                            </p>
                        </div>
                    @endforeach

                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Company' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->company->name }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Created At' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->created_at }}
                        </p>
                    </div>
                    <div class="mb-6">
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ 'Updated At' }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ $order->updated_at }}
                        </p>
                    </div>
                    <a href="{{ route('companies.index') }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md">BACK</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
