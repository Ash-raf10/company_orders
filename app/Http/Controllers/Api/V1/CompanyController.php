<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;

class CompanyController extends Controller
{
    use ApiResponse;

    public function __construct(private CompanyService $companyService)
    {
    }

    public function index()
    {
        $companyQuery = Company::query()->with('country');

        [$companyData, $pagination] = $this->paginateData($companyQuery);

        return $this->sendPaginationResponse(CompanyResource::collection($companyData), $pagination);
    }

    public function show(Company $company)
    {
        $company->load('country');

        return $this->sendResponse(true, new CompanyResource($company));
    }

    public function store(CompanyCreateRequest $request)
    {
        try {
            $requestData = $this->companyService->processCompanyData($request);

            $company = Company::create($requestData);
            if ($company) {
                return $this->sendResponse(true, new CompanyResource($company), __("Successfully created"), 200);
            } else {
                return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
            }
        } catch (Exception $e) {
            Log::error($e);

            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }

    public function update(Company $company, CompanyUpdateRequest $request)
    {
        try {
            $requestData = $this->companyService->processCompanyUpdateData($request, $company);

            $isUpdated = $company->update($requestData);

            if ($isUpdated) {
                return $this->sendResponse(
                    true,
                    new CompanyResource($company->refresh()),
                    __("Successfully updated"),
                    200
                );
            } else {
                $this->revertSavedImage($requestData);
                return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
            }
        } catch (Exception $e) {
            Log::error($e);
            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }

    public function destroy(Company $company)
    {
        $oldCompany = $company->replicate();
        $delete = $company->delete();

        if ($delete) {
            $this->companyService->deleteSavedImage($oldCompany);

            return $this->sendResponse(
                true,
                "",
                __("Successfully deleted"),
                200
            );
        } else {
            return $this->sendResponse(false, "", __("Something Went Wrong"), 404, 4001);
        }
    }
}
