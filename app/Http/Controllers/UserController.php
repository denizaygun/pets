<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ALL USERS
     */
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    /**
     * CREATES A USER
     * @param  CreateUserRequest  $request
     * @return string
     */
    public function store(CreateUserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->profile_picture = $request->profile_picture;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return 'Successfully created a new user!';
    }

    /**
     * RETRIEVES A USER
     *
     * https://rescuefrens.tr/profile/1
     */
    public function show($id): JsonResponse
    {
        return response()->json(User::find($id));
    }

    /**
     * UPDATES A USER
     * @param  Request  $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->profile_picture = $request->profile_picture;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    /**
     * DELETES A USER
     */
    public function destroy($id): array
    {
        // if auth::user is an admin then allow this...
        $user = User::findOrFail($id);
        $user->delete();

        return ["success" => true, "message" => "Successfully soft-deleted $user->name from the database"];
    }
}
