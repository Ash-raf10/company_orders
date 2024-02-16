<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Company\CompanyCreateRequest;

class CompanyService
{

    public function processCompanyData(CompanyCreateRequest $request): array
    {
        $requestData = $request->validated();

        if ($request->hasFile('commercial_record_image')) {
            $requestData['commercial_record_image'] =
                $this->saveImage(
                    'companies/commercial',
                    request()->file('commercial_record_image')
                );
        }
        if ($request->hasFile('logo')) {
            $requestData['logo'] = $this->saveImage('companies/logo', request()->file('logo'));
        }

        return $requestData;
    }

    public function saveImage(string $folderName, $file): string
    {
        return Storage::put($folderName, $file);
    }

    public function revertSavedImage(array $requestData)
    {
        if ($requestData['commercial_record_image'] && Storage::exists($requestData['commercial_record_image'])) {
            Storage::delete($requestData['commercial_record_image']);
        }

        if ($requestData['logo'] && Storage::exists($requestData['logo'])) {
            Storage::delete($requestData['logo']);
        }
    }
}
