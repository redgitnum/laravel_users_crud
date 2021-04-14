<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UpdateRequest;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegistrationRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    private $userTypes = [
        'lecturer',
        'worker'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //get all user with additional attributes from both user type tables
        $users = User::with('lecturer', 'worker')->get();
        $users = $users->map(function($user, $key) {
            $base = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $user->user_type,
            ]; 
            $details = [];
            //add details from both user type tables
            foreach ($this->userTypes as $type) {
                $details[] = $user->$type ? $user->$type->toArray() : [];
            }
            //merge all details for better viewing experience
            $details = array_reduce($details, 'array_merge', []);
            return array_merge($base, $details);
        });
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationRequest $request)
    {   
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $newUser = User::create($validated);
        //create data from request to be used for each user type model
        $details = array_merge($request->validated(), ['user_id' => $newUser->id]);
        //dynamic model usage for extra user type model in the future
        foreach ($details['user_type'] as $typeName) {
            $typeModel = 'App\\Models\\'.ucfirst($typeName);
            $typeModel::create($details);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //find user by his id or show 404 if no user with that id found
        $user = User::with(['lecturer', 'worker'])->findOrFail($id);
        //get only basic details from user
        $base = $user->only(['id', 'name','email', 'user_type']);
        $additionalDetails = [];
        //get additional details from user type tables and put them in a single array
        foreach ($user->relationsToArray() as $detail) {
            $additionalDetails[] = $detail ? $detail : [];
        }
        //merge basic details and additional details for better formatting
        $additionalDetails = array_reduce($additionalDetails, 'array_merge', []);
        return response()->json(array_merge($base, $additionalDetails));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        //update base user model
        //updates only attributes specified in User model under $fillable
        $user->update($validated);

        //update or remove records in lecturer / worker table if needed
        //this->userTypes used to check all available user types and add/remove types in the future
        foreach ($this->userTypes as $typeName) {
            $typeModel = 'App\\Models\\'.ucfirst($typeName);
            //check if someone changed user type
            if(!in_array($typeName, $user->user_type)){
                //remove user type table if not found in main user table under column:user_type
                $typeModel::where('user_id', $id)->delete();
            } else {
                //update or create table for specific user type
                $typeModel::updateOrCreate(['user_id' => $id], $validated);
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'User '.$user->id.' updated successfully'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            User::findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User '.$id.' deleted successfully'
            ]);
        } catch(ModelNotFoundException $e){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
    }
}
