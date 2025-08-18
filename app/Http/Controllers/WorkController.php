<?php

namespace App\Http\Controllers;

use App\Models\AttributeValue;
use App\Models\Work;
use App\Models\WorkGallery;
use App\Models\Category;
use App\Models\WorkVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

                ->addColumn('work_type', function ($row) {
                    return $row->work_type === 'book'
                        ? '<span class="badge bg-info">Book</span>'
                        : '<span class="badge bg-primary">Art Work</span>';
                })

                ->addColumn('work_image', function ($row) {
                    if ($row->work_type === 'book') {
                        return '<span class="text-muted">—</span>';
                    }
                    $url = $row->work_image_url ?? null;
                    return $url
                        ? '<img src="'.$url.'" class="img-thumbnail preview-img" data-src="'.$url.'" style="max-width:60px;">'
                        : '<span class="text-muted">—</span>';
                })
                ->addColumn('image_left', function ($row) {
                    if ($row->work_type === 'book') {
                        return '<span class="text-muted">—</span>';
                    }
                    $url = $row->image_left_url ?? null;
                    return $url
                        ? '<img src="'.$url.'" class="img-thumbnail preview-img" data-src="'.$url.'" style="max-width:60px;">'
                        : '<span class="text-muted">—</span>';
                })
                ->addColumn('image_right', function ($row) {
                    if ($row->work_type === 'book') {
                        return '<span class="text-muted">—</span>';
                    }
                    $url = $row->image_right_url ?? null;
                    return $url
                        ? '<img src="'.$url.'" class="img-thumbnail preview-img" data-src="'.$url.'" style="max-width:60px;">'
                        : '<span class="text-muted">—</span>';
                })

                ->addColumn('featured', function ($row) {
                    return $row->is_featured
                        ? '<span class="badge bg-warning">Featured</span>'
                        : '<span class="badge bg-secondary">Normal</span>';
                })
                ->editColumn('work_date', fn($row) => $row->work_date?->format('Y-m-d') ?? '—')
                ->editColumn('tags', fn($row) => e($row->tags ?? '—'))
                ->editColumn('is_active', function ($row) {
                    $badge = $row->is_active ? 'success' : 'secondary';
                    $text  = $row->is_active ? 'Active' : 'Inactive';
                    return '<span class="badge bg-'.$badge.'">'.$text.'</span>';
                })
                ->addColumn('action', function ($row) {
                    $buttons = '
                        <button class="btn btn-info btn-sm viewWorkBtn" data-id="'.$row->id.'">View</button>
                        <button class="btn btn-primary btn-sm editWorkBtn" data-id="'.$row->id.'">Edit</button>
                        <button class="btn btn-danger btn-sm deleteWorkBtn" data-id="'.$row->id.'">Delete</button>
                    ';
                    if ($row->is_featured == 1) {
                        $buttons .= '<button class="btn btn-warning btn-sm unfeatureWorkBtn" data-id="'.$row->id.'">Unfeature</button>';
                    } else {
                        $buttons .= '<button class="btn btn-success btn-sm featureWorkBtn" data-id="'.$row->id.'">Feature</button>';
                    }
                    return $buttons;
                })

                ->rawColumns(['work_type','work_image','image_left','image_right', 'price','quantity','is_active','featured','action'])
                ->make(true);
        }

        $categories = Category::orderBy('name')->get(['id','name']);
        return view('backend.work.index', compact('categories'));
    }

    /**
     * Return work data for edit modal.
     */
    public function edit($id)
    {
        $work = Work::with(['gallery', 'variants.attributeValues.attribute'])->findOrFail($id);

        $variants = $work->variants()->with('attributeValues.attribute')->get()->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'attribute_value_ids' => $variant->attributeValues->pluck('id')->values()->all(),
                'attribute_values' => $variant->attributeValues->map(fn($av) => [
                    'id' => $av->id,
                    'value' => $av->value,
                    'slug' => $av->slug,
                    'attribute_id' => $av->attribute_id,
                    'attribute_name' => $av->attribute?->name,
                ])->values()->all(),
                'combination_text' => $variant->combinationText(),
            ];
        });

        return response()->json([
            'id'                => $work->id,
            'variants'          => $variants,
            'category_id'       => $work->category_id,
            'name'              => $work->name,
            'work_date'         => optional($work->work_date)->format('Y-m-d'),
            'tags'              => $work->tags,
            'details'           => $work->details,
            'is_active'         => $work->is_active,
            'work_image_url'    => $work->work_image_url,
            'image_left_url'    => $work->image_left_url,
            'image_right_url'   => $work->image_right_url,
            'art_video_url'     => $work->art_video,
            'work_price'        => $work->price,
            'work_quantity'     => $work->quantity,
            'gallery'           => $work->gallery->map(fn($g)=>[
                                        'id'=>$g->id,
                                        'image_url'=>$g->image_url,
                                    ])->values(),
            'work_type'         => $work->work_type,
            'book_pdf_url'      => $work->book_pdf,
        ]);
    }



    protected function saveImageVariants(\Illuminate\Http\UploadedFile $file, string $fullDir, string $lowDir, string $prefix): array
    {
        $this->ensureDirs([$fullDir, $lowDir]);

        $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) {
            $ext = 'jpg';
        }

        $base = uniqid($prefix . '_') . '.' . $ext;

        $fullRel  = "$fullDir/$base";
        $lowRel   = "$lowDir/$base";
        $fullAbs  = public_path($fullRel);
        $lowAbs   = public_path($lowRel);

        $file->move(public_path($fullDir), $base);

        // === LOW: generate compressed/scaled version ===
        $manager = new ImageManager(new GdDriver());

        $encoderLow = match ($ext) {
            'png'           => new PngEncoder(),  
            'webp'          => new WebpEncoder(quality: 50),
            'jpg','jpeg',   => new JpegEncoder(quality: 50),
            default         => new JpegEncoder(quality: 50),
        };

        $manager->read($fullAbs)
            ->scale(width: 800)  
            ->encode($encoderLow)
            ->save($lowAbs);

        return [
            'full' => $fullRel, 
            'low'  => $lowRel,   
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
        $workId    = $request->input('id'); // null => create
        $isCreate  = empty($workId);
        $workType  = $request->input('work_type'); // 'art' | 'book'

        // ---- Base rules (we'll adjust conditionally) ----
        $workImageRule = ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'];
        $bookPdfRule   = ['nullable','mimes:pdf','max:102400'];

        if ($isCreate) {
            if ($workType === 'art') {
                // On create + art: require work_image
                $workImageRule[0] = 'required';
            } elseif ($workType === 'book') {
                // On create + book: require pdf
                $bookPdfRule[0] = 'required';
            }
        }

        $rules = [
            'category_id'      => ['required','exists:categories,id'],
            'name'             => ['required','string','max:255'],
            'work_date'        => ['nullable','date'],
            'tags'             => ['nullable','string','max:255'],
            'details'          => ['nullable','string'],
            'is_active'        => ['required','in:0,1'],

            // Media
            'art_video'        => ['nullable','mimetypes:video/mp4,video/ogg,video/webm','max:51200'],
            'work_image'       => $workImageRule,
            'image_left'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'image_right'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_images.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],

            // Fallback top-level price/quantity (used only if no variants)
            'price'            => ['nullable','numeric','min:0'],
            'quantity'         => ['nullable','integer','min:0'],

            // Work type
            'work_type'        => ['required','in:art,book'],
            'book_pdf'         => $bookPdfRule,
        ];

        $validated = $request->validate($rules);

        // Base directories (relative to public/)
        $fullDir  = 'uploads/works/full';
        $lowDir   = 'uploads/works/low';
        $galFull  = 'uploads/works/gallery/full';
        $galLow   = 'uploads/works/gallery/low';
        $videoDir = 'uploads/works/videos';
        $bookDir  = 'uploads/works/books';
        $this->ensureDirs([$fullDir,$lowDir,$galFull,$galLow,$videoDir,$bookDir]);

        DB::beginTransaction();
        try {
            // Get or create Work
            $work = $isCreate ? new Work() : Work::lockForUpdate()->findOrFail($workId);

            $work->category_id = $validated['category_id'];
            $work->name        = $validated['name'];
            $work->work_date   = $validated['work_date'] ?? null;
            $work->tags        = $validated['tags'] ?? null;
            $work->details     = $validated['details'] ?? null;
            $work->is_active   = $validated['is_active'];
            $work->work_type   = $validated['work_type']; // 'art' | 'book'

            // ----- Handle media by type -----
            if ($work->work_type === 'book') {
                // Switching to BOOK: remove any art media
                $this->deleteIfExists($work->work_image);
                $this->deleteIfExists($work->work_image_low);
                $this->deleteIfExists($work->image_left);
                $this->deleteIfExists($work->image_left_low);
                $this->deleteIfExists($work->image_right);
                $this->deleteIfExists($work->image_right_low);
                $this->deleteIfExists($work->art_video);
                $work->work_image = $work->work_image_low = null;
                $work->image_left = $work->image_left_low = null;
                $work->image_right = $work->image_right_low = null;
                $work->art_video = null;

                // Save/replace BOOK PDF
                if ($request->hasFile('book_pdf')) {
                    $this->deleteIfExists($work->book_pdf);
                    $pdfFile = $request->file('book_pdf');
                    $ext     = strtolower($pdfFile->getClientOriginalExtension() ?: 'pdf');
                    $name    = uniqid('book_').'.'.$ext;
                    $pdfFile->move(public_path($bookDir), $name);
                    $work->book_pdf = "$bookDir/$name";
                }
            } else {
                // Type = ART
                // If previously book, clear book_pdf
                if (!empty($work->book_pdf)) {
                    $this->deleteIfExists($work->book_pdf);
                    $work->book_pdf = null;
                }

                // Work image
                if ($request->hasFile('work_image')) {
                    $this->deleteIfExists($work->work_image);
                    $this->deleteIfExists($work->work_image_low);
                    $paths = $this->saveImageVariants($request->file('work_image'), $fullDir, $lowDir, 'work');
                    $work->work_image     = $paths['full'];
                    $work->work_image_low = $paths['low'];
                }

                // Left image
                if ($request->hasFile('image_left')) {
                    $this->deleteIfExists($work->image_left);
                    $this->deleteIfExists($work->image_left_low);
                    $paths = $this->saveImageVariants($request->file('image_left'), $fullDir, $lowDir, 'left');
                    $work->image_left     = $paths['full'];
                    $work->image_left_low = $paths['low'];
                }

                // Right image
                if ($request->hasFile('image_right')) {
                    $this->deleteIfExists($work->image_right);
                    $this->deleteIfExists($work->image_right_low);
                    $paths = $this->saveImageVariants($request->file('image_right'), $fullDir, $lowDir, 'right');
                    $work->image_right     = $paths['full'];
                    $work->image_right_low = $paths['low'];
                }

                // Art video
                if ($request->hasFile('art_video')) {
                    $this->deleteIfExists($work->art_video);
                    $videoFile = $request->file('art_video');
                    $ext  = strtolower($videoFile->getClientOriginalExtension() ?: 'mp4');
                    $name = uniqid('vid_') . '.' . $ext;
                    $this->ensureDirs([$videoDir]);
                    $videoFile->move(public_path($videoDir), $name);
                    $work->art_video = "$videoDir/$name";
                }
            }

            // Assign fallback price/quantity for now; may get cleared if variants exist
            $work->price    = $validated['price'] ?? null;
            $work->quantity = $validated['quantity'] ?? null;

            $work->save();

            // ---- VARIANTS PROCESSING ----
            $variantsPayload = json_decode($request->input('variants', '[]'), true) ?: [];

            // Validate variantsPayload manually
            $variantErrors = [];
            if (is_array($variantsPayload)) {
                foreach ($variantsPayload as $idx => $v) {
                    // attribute_value_ids
                    if (empty($v['attribute_value_ids']) || !is_array($v['attribute_value_ids'])) {
                        $variantErrors["variants.$idx.attribute_value_ids"] = ['At least one attribute value must be selected.'];
                    } else {
                        $count = AttributeValue::whereIn('id', $v['attribute_value_ids'])->count();
                        if ($count !== count($v['attribute_value_ids'])) {
                            $variantErrors["variants.$idx.attribute_value_ids"] = ['Some attribute values are invalid.'];
                        }
                    }

                    // price
                    if (!isset($v['price']) || !is_numeric($v['price']) || $v['price'] < 0) {
                        $variantErrors["variants.$idx.price"] = ['Price must be a number >= 0.'];
                    }

                    // stock
                    if (!isset($v['stock']) || !is_numeric($v['stock']) || intval($v['stock']) < 0) {
                        $variantErrors["variants.$idx.stock"] = ['Stock must be an integer >= 0.'];
                    }

                    // sku (optional)
                    if (isset($v['sku']) && !is_string($v['sku'])) {
                        $variantErrors["variants.$idx.sku"] = ['SKU must be a string.'];
                    }
                }
            } else {
                $variantsPayload = [];
            }

            if (!empty($variantErrors)) {
                DB::rollBack();
                return response()->json([
                    'message' => 'Validation Error',
                    'errors'  => $variantErrors,
                ], 422);
            }

            // Delete existing variants to simplify update
            if ($work->variants()->exists()) {
                foreach ($work->variants as $oldVariant) {
                    $oldVariant->attributeValues()->detach();
                    $oldVariant->delete();
                }
            }

            if (count($variantsPayload) > 0) {
                foreach ($variantsPayload as $v) {
                    $attrValIds = $v['attribute_value_ids'] ?? [];
                    sort($attrValIds); // deterministic

                    // SKU generation
                    $baseSku        = Str::slug($work->name) ?: 'variant';
                    $valueSlugs     = AttributeValue::whereIn('id', $attrValIds)->pluck('slug')->toArray();
                    $combinationSlug= implode('-', $valueSlugs);
                    $sku            = $v['sku'] ?? ($baseSku . ($combinationSlug ? '-' . $combinationSlug : ''));

                    // ensure unique SKU
                    $originalSku = $sku;
                    $i = 1;
                    while (WorkVariant::where('sku', $sku)->exists()) {
                        $sku = $originalSku . '-' . $i++;
                    }

                    $variant = WorkVariant::create([
                        'work_id' => $work->id,
                        'sku'     => $sku,
                        'price'   => (float) $v['price'],
                        'stock'   => (int) $v['stock'],
                    ]);

                    if (!empty($attrValIds)) {
                        $variant->attributeValues()->attach($attrValIds);
                    }
                }

                // clear top-level price/quantity because variants are authoritative
                $work->price = null;
                $work->quantity = null;
                $work->saveQuietly();
            } else {
                // No variants: keep top-level price/quantity if provided
            }

            // Gallery (append) — only meaningful for ART; allow keeping on book if you want
            if ($request->hasFile('gallery_images')) {
                $sortBase = (int) WorkGallery::where('work_id', $work->id)->max('sort_order');

                foreach ($request->file('gallery_images') as $idx => $img) {
                    $paths = $this->saveImageVariants($img, $galFull, $galLow, 'gal');

                    WorkGallery::create([
                        'work_id'        => $work->id,
                        'image_path'     => $paths['full'],
                        'image_path_low' => $paths['low'],
                        'sort_order'     => $sortBase + $idx + 1,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => $isCreate ? 'Work created.' : 'Work updated.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
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
            // Delete video if exists
            if ($work->art_video) {
                $this->deleteIfExists($work->art_video);
            }
            // Delete book PDF if exists
            if ($work->book_pdf) {
                $this->deleteIfExists($work->book_pdf);
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
        $work = Work::with(['category', 'gallery', 'variants.attributeValues.attribute'])->findOrFail($id);

        $variants = $work->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'stock' => $variant->stock,
                'combination_text' => $variant->combinationText(),
                'attribute_values' => $variant->attributeValues->map(fn($av) => [
                    'id' => $av->id,
                    'value' => $av->value,
                    'attribute_name' => $av->attribute?->name,
                ])->values()->all(),
            ];
        });

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
            'art_video'     => $work->art_video ? asset($work->art_video) : null,
            'created_at'    => $work->created_at?->format('Y-m-d H:i'),
            'updated_at'    => $work->updated_at?->format('Y-m-d H:i'),
            'variants'      => $variants,
            'work_type'    => $work->work_type,
            'book_pdf_url'  => $work->book_pdf ? asset($work->book_pdf) : null,
        ]);
    }


    public function workShow(Work $work)
    {
        $work->load([
            'category',
            'gallery',
            'variants.attributeValues.attribute'
        ]);


        $variants = $work->variants->map(function ($v) {
            return [
                'id' => $v->id,
                'sku' => $v->sku,
                'price' => $v->price,
                'stock' => $v->stock,
                'value_ids' => $v->attributeValues->pluck('id')->values()->all(),
            ];
        })->values();


        $attributes = [];
        foreach ($work->variants as $v) {
            foreach ($v->attributeValues as $av) {
                $attrId = $av->attribute_id;
                if (!isset($attributes[$attrId])) {
                    $attributes[$attrId] = [
                        'id' => $attrId,
                        'name' => $av->attribute->name,
                        'values' => [],
                    ];
                }
                $attributes[$attrId]['values'][$av->id] = [
                    'id' => $av->id,
                    'value' => $av->value,
                    'slug' => $av->slug,
                ];
            }
        }

        $attributes = array_map(function ($a) {
            $a['values'] = array_values($a['values']);
            return $a;
        }, $attributes);

        $attributes = array_values($attributes);

        return view('frontend.art-info.art_info', [
            'work'        => $work,
            'category'    => $work->category,
            'variants'    => $variants,
            'attributes'  => $attributes,
        ]);
    }
}
