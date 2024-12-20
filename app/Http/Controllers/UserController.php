<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return ["users" => UserResource::collection(User::all())];
    }

    public function store(UserRequest $request)
    {
        return ["user" => new UserResource(User::create($request->validated()))];
    }


    public function show(User $user)
    {
        return ["user" => new UserResource($user)];
    }


    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['string', 'max:100'],
            'email' => ['email', Rule::unique('users')->ignore($user->id)],
            'password' => ['string', 'min:10', 'max:100'],
            'phone' => ['string', 'min:11', 'max:11'],
            'birthday' => ['date'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 404);
        }

        $user->update($validator->validated());

        return ["user" => new UserResource($user)];
    }

    public function destroy(User $user)
    {
        $user->delete();
        return [
            'status' => 'Success'
        ];
    }
}
