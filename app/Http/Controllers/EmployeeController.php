<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $employees = DB::table('employees')->paginate(10);
            return response()->json(['message' => 'Employees', $employees], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'company' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'profile_photo' => 'required|image|mimes:jpg,png',
            ]);
            $profile_image_uploaded_path = $request->file('profile_photo')->store('profile_images', 'public');
            $employee = new Employee;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company = $request->company;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->profile_photo = $profile_image_uploaded_path;
            $employee->save();
            return response()->json(['message' => 'Employee create Success', $employee], 200);
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
            $employee = Employee::find($id);
            if (is_null($employee)) {
                return response()->json(['message' => 'No such employee'], 404);
            }
            return response()->json(['message' => 'Employee', $employee], 200);

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
            dd($request->all());
            $employee = Employee::find($id);
            if (is_null($employee)) {
                return response()->json(['message' => 'No such employee'], 404);
            }
            $profile_image_uploaded_path = $request->file('profile_photo')->store('profile_images', 'public');
            $employee->profile_photo = $profile_image_uploaded_path;
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company = $request->company;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->save();
            return response()->json(['message' => 'Employee update Success', $employee], 200);
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
            $employee = Employee::find($id);
            if (is_null($employee)) {
                return response()->json(['message' => 'No such employee'], 404);
            }
            $employee->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }
}
