<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Car\CreateCarRequest;
use App\Http\Requests\Car\UpdateCarRequest;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Car::class);

        $user = Auth::user();
        $cars = Car::where('user_id', $user->id)->with('user')->latest()->paginate(10);
        return response()->json([
            'message' => 'get all cars success',
            'data' => $cars
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCarRequest $request)
    {
        $car = Auth::user()->cars()->create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'create cars success',
            'data' => $car
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        $this->authorize('view', $car);
        return response()->json([
            'message' => 'get car success',
            'data' => $car
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $car->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'update car success',
            'data' => $car
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);
        
        $car->delete();

        return response()->json([
            'message' => 'delete car success'
        ]);
    }
}
