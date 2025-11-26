<?php

namespace App\Http\Controllers;

use App\Models\Playingsport;
use App\Http\Requests\StorePlayingsportRequest;
use App\Http\Requests\UpdatePlayingsportRequest;
use Illuminate\Support\Facades\DB;

class PlayingsportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
            try {
            //code...
            $rows = Playingsport::all();
            $status =  200;
            $data = [
                'message' => 'OK',
                'data' => $rows
            ];
        } catch (\Exception $e) {
            $status =  500;
            $data = [
                'message' => "Server error: {$e->getCode()}",
                'data' => $rows
            ];
        }
        
           $sql = 'SELECT * FROM playingsports';
           $rows = DB::select($sql);
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(int $id)
    {
       
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        //
         //
          $row = Playingsport::find($id);
        if ($row) {
            # code...
            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
        } else {
            $status = 404;
            $data = [
                'message' => "Not_Found id: $id ",
                'data' => null
            ];
        }

        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayingsportRequest $request, Playingsport $playingsport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playingsport $playingsport)
    {
        //
    }
}
