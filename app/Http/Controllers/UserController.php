<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Cantine;
use App\Models\Facture;
use App\Models\Role_User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Resource\UserResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('role')->paginate(10);
        return response()->json($data, 200);
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
            'prenom' => 'required',
            'nom' => 'required',
            'telephone' => 'required',
            'adresse' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'type' => 'required',
            'avatar' => ['required', 'image', 'max:64']
        ];
        $validator = Validator::make($request->all(), $validateData);
        if($validator->fails())
        {
            $errors = $validator->errors();
             return response()->json($errors, 400);
        }
        else{
            $user = new User();
            $roleAdmin = Role::find(1);
            $roleClient = Role::find(2);
            $lastOne = DB::table('users')->latest('id')->first();

            $password = Hash::make($request->password);
            $remember_token = Str::random(10);

            $user->prenom = $request->prenom; 
            $user->nom = $request->nom; 
            $user->telephone = $request->telephone; 
            $user->adresse = $request->adresse; 
            $user->email = $request->email; 
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->password = $request->password; 
            $user->type = $request->type; 
            $user->remember_token = $remember_token;
            $user->password = $password; 
            $user->statut = false; 

            $avatar = $request->files->get("avatar");
            $image = fopen($avatar->getRealPath(),"rb");
            $size=filesize ($avatar);
            $contents= fread ($image, $size);

            $user->avatar = $contents;

            // $user->cantine_id = $request->cantine_id; 
            // $user->facture_id = $request->facture_id; 

            if($user->type  == 'ADMIN')
            {
                $user->role_id = $roleAdmin->id;
            }
            elseif($user->type  == 'CLIENT')
                {
                    $user->role_id = $roleClient->id;
                }

                // dd($user);
              $user->save();
              fclose ($image) ;
            return response()->json($user, 201);
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
        $user = User::find($id);
        if (is_null($user)) {
            # code...
            return response()->json('Cet utilisateur n\'existe pas', 404);
        }
        return response()->json($user, 200);
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
        $user=User::find($id);
        if($user === null)
        {
            return response()->json('Cet utilisateur n\'existe pas', 404);
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
            return response()->json('Cet utilisateur n\'existe pas', 404);
        }
        $user->statut = true;
        $user->update();
        // $user->delete();
        return response()->json(null, 204);
    }
}
