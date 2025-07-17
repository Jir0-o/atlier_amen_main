<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('id', 'name', 'slug', 'category_image', 'image_left', 'image_right')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category_image', function ($row) {
                    if ($row->category_image) {
                        return '<img src="' . asset($row->category_image) . '" class="img-thumbnail preview-img" data-src="' . asset($row->category_image) . '" style="height:40px;width:auto;cursor:pointer;border-radius:4px;">';
                    }
                    return '';
                })
                ->addColumn('image_left', function ($row) {
                    if ($row->image_left) {
                        return '<img src="' . asset($row->image_left) . '" class="img-thumbnail preview-img" data-src="' . asset($row->image_left) . '" style="height:40px;width:auto;cursor:pointer;border-radius:4px;">';
                    }
                    return '';
                })
                ->addColumn('image_right', function ($row) {
                    if ($row->image_right) {
                        return '<img src="' . asset($row->image_right) . '" class="img-thumbnail preview-img" data-src="' . asset($row->image_right) . '" style="height:40px;width:auto;cursor:pointer;border-radius:4px;">';
                    }
                    return '';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary editBtn" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">Delete</button>
                    ';
                })
                ->rawColumns(['action', 'category_image', 'image_left', 'image_right'])
                ->make(true);
        }

        return view('backend.category.category');
    }



    public function store(Request $request)
    {
        $id = $request->input('id');

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:categories,slug,' . $id,
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_left'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_right'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // find or new
        $category = Category::find($id) ?? new Category();

        $category->name = $validated['name'];
        $category->slug = $validated['slug'];

        // images
        if ($request->hasFile('category_image')) {
            $category->category_image = $this->handleImageUpload(
                $request->file('category_image'),
                $category->category_image
            );
        }
        if ($request->hasFile('image_left')) {
            $category->image_left = $this->handleImageUpload(
                $request->file('image_left'),
                $category->image_left
            );
        }
        if ($request->hasFile('image_right')) {
            $category->image_right = $this->handleImageUpload(
                $request->file('image_right'),
                $category->image_right
            );
        }

        $category->save();

        return response()->json([
            'message' => $id ? 'Category updated!' : 'Category added!',
            'category' => $category, 
        ]);
    }

    public function edit($id)
    {
        $cat = Category::findOrFail($id);

        return response()->json([
            'id'   => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'category_image_url' => $cat->category_image ? asset($cat->category_image) : null,
            'image_left_url'     => $cat->image_left ? asset($cat->image_left) : null,
            'image_right_url'    => $cat->image_right ? asset($cat->image_right) : null,
        ]);
    }

    public function category(Category $category)
    {
        $items = $category->works()
            ->latest()
            ->get();

        return view('frontend.works.category', [
            'category' => $category,
            'items'    => $items,
        ]);
    }

    private function handleImageUpload($file, $oldPath = null): ?string
    {
        if (!$file) {
            return $oldPath; // keep existing
        }

        // delete old
        if ($oldPath && file_exists(public_path($oldPath))) {
            @unlink(public_path($oldPath));
        }

        $dest = public_path('uploads/categories');
        if (! is_dir($dest)) {
            mkdir($dest, 0755, true);
        }

        $filename = uniqid('cat_') . '.' . $file->getClientOriginalExtension();
        $file->move($dest, $filename);

        return 'uploads/categories/' . $filename;
    }


    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message' => 'Category deleted!']);
    }
}
