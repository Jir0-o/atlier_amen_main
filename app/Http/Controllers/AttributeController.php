<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Attribute::select('id', 'name', 'slug')->latest();
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-sm btn-primary editBtn" data-slug="' . $row->slug . '">Edit</button>';
                    $delete = '<button class="btn btn-sm btn-danger deleteBtn" data-slug="' . $row->slug . '">Delete</button>';
                    $manage = '<button class="btn btn-sm btn-info manage-values" data-id="' . $row->id . '" data-name="' . e($row->name) . '" data-slug="' . $row->slug . '">Manage Values</button>';
                    return "{$edit} {$delete} {$manage}";
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.attribute.attributes');
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'name' => ['required', 'string', 'max:255', $id
                ? Rule::unique('attributes', 'name')->ignore($id)
                : Rule::unique('attributes', 'name')],
            'slug' => [$id
                ? Rule::unique('attributes', 'slug')->ignore($id)
                : Rule::unique('attributes', 'slug')],
        ];

        $validated = $request->validate($rules);

        try {
            $data = [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
            ];

            if ($id) {
                $attr = Attribute::findOrFail($id);
                $attr->update($data);
                $message = 'Attribute updated successfully.';
            } else {
                $attr = Attribute::create($data);
                $message = 'Attribute created successfully.';
            }

            return response()->json([
                'success' => true,
                'data' => $attr,
                'message' => $message,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit(Attribute $attribute)
    {
        return response()->json($attribute);
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return response()->json([
            'success' => true,
            'message' => 'Attribute deleted.',
        ]);
    }
}

