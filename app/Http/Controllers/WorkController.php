<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\WorkGallery;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;

class WorkController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Work::with('category')->latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category', fn($row) => $row->category?->name ?? '—')
                ->addColumn('work_image', function ($row) {
                    return '<img src="'.$row->work_image_url.'" class="img-thumbnail preview-img" data-src="'.$row->work_image_url.'" style="max-width:60px;">';
                })
                ->addColumn('image_left', function ($row) {
                    return '<img src="'.$row->image_left_url.'" class="img-thumbnail preview-img" data-src="'.$row->image_left_url.'" style="max-width:60px;">';
                })
                ->addColumn('image_right', function ($row) {
                    return '<img src="'.$row->image_right_url.'" class="img-thumbnail preview-img" data-src="'.$row->image_right_url.'" style="max-width:60px;">';
                })
                ->addColumn('featured', function ($row) {
                    return $row->is_featured ? '<span class="badge bg-warning">Featured</span>' : '<span class="badge bg-secondary">Normal</span>';
                })
                ->editColumn('work_date', fn($row) => $row->work_date?->format('Y-m-d') ?? '—')
                ->editColumn('tags', fn($row) => e($row->tags ?? '—'))
                ->editColumn('is_active', function ($row) {
                    $badge = $row->is_active ? 'success' : 'secondary';
                    $text  = $row->is_active ? 'Active' : 'Inactive';
                    return '<span class="badge bg-'.$badge.'">'.$text.'</span>';
                })
                ->addColumn('action', function ($row) {
                    // Common buttons
                    $buttons = '
                        <button class="btn btn-info btn-sm viewWorkBtn" data-id="'.$row->id.'">View</button>
                        <button class="btn btn-primary btn-sm editWorkBtn" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-danger btn-sm deleteWorkBtn" data-id="'.$row->id.'">Delete</button>
                    ';

                    // Add feature/unfeature button
                    if ($row->is_featured == 1) {
                        $buttons .= '
                            <button class="btn btn-warning btn-sm unfeatureWorkBtn" data-id="'.$row->id.'">Unfeature</button>
                        ';
                    } else {
                        $buttons .= '
                            <button class="btn btn-success btn-sm featureWorkBtn" data-id="'.$row->id.'">Feature</button>
                        ';
                    }

                    return $buttons;
                })
                ->rawColumns(['work_image','image_left','image_right', 'price','quantity','is_active','featured','action'])
                ->make(true);
        }

        // Non-AJAX initial page load: need categories for dropdown
        $categories = Category::orderBy('name')->get(['id','name']);
        return view('backend.work.index', compact('categories'));
    }

    /**
     * Return work data for edit modal.
     */
    public function edit($id)
    {
        $work = Work::with('gallery')->findOrFail($id);

        return response()->json([
            'id'                => $work->id,
            'category_id'       => $work->category_id,
            'name'              => $work->name,
            'work_date'         => optional($work->work_date)->format('Y-m-d'),
            'tags'              => $work->tags,
            'details'           => $work->details,
            'is_active'         => $work->is_active,
            'work_image_url'    => $work->work_image_url,
            'image_left_url'    => $work->image_left_url,
            'image_right_url'   => $work->image_right_url,
            'work_price'        => $work->price,
            'work_quantity'     => $work->quantity,
            'gallery'           => $work->gallery->map(fn($g)=>[
                                        'id'=>$g->id,
                                        'image_url'=>$g->image_url,
                                    ])->values(),
        ]);
    }

    protected function saveImageVariants(\Illuminate\Http\UploadedFile $file, string $fullDir, string $lowDir, string $prefix): array
    {
        $this->ensureDirs([$fullDir, $lowDir]);

        $ext = strtolower($file->getClientOriginalExtension());
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            $ext = 'jpg';
        }

        $base = uniqid($prefix . '_') . '.' . $ext;
        $fullPathAbs = public_path("$fullDir/$base");
        $lowPathAbs  = public_path("$lowDir/$base");

        $manager = new ImageManager(new GdDriver());

        // Choose encoder based on extension
        $encoderFull = match($ext) {
            'png'   => new PngEncoder(),       
            'webp'  => new WebpEncoder(quality: 90),
            default => new JpegEncoder(quality: 90),
        };

        $encoderLow = match($ext) {
            'png'   => new PngEncoder(),    
            'webp'  => new WebpEncoder(quality: 50),
            default => new JpegEncoder(quality: 50),
        };

        // Full image
        $manager->read($file->getRealPath())
            ->encode($encoderFull)
            ->save($fullPathAbs);

        // Low image
        $manager->read($file->getRealPath())
            ->scale(width: 800)
            ->encode($encoderLow)
            ->save($lowPathAbs);

        return [
            'full' => "$fullDir/$base",
            'low'  => "$lowDir/$base",
        ];
    }

    protected function ensureDirs(array $dirs): void
    {
        foreach ($dirs as $rel) {
            $abs = public_path($rel);
            if (!is_dir($abs)) {
                mkdir($abs, 0755, true);
            }
        }
    }

    protected function deleteIfExists(?string $relPath): void
    {
        if (!$relPath) return;

        // If a full URL accidentally passed, strip domain.
        if (filter_var($relPath, FILTER_VALIDATE_URL)) {
            $parsed = parse_url($relPath, PHP_URL_PATH);
            $relPath = ltrim($parsed ?? '', '/');
        }

        $abs = public_path(ltrim($relPath, '/'));
        if (is_file($abs)) {
            @unlink($abs);
        }
    }

    /**
     * Create or update Work.
     */
    public function store(Request $request)
    {
        $workId = $request->input('id'); // null => create

        $rules = [
            'category_id'      => ['required','exists:categories,id'],
            'name'             => ['required','string','max:255'],
            'work_date'        => ['nullable','date'],
            'tags'             => ['nullable','string','max:255'],
            'details'          => ['nullable','string'],
            'is_active'        => ['required','in:0,1'],
            'art_video'        => ['nullable','mimetypes:video/mp4,video/ogg,video/webm','max:51200'],
            'price'            => ['nullable','numeric','min:0'],
            'quantity'         => ['nullable','integer','min:0'],
            'work_image'       => [$workId ? 'nullable' : 'required','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'image_left'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'image_right'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],

            'gallery_images.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];

        $validated = $request->validate($rules);

        // Base directories (relative to public/)
        $fullDir = 'uploads/works/full';
        $lowDir  = 'uploads/works/low';
        $galFull = 'uploads/works/gallery/full';
        $galLow  = 'uploads/works/gallery/low';
        $videoDir = 'uploads/works/videos';
        $this->ensureDirs([$fullDir,$lowDir,$galFull,$galLow,$videoDir]);

        DB::beginTransaction();
        try {
            // Get or create Work
            $work = $workId ? Work::lockForUpdate()->findOrFail($workId) : new Work();

            $work->category_id = $validated['category_id'];
            $work->name        = $validated['name'];
            $work->work_date   = $validated['work_date'] ?? null;
            $work->tags        = $validated['tags'] ?? null;
            $work->details     = $validated['details'] ?? null;

            // is_active: create=1, update=checkbox
            if ($workId) {
                $work->is_active = $request->has('is_active') ? 1 : 0;
            } else {
                $work->is_active = 1;
            }

            /* ------- Main Work Image ------- */
            if ($request->hasFile('work_image')) {
                $this->deleteIfExists($work->work_image);
                $this->deleteIfExists($work->work_image_low);

                $paths = $this->saveImageVariants(
                    $request->file('work_image'),
                    $fullDir,
                    $lowDir,
                    'work'
                );
                $work->work_image     = $paths['full'];
                $work->work_image_low = $paths['low'];
            }

            /* ------- Left Image ------- */
            if ($request->hasFile('image_left')) {
                $this->deleteIfExists($work->image_left);
                $this->deleteIfExists($work->image_left_low);

                $paths = $this->saveImageVariants(
                    $request->file('image_left'),
                    $fullDir,
                    $lowDir,
                    'left'
                );
                $work->image_left     = $paths['full'];
                $work->image_left_low = $paths['low'];
            }

            /* ------- Right Image ------- */
            if ($request->hasFile('image_right')) {
                $this->deleteIfExists($work->image_right);
                $this->deleteIfExists($work->image_right_low);

                $paths = $this->saveImageVariants(
                    $request->file('image_right'),
                    $fullDir,
                    $lowDir,
                    'right'
                );
                $work->image_right     = $paths['full'];
                $work->image_right_low = $paths['low'];
            }

            
            // Art Video
            if ($request->hasFile('art_video')) {
                $this->deleteIfExists($work->art_video);

                $path = $request
                    ->file('art_video')
                    ->store($videoDir, 'public');

                $work->art_video = $path;
            }
            /* ------- Work Price & Quantity ------- */
            $work->price    = $validated['price'] ?? null;
            $work->quantity = $validated['quantity'] ?? null;

            $work->save();

            /* ------- Gallery (append) ------- */
            if ($request->hasFile('gallery_images')) {
                $sortBase = (int) WorkGallery::where('work_id',$work->id)->max('sort_order');

                foreach ($request->file('gallery_images') as $idx => $img) {
                    $paths = $this->saveImageVariants($img, $galFull, $galLow, 'gal');

                    WorkGallery::create([
                        'work_id'        => $work->id,
                        'image_path'     => $paths['full'],
                        'image_path_low' => $paths['low'], // make sure column exists
                        'sort_order'     => $sortBase + $idx + 1,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => $workId ? 'Work updated.' : 'Work created.',
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();

            report($e); // logs error

            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to save Work.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function toggleFeature(Request $request, Work $work)
    {
        $work->is_featured = $request->is_featured ? 1 : 0;
        $work->save();

        return response()->json([
            'message' => $work->is_featured ? 'Work is now Featured!' : 'Work is no longer Featured.'
        ]);
    }


    /**
     * Delete a Work + its images + gallery.
     */
    public function destroy($id)
    {
        $work = Work::with('gallery')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Collect all image paths (work main variants)
            $paths = [
                $work->work_image,
                $work->work_image_low,
                $work->image_left,
                $work->image_left_low,
                $work->image_right,
                $work->image_right_low,
            ];

            // Gallery images
            foreach ($work->gallery as $g) {
                $paths[] = $g->image_path;
                // include low column if exists
                if (property_exists($g, 'image_path_low') || isset($g->image_path_low)) {
                    $paths[] = $g->image_path_low;
                }
            }

            // Delete files
            foreach ($paths as $p) {
                $this->deleteIfExists($p);
            }

            // Delete DB rows (gallery cascade if FK set; but be explicit)
            $work->gallery()->delete();
            $work->delete();

            DB::commit();

            return response()->json(['message' => 'Work deleted.']);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json([
                'message' => 'Failed to delete Work.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Delete a single gallery image (AJAX).
     */
    public function deleteGalleryImage(Request $request, $id)
    {
        $gallery = WorkGallery::findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete files (full + low if present)
            $this->deleteIfExists($gallery->image_path);
            if (property_exists($gallery, 'image_path_low') || isset($gallery->image_path_low)) {
                $this->deleteIfExists($gallery->image_path_low);
            }

            $gallery->delete();

            DB::commit();

            return response()->json(['message' => 'Gallery image removed.']);

        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json([
                'message' => 'Failed to remove gallery image.',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Return Work details for view modal.
     */
    public function show($id)
    {
        $work = Work::with('category','gallery')->findOrFail($id);

        return response()->json([
            'id'            => $work->id,
            'category'      => $work->category?->name,
            'name'          => $work->name,
            'work_date'     => optional($work->work_date)->format('M d, Y'),
            'tags'          => $work->tags,
            'details'       => $work->details,
            'is_active'     => $work->is_active,
            'work_image'    => $work->work_image_url,
            'image_left'    => $work->image_left_url,
            'image_right'   => $work->image_right_url,
            'gallery'       => $work->gallery->map(fn($g)=>[
                                    'id' => $g->id,
                                    'url'=> $g->image_url,
                                ])->values(),
            'created_at'    => $work->created_at?->format('Y-m-d H:i'),
            'updated_at'    => $work->updated_at?->format('Y-m-d H:i'),
        ]);
    }

    public function workShow(Work $work)
    {
        $work->load(['category', 'gallery']); 

        return view('frontend.art-info.art_info', [
            'work'     => $work,
            'category' => $work->category,
        ]);
    }
}
