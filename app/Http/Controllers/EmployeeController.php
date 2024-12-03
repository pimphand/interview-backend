<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Retrieve search and sorting parameters with defaults
        $search = request('search');
        $sortBy = request('sort_by', 'name');
        $sortDirection = request('sort_direction', 'asc');

        // Query data with 'company' relationship and role-based filtering
        $data = User::query()
            ->whereHas('company', function ($query) use ($user) {
                $query->where('id', $user->company_id);
            })
            ->when($user->hasRole('manajer'), fn($query) => $query->whereHasRole(['manajer', 'karyawan']))
            ->when($user->hasRole('karyawan'), fn($query) => $query->whereHasRole('karyawan'))
            ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10);

        return UserResource::collection($data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $user = User::create(array_merge($request->validated(), [
            'password' => bcrypt('password'),
            'company_id' => auth()->user()->company_id,
        ]));
        $user->addRole('karyawan');
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'Data has been deleted'], 200);
    }
}
