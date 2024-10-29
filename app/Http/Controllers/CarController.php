<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::all();
        return response()->json([
            'status' => true,
            'message' => 'Sucesso ao mostrar o(s) carro(s)',
            'data' => $cars
        ], 200);
    }


    public function show($id)
    {
        $car = Car::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Sucesso ao mostrar esse carro',
            'data' => $car
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'required|string|max:10',
            'quilometragem' => 'required|numeric',
            'modelo' => 'required|string|max:50',
            'marca' =>'required|string|max:50'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        $car = Car::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Sucesso ao adicionar esse carro',
            'data' => $car
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'placa' => 'required|string|max:10',
            'quilometragem' => 'required|numeric',
            'modelo' => 'required|string|max:50',
            'marca' =>'required|string|max:50'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }


        $car = Car::findOrFail($id);
        $car->update($request->all());




        return response()->json([
            'status' => true,
            'message' => 'Sucesso ao alterar esse carro',
            'data' => $car
        ], 200);
    }


    public function destroy($id)
    {
        $car = Car::findOrFail($id);
       
        if ($car) {
            $car->delete();
            return response()->json(['message' => 'Registro do carro deletado com sucesso'], 200);
        } else {
            return response()->json(['error' => 'Registro não encontrado'], 404);
        }
    }

}
