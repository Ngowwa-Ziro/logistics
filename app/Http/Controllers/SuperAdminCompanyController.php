<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class SuperAdminCompanyController extends Controller
{
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }

    public function viewCompanies()
    {
        $companies = Company::latest()->paginate(10);
        return view('super-admin.companies', compact('companies'));
    }

    public function addCompany()
    {
        return view('super-admin.add-company');
    }

    public function storeCompany(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        Company::create($request->all());

        return redirect()->route('super-admin.companies')->with('success', 'Company created successfully.');
    }

    public function editCompany($id)
    {
        $company = Company::findOrFail($id);
        return view('super-admin.edit', compact('company'));
    }

    public function updateCompany(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $company->update($request->all());

        return redirect()->route('super-admin.companies')->with('success', 'Company updated successfully.');
    }

    public function destroyCompany($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return redirect()->route('super-admin.companies')->with('success', 'Company deleted successfully.');
    }
}
