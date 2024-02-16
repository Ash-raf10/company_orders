<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($order) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post"
                        action="{{ isset($order) ? route('orders.update', $order->uuid) : route('orders.store') }}"
                        class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($order)
                            @method('put')
                        @endisset

                        <div>
                            <x-input-label for="city_from" value="From City *" />
                            <x-text-input id="city_from" name="city_from" type="text" class="mt-1 block w-full"
                                :value="$order->city_from ?? old('city_from')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('city_from')" />
                        </div>

                        <div>
                            <x-input-label for="city_to" value="To City *" />
                            <x-text-input id="city_to" name="city_to" type="text" class="mt-1 block w-full"
                                :value="$order->city_to ?? old('city_to')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('city_to')" />
                        </div>


                        <div>
                            <x-input-label for="price" value="Price * (decimal)" />
                            <x-text-input id="price" name="price" type="text" class="mt-1 block w-full"
                                :value="$order->price ?? old('price')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>

                        <div>
                            <x-input-label for="images" value="Images (multiple allowed)" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose image</span>
                                <input type="file" id="images" name="images[]" multiple
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                " />
                            </label>
                            @if (isset($order->orderImages) && !empty($order->orderImages))
                                @foreach ($order->orderImages as $image)
                                    <div class="shrink-0 my-2">
                                        <img id="logo_preview" class="h-64 w-128 object-cover rounded-md"
                                            src="{{ isset($image) ? Storage::url($image->image_path) : '' }}"
                                            alt="Image Preview" />
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div>
                            <x-input-label for="company_id" value="Company *" />
                            <select id="company_id" name="company_id" class="mt-1 block w-full" required autofocus>
                                <option value="">Select Company</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        @if (isset($order) && $order->company_id == $company->id) selected @endif>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('company_id')" />
                        </div>


                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
