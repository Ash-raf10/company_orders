<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Models\Company;

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

    public function processCompanyUpdateData(CompanyUpdateRequest $request, Company $company): array
    {
        $requestData = $request->validated();

        if ($request->hasFile('commercial_record_image')) {
            $requestData['commercial_record_image'] =
                $this->saveImage(
                    'companies/commercial',
                    request()->file('commercial_record_image')
                );
            $previousImage['commercial_record_image'] = $company->commercial_record_image;
            $previousImage['logo'] = null;

            $this->revertSavedImage($previousImage);
        }
        if ($request->hasFile('logo')) {
            $requestData['logo'] = $this->saveImage('companies/logo', request()->file('logo'));
            $previousImage['logo'] = $company->logo;
            $previousImage['commercial_record_image'] = null;

            $this->revertSavedImage($previousImage);
        }

        return $requestData;
    }

    public function deleteSavedImage(Company $company)
    {
        $imageData['commercial_record_image'] = $company->commercial_record_image;
        $imageData['logo'] = $company->logo;
        $this->revertSavedImage($imageData);
    }
}
