<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use Illuminate\Database\QueryException;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $rows = Sport::all();
           
            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $rows
            ];
        } catch (\Exception $e) {
            $status = 500;
            $data = [
                'message' => "Server error: {$e->getCode()}",
                'data' => $rows
            ];
        }

        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSportRequest $request)
    {
        //
        try {
            $row = Sport::create($request->all());
 
            $data = [
                'message' => 'ok',
                'data' => $row
            ];
            // Sikeres válasz: 201 Created kód ajánlott új erőforrás létrehozásakor
            return response()->json($data, 201, options: JSON_UNESCAPED_UNICODE);
        } catch (QueryException $e) {
            // Ellenőrizzük, hogy ez egy "Duplicate entry for key" hiba-e (MySQL hibakód: 23000 vagy 1062)
            if ($e->getCode() == 23000 || str_contains($e->getMessage(), 'Duplicate entry')) {
                $data = [
                    'message' => 'Insert error: The given name already exists, please choose another one',
                    'data' => [
                        'name' => $request->input('name') // Visszaküldhetjük, mi volt a hibás
                    ]
                ];
                // Kliens hiba, ami jelzi a kérés érvénytelenségét
                return response()->json($data, 409, options: JSON_UNESCAPED_UNICODE); // 409 Conflict ajánlott
            }
 
            // Ha nem ez a hiba volt, dobjuk tovább az eredeti kivételt, vagy kezeljük másképp
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $id)
    {
        //
        $row = Sport::find($id);
        if ($row) {
            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
        } else {
 
            $status = 404;
            $data = [
                'message' => "Not found id: $id",
                'data' => null
            ];
 
        }
 
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSportRequest $request, Sport $sport)
    {
        //
        $row = Sport::find($sport);
        if ($row) {
            $status = 200;
            $row->update($request->all());
            $data = [
                'message' => 'OK',
                'data' => [$row],
           
            ];
        } else {
 
            $status = 404;
            $data = [
                'message' => "Patch error. Not found id: $sport",
                'data' => null
            ];
 
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $id)
    {
        //
        $row = Sport::find($id);
        if ($row) {
            $status = 200;
            $row->delete($id);
            $data = [
                'message' => 'OK',
                'data' => [
                    'id' =>$id
                ],
           
            ];
        } else {
 
            $status = 404;
            $data = [
                'message' => "Not found id: $id",
                'data' => null
            ];
 
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }
    }

