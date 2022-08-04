<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $comapanies = DB::table('companies')->paginate(10);
            return response()->json(['message' => 'Companies', $comapanies], 200);
        } catch (Exception $exception) {
            return 'Something went wrong!';
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
                'name' => 'required|string',
                'email' => 'required|email',
                'location' => 'required|string',
                'reg_number' => 'required|integer',
                'telephone' => 'required|string',
                'website' => 'required|string',
                'logo' => 'required|image|mimes:jpg,png',
                'cover_images' => 'required|image|mimes:jpg,png',
            ]);
            $logo_image_uploaded_path = $request->file('logo')->store('logos', 'public');
            $cover_image_uploaded_path = $request->file('cover_images')->store('cover_images', 'public');
            $company = new Company;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->location = $request->location;
            $company->reg_number = $request->reg_number;
            $company->telephone = $request->telephone;
            $company->website = $request->website;
            $company->logo = $logo_image_uploaded_path;
            $company->cover_images = $cover_image_uploaded_path;
            $company->save();
            return response()->json(['message' => 'Company create Success', $company], 200);
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
            $company = Company::find($id);
            if (is_null($company)) {
                return response()->json(['message' => 'No such company'], 404);
            }
            return response()->json(['message' => 'Company', $company], 200);

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
            $company = Company::find($id);
            if (is_null($company)) {
                return response()->json(['message' => 'No such Company'], 404);
            }
            $logo_image_uploaded_path = $request->file('logo')->store('logos', 'public');
            $company->logo = $logo_image_uploaded_path;
            $cover_image_uploaded_path = $request->file('cover_images')->store('cover_images', 'public');
            $company->cover_images = $cover_image_uploaded_path;
            $company->name = $request->name;
            $company->email = $request->email;
            $company->location = $request->location;
            $company->reg_number = $request->reg_number;
            $company->telephone = $request->telephone;
            $company->website = $request->website;
            $company->save();
            return response()->json(['message' => 'Company update Success', $company], 200);
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
            $company = Company::find($id);
            if (is_null($company)) {
                return response()->json(['message' => 'No such Company'], 404);
            }
            $company->delete();
            return response()->json(['message' => 'Delete Success'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }
}
