<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = DB::table('users')->paginate(10);
            return response()->json(['message' => 'Users', $users], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
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
        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json(['message' => 'No such user'], 404);
            }
            return response()->json(['message' => 'User', $user], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
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
        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json(['message' => 'No such user'], 404);
            }
            $user->update($request->all());
            return response()->json(['message' => 'Update Success', $user], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if (is_null($user)) {
                return response()->json(['message' => 'No such user'], 404);
            }
            $user->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }
}
