<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Validator;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Role::paginate(10), 200);
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
            'libelle' => 'required|unique:roles'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        else{
            $role = new Role();
            
            $profil = $request->libelle; 
            $role->libelle = strtoupper($profil); 
            // dd($role);
            $role->save();
            return response()->json($role, 201);
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
        $role = Role::find($id);
        if (is_null($role)) {
            # code...
            return response()->json('Cette role n\'existe pas', 404);
        }
        return response()->json($role, 200);
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
        $role=Role::find($id);
        if($role === null)
        {
            return response()->json('Cette role n\'existe pas', 404);
        }

        $validateData = [
            'libelle' => 'required|unique:roles'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        $profil = $request->libelle; 
        $role->libelle = strtoupper($profil);
        $role->update();
        return response()->json($role, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role=Role::find($id);
        if($role === null)
        {
            return response()->json('Cette role n\'existe pas', 404);
        }
        // $user->statut = true;
        // $user->update();
        $role->delete();
        return response()->json(null, 204);
    }
}
