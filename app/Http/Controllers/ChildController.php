<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;

class ChildController extends Controller
{
    public function index()
    {
        return Child::with(['parents','country','state','city'])->get();
    }

    public function store(StoreChildRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['age'] = \Carbon\Carbon::parse($request->birth_date)->age;

        // Upload residential proofs
        if ($request->hasFile('birth_certificate')) {
            $file = $request->file('birth_certificate');
            $data['birth_certificate'] = $file ? $file->store('birth_certificates', 'public') : null;
        } else {
            $data['birth_certificate'] = null;
        }

        if($request->hasFile('profile_image')){
            $data['profile_image'] = $request->file('profile_image')->store('profile_images','public');
        }

        $child = Child::create($data);

        if($request->parents){
            $child->parents()->attach($request->parents);
        }

        return response()->json($child, 201);
    }

    public function show($id)
    {
        return Child::with(['parents','country','state','city'])->findOrFail($id);
    }

    public function update(UpdateChildRequest $request, $id)
    {
        $request->validated();
        $child = Child::findOrFail($id);

        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>"required|email|unique:parents,email,$id",
            'country_id'=>'required|exists:countries,id',
            'birth_date'=>'required|date',
            'state_id'=>'required|exists:states,id',
            'city_id'=>'required|exists:cities,id',
            'birth_certificate.*'=>'file|mimes:jpg,png,pdf',
            'profile_image'=>'file|image',
            'children'=>'array'
        ]);

        $data = $request->all();
        $data['age'] = \Carbon\Carbon::parse($request->birth_date)->age;

        if ($request->hasFile('birth_certificate')) {
            $file = $request->file('birth_certificate');
            $data['birth_certificate'] = $file ? $file->store('birth_certificates', 'public') : null;
        }

        if($request->hasFile('profile_image')){
            $data['profile_image'] = $request->file('profile_image')->store('profile_images','public');
        }

        $child->update($data);

        if($request->parents){
            $child->parents()->attach($request->parents);
        }

        return response()->json($child);
    }

    public function destroy($id)
    {
        $child = Child::findOrFail($id);
        $child->delete(); // soft delete
        return response()->json(['message'=>'Parent deleted successfully']);
    }

    public function restore($id)
    {
        $child = Child::withTrashed()->findOrFail($id);
        $child->restore();
        return response()->json(['message'=>'Parent restored successfully']);
    }

    public function forceDelete($id)
    {
        $child = Child::withTrashed()->findOrFail($id);
        $child->forceDelete();
        return response()->json(['message'=>'Parent permanently deleted']);
    }
}

