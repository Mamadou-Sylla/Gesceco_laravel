<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Cantine;
use App\Models\Facture;
use Illuminate\Http\Request;


class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Facture::paginate(10);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'numero' => 'size:8|unique:factures',
            'montant' => 'required',
            'user_id' => 'required',
            'cantine_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        else{
            $facture = new Facture();
            $cantineId = $request->cantine_id;
            $cantine = Cantine::find($cantineId);
            $n = rand(0000,9999);
            $facture->numero =  $n.$cantine->numero; 
            $facture->montant = $request->montant; 
            $facture->date = date('Y-m-d H:i:s'); 
            $facture->user_id = $request->user_id; 
            $facture->cantine_id = $request->cantine_id; 

            $facture->save();
            return response()->json($facture, 201);
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
        $facture = Facture::find($id);
        if (is_null($facture)) {
            # code...
            return response()->json('Cette facture n\'existe pas', 404);
        }
        return response()->json($facture, 200);
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
        $facture = Facture::find($id);
        if($facture === null)
        {
            return response()->json('Cette facture n\'existe pas', 404);
        }
        
        $validateData = [
            'date' => 'required',
            'montant' => 'required',
            'user_id' => 'required',
            'cantine_id' => 'required'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        $facture->montant = $request->montant; 
        $facture->date =  $request->date; 
        $facture->user_id = $request->user_id; 
        $facture->cantine_id = $request->cantine_id; 

        $facture->update();
        return response()->json($facture, 200);
        // $user->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $facture = Facture::find($id);
        if($facture === null)
        {
            return response()->json('Cete facture n\'existe pas', 404);
        }
        $facture->delete();
        return response()->json(null, 204);
    }
}
