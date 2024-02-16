<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Use 'Edit' for edit mode and create for non-edit/create mode --}}
            {{ isset($company) ? 'Edit' : 'Create' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- don't forget to add multipart/form-data so we can accept file in our form --}}
                    <form method="post"
                        action="{{ isset($company) ? route('companies.update', $company->id) : route('companies.store') }}"
                        class="mt-6 space-y-6" enctype="multipart/form-data">
                        @csrf
                        {{-- add @method('put') for edit mode --}}
                        @isset($company)
                            @method('put')
                        @endisset

                        <div>
                            <x-input-label for="name" value="Name *" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="$company->name ?? old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" value="Email *" />
                            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                                :value="$company->email ?? old('email')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>


                        <div>
                            <x-input-label for="company_code" value="Company Code *" />
                            <x-text-input id="company_code" name="company_code" type="text" class="mt-1 block w-full"
                                :value="$company->name ?? old('company_code')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('company_code')" />
                        </div>

                        <div>
                            <x-input-label for="commercial_record_number *" value="Commercial Record Number *" />
                            <x-text-input id="commercial_record_number" name="commercial_record_number" type="text"
                                class="mt-1 block w-full" :value="$company->commercial_record_code ?? old('commercial_record_number')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('commercial_record_number')" />
                        </div>

                        <div>
                            <x-input-label for="commercial_record_image" value="Commercial Record Image" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose image</span>
                                <input type="file" id="commercial_record_image" name="commercial_record_image"
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                " />
                            </label>

                            @if (isset($company) && $company->commercial_record_image)
                                <div class="shrink-0 my-2">
                                    <img id="image_preview" class="h-64 w-128 object-cover rounded-md"
                                        src="{{ isset($company) ? Storage::url($company->commercial_record_image) : '' }}"
                                        alt="Commercial Record Image Preview" />
                                </div>
                            @endif

                            <x-input-error class="mt-2" :messages="$errors->get('commercial_record_image')" />
                        </div>

                        <div>
                            <x-input-label for="logo" value="Logo" />
                            <label class="block mt-2">
                                <span class="sr-only">Choose image</span>
                                <input type="file" id="logo" name="logo"
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-violet-50 file:text-violet-700
                                    hover:file:bg-violet-100
                                " />
                            </label>
                            @if (isset($company) && $company->logo)
                                <div class="shrink-0 my-2">
                                    <img id="logo_preview" class="h-64 w-128 object-cover rounded-md"
                                        src="{{ isset($company) ? Storage::url($company->logo) : '' }}"
                                        alt="Logo Preview" />
                                </div>
                            @endif
                            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
                        </div>

                        <div>
                            <x-input-label for="country_code" value="Country *" />
                            <select id="country_code" name="country_code" class="mt-1 block w-full" required autofocus>
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        @if (isset($company) && $company->country_code == $country->id) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('country_code')" />
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
