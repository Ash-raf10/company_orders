<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\Company\CompanyCreateRequest;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::with('country')->simplePaginate(100);

        return view('companies.index', compact('companies', $companies));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all('id', 'name');

        return response()->view('companies.form', compact('countries', $countries));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyCreateRequest $request
     * @param  CompanyService $companyService
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyCreateRequest $request, CompanyService $companyService)
    {
        $requestData = $companyService->processCompanyData($request);

        $company = Company::create($requestData);

        if ($company) {
            // add flash for the success notification
            session()->flash('notification.success', 'Company created successfully!');
            return redirect()->route('companies.index');
        } else {
            $this->revertSavedImage($requestData);

            session()->flash('notification.error', 'Something went wrong');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return response()->view('companies.show', compact('company', $company));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
