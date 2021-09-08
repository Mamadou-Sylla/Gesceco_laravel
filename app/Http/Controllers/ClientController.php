<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Cantine;
use Illuminate\Http\Request;
use App\Resource\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;



class ClientController extends Controller
{
    /**
     * Store all users.
     */
    // public $users;

    // public function __construct()
    // {
    //     $this->cantines = User::cantines();
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $clients = User::where(['type' => 'CLIENT'])->paginate(10);
        $client =  User::with('cantines')->where(['type' => 'CLIENT'])->paginate(10);
        $users = UserResource::collection($client);
        return response()->json($users, 200);
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
            'prenom' => 'required',
            'nom' => 'required',
            'telephone' => 'required',
            'adresse' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        else{
            $client = new User();
            $roleClient = Role::find(2);

            $password = Hash::make($request->password);
            $remember_token = Str::random(10);

            $client->prenom = $request->prenom; 
            $client->nom = $request->nom; 
            $client->telephone = $request->telephone; 
            $client->adresse = $request->adresse; 
            $client->email = $request->email; 
            $client->email_verified_at = date('Y-m-d H:i:s');
            $client->password = $request->password; 
            $client->type = 'CLIENT'; 
            $client->remember_token = $remember_token;
            $client->password = $password; 
            $client->statut = false; 
            $client->role_id = $roleClient->id;
            $client->save();
            return response()->json($client, 201);
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
        $client =  User::with('cantines')->findOrFail($id);
        if (is_null($client) || !$client) {
            # code...
            return response()->json('Cet client n\'existe pas', 404);
        }
        if ($client->type === 'ADMIN') {
            # code...
            return response()->json('Cet ustilisateur n\'est pas un client', 404);
        }
        else{
            
        return response()->json($client, 200);
        }        
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
        $user=User::with('cantines')->findOrFail($id);
        if($user === null)
        {
            return response()->json('Cet client n\'existe pas', 404);
        }
        elseif ($user->type === 'ADMIN') {
            # code...
            return response()->json('Cet client n\'est pas un client', 404);
        }
        
        $validateData = [
            'email' => 'email'
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }

        
        $user->update($request->all());
        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);
        if($user === null)
        {
            return response()->json('Cet client n\'existe pas', 404);
        }
        elseif ($user->type === 'ADMIN') {
            # code...
            return response()->json('Cet client n\'est pas un client', 404);
        }
        $user->statut = true;
        $user->update();
        // $user->delete();
        return response()->json(null, 204);
    }
}
