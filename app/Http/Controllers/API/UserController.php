<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data User berhasil ditampilkan'
            ],
            'data' => $users
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validator = $request->validate();

        if(!$validator) {
            $response = [
                'meta' => [
                    'status' => 'error',
                    'code' => 422,
                    'message' => 'Data user gagal ditambahkan',
                ]
            ];
            return response()->json($response, 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles,
            'password' => bcrypt($request->password),
        ]);

        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data user berhasil ditambahkan',
            ],
            'data' => $user,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::find($user->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data user berhasil ditampilkan',
            ],
            'data' => $user,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user = User::find($user->id);
        $validator = $request->validate();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles,
            'password' => bcrypt($request->password),
        ]);

        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data user berhasil diubah',
            ],
            'data' => $user,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user = User::find($user->id);
        $user->delete();
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data user berhasil dihapus',
            ],
            'data' => $user,
        ];
        return response()->json($response, 200);
    }
}
