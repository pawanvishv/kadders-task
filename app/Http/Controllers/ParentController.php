<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Child;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreParentRequest;
use App\Http\Requests\UpdateParentRequest;
use Illuminate\Validation\ValidationException;

class ParentController extends Controller
{
    public function view()
    {
        if (request()->ajax()) {
            $query = ParentModel::with(['children', 'country', 'state', 'city']);
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = 'parents/' . $row->id;
                    $deleteUrl = 'parents/' . $row->id;
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning me-1">Edit</a>
                    <button type="submit" data-url="' . $deleteUrl . '" id="delete-contacts" class="btn btn-sm btn-danger">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('parents.index');
    }
    public function index()
    {
        return ParentModel::with(['children', 'country', 'state', 'city'])->get();
    }

    public function create()
    {
        return view('parents.create');
    }

    public function store(StoreParentRequest $request)
    {
        try {
            $request->validated();

            $data = $request->all();
            $data['age'] = \Carbon\Carbon::parse($request->birth_date)->age;
            if ($request->hasFile('residential_proof')) {
                $files = [];
                foreach ($request->file('residential_proof') as $file) {
                    $files[] = $file->store('residential_proofs', 'public');
                }
                $data['residential_proof'] = $files;
            }
            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
            }

            $parent = ParentModel::create($data);

            if ($request->children) {
                $parent->children()->attach($request->children);
            }

            return response()->json([
                'message' => 'Parent created successfully',
                'data' => $parent
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        return ParentModel::with(['children', 'country', 'state', 'city'])->findOrFail($id);
    }

    public function update(UpdateParentRequest $request, $id)
    {
        try {
            $parent = ParentModel::findOrFail($id);
            $data = $request->all();
            $data['age'] = \Carbon\Carbon::parse($request->birth_date)->age;

            if ($request->hasFile('residential_proof')) {
                $files = [];
                foreach ($request->file('residential_proof') as $file) {
                    $files[] = $file->store('residential_proofs', 'public');
                }
                $data['residential_proof'] = $files;
            }

            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
            }

            $parent->update($data);

            if ($request->children) {
                $parent->children()->sync($request->children);
            }

            return response()->json([
                'message' => 'Parent updated successfully',
                'data' => $data
            ]);
        } catch (ValidationException $e) {
            // Return validation errors in JSON
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $parent = ParentModel::findOrFail($id);
        $parent->delete(); // soft delete
        return response()->json(['message' => 'Parent deleted successfully']);
    }

    public function restore($id)
    {
        $parent = ParentModel::withTrashed()->findOrFail($id);
        $parent->restore();
        return response()->json(['message' => 'Parent restored successfully']);
    }

    public function forceDelete($id)
    {
        $parent = ParentModel::withTrashed()->findOrFail($id);
        $parent->forceDelete();
        return response()->json(['message' => 'Parent permanently deleted']);
    }

    public function fetchChildParent() {

        if (request()->get('child') == 'yes') {
            $data = Child::get();
        } else {
             $data = ParentModel::get();
        }

        return response()->json([
                'message' => 'Fetch succesfully successfully',
                'data' => $data
            ]);
    }
}
