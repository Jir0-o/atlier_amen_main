<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class AttributeValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can Access Attribute Value')->only('index', 'store', 'update', 'destroy');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AttributeValue::with('attribute')->latest();
            if ($request->filled('attribute_id')) {
                $query->where('attribute_id', $request->attribute_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('attribute_name', fn($row) => $row->attribute?->name)
                ->addColumn('action', function ($row) {
                    $edit = '<button class="btn btn-sm btn-primary editValueBtn" data-slug="' . $row->slug . '">Edit</button>';
                    $delete = '<button class="btn btn-sm btn-danger deleteValueBtn" data-slug="' . $row->slug . '">Delete</button>';
                    return "{$edit} {$delete}";
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $attributes = Attribute::orderBy('name')->get();
        return view('backend.attribute.attributes_value', compact('attributes'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'attribute_id' => ['required', 'exists:attributes,id'],
            'value' => ['required', 'string', 'max:255', $id
                ? Rule::unique('attribute_values', 'value')->ignore($id)
                : Rule::unique('attribute_values', 'value')],
            'slug' => [$id
                ? Rule::unique('attribute_values', 'slug')->ignore($id)
                : Rule::unique('attribute_values', 'slug')],
        ];

        $validated = $request->validate($rules);

        try {
            $data = [
                'attribute_id' => $validated['attribute_id'],
                'value' => $validated['value'],
                'slug' => $validated['slug'],
            ];

            if ($id) {
                $av = AttributeValue::findOrFail($id);
                $av->update($data);
                $message = 'Attribute value updated successfully.';
            } else {
                $av = AttributeValue::create($data);
                $message = 'Attribute value created successfully.';
            }

            return response()->json([
                'success' => true,
                'data' => $av,
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

    public function edit(AttributeValue $attribute_value)
    {
        return response()->json($attribute_value);
    }

    public function destroy(AttributeValue $attribute_value)
    {
        $attribute_value->delete();
        return response()->json([
            'success' => true,
            'message' => 'Attribute value deleted.',
        ]);
    }
}
