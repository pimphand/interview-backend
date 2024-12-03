<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
      return DB::transaction(function () use ($request) {
            $company = Company::create($request->validated());

            $user = $company->users()->create([
                'name' => $company->name,
                'email' => $company->email,
                'password' => bcrypt('password'),
            ]);
            $user->addRole('manajer');

            return response()->json($company, 201);
      });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
