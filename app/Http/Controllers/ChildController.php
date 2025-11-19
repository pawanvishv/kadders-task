<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Child;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Jobs\SendParentNotificationJob;
use App\Http\Requests\StoreChildRequest;
use App\Http\Requests\UpdateChildRequest;
use Illuminate\Validation\ValidationException;

class ChildController extends Controller
{
    public function view()
    {
        if (request()->ajax()) {
            $query = Child::with(['parent', 'country', 'state', 'city']);
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = 'children/' . $row->id;
                    $deleteUrl = 'children/' . $row->id;
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning me-1">Edit</a>
                    <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure you want to delete this record?\');">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('children.index');
    }
    public function index()
    {
        return Child::with(['parent', 'country', 'state', 'city'])->get();
    }

    public function create()
    {
        return view('children.create');
    }


    public function store(StoreChildRequest $request)
    {
        try {
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

            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
            }

            $child = Child::create($data);

            if ($request->parents) {
                $child->parents()->attach($request->parents);
                SendParentNotificationJob::dispatch($child, $request->parents)->delay(now()->addMinutes(5));
            }

            return response()->json([
                'message' => 'Child created successfully',
                'data' => $child
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
        return Child::with(['parents', 'country', 'state', 'city'])->findOrFail($id);
    }

    public function update(UpdateChildRequest $request, $id)
    {
        try {
            $request->validated();
            $child = Child::findOrFail($id);

            $data = $request->all();
            $data['age'] = \Carbon\Carbon::parse($request->birth_date)->age;

            if ($request->hasFile('birth_certificate')) {
                $file = $request->file('birth_certificate');
                $data['birth_certificate'] = $file ? $file->store('birth_certificates', 'public') : null;
            }

            if ($request->hasFile('profile_image')) {
                $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
            }

            $child->update($data);

            if ($request->parents) {
                $child->parents()->attach($request->parents);
            }

            return response()->json([
                'message' => 'Child updated successfully',
                'data' => $child
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $child = Child::findOrFail($id);
        $child->delete(); // soft delete
        return back();
    }

    public function restore($id)
    {
        $child = Child::withTrashed()->findOrFail($id);
        $child->restore();
        return response()->json(['message' => 'Parent restored successfully']);
    }

    public function forceDelete($id)
    {
        $child = Child::withTrashed()->findOrFail($id);
        $child->forceDelete();
        return response()->json(['message' => 'Parent permanently deleted']);
    }
}
