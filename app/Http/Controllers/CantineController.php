<?php

namespace App\Http\Controllers;

use App\Models\Cantine;
use Illuminate\Http\Request;
use App\Resource\CantineResource;
use Validator;

class CantineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cantine =  Cantine::paginate(10);
        return response()->json($cantine, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = [
            'numero' => 'required|unique:cantines',
            'batiment' => 'required'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        else{
            $cantine = new Cantine();
            
            $cantine->numero = $request->numero; 
            $cantine->batiment = $request->batiment; 
            $cantine->user_id = $request->user_id; 
            $cantine->bloque = false; 
            // dd($cantine);
            $cantine->save();
            return response()->json($cantine, 201);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cantine = Cantine::find($id);
        if (is_null($cantine)) {
            # code...
            return response()->json('Cette cantine n\'existe pas', 404);
        }
        return response()->json($cantine, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cantine= Cantine::find($id);
        if($cantine === null)
        {
            return response()->json('Cette cantine n\'existe pas', 404);
        }

        $validateData = [
            'numero' => 'required|unique:cantines'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        $cantine->numero = $request->numero; 
        $cantine->batiment = $request->batiment; 
        $cantine->user_id = $request->user_id;  
        $cantine->update();
        return response()->json($cantine, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cantine = Cantine::find($id);
        if($cantine === null)
        {
            return response()->json('Cette cantine n\'existe pas', 404);
        }
        $cantine->bloque = true;
        $cantine->update();
        // $user->delete();
        return response()->json(null, 204);
    }
}
