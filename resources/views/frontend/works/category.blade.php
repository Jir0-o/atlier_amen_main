@extends('layouts.guest')

@section('title', $category->name)

@push('scripts')
    
<style>
    .portrait-link { position: relative; display:block; }
    .portrait-link .click-surface { position:absolute; inset:0; }
    .portrait-link iframe { position:relative; z-index:2; pointer-events:auto; }
</style>

@endpush

@php
    $catName = trim($category->name ?? '');
    $words = preg_split('/\s+/', $catName, -1, PREG_SPLIT_NO_EMPTY);

    if (count($words) <= 1) {
        $word = $words[0] ?? '';
        $len = mb_strlen($word);
        $cut = $len > 3 ? $len - 3 : 0;
        $titleFirst = $cut ? mb_substr($word, 0, $cut) : '';
        $titleLast = mb_substr($word, $cut);
    } else {
        $lastWordIndex = count($words) - 1;
        $titleFirst = implode(' ', array_slice($words, 0, $lastWordIndex));
        $titleLast = $words[$lastWordIndex];
    }

    $catNameLower = mb_strtolower($catName);
@endphp 

@section('content')
    <main>
        <div class="content">

            {{-- Page Title --}}
            <section class="section-gap px-4">
                <div class="playfair page-title onload">
                    <div class="d-flex gap-0 justify-content-center text-nowrap">
                        <h1>
                            {{ $titleFirst }}
                            @if ($titleLast !== '')
                                <span class="white px-2">{{ $titleLast }}</span>
                            @endif
                        </h1>
                    </div>
                </div>
            </section>
            {{-- Center strip title --}}
            <section class="section-gap px-4 pt-0">
                <div class="section-title-box">
                    <div class="row">
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-l d-none d-sm-flex"></div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-c">
                                <center>
                                    <h2 class="m-0 text-uppercase jacques">{{ $catNameLower }}</h2>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-r d-none d-sm-flex"></div>
                        </div>
                    </div>
                </div>

                {{-- Portrait Grid --}}
                <div class="all-portrait pt-4 pt-md-5">
                    @if ($items->isEmpty())
                        <p class="text-center">No works in this category yet.</p>
                    @else
                        <div class="row">
                            @foreach ($items as $index => $work)
                                @php
                                    $imgSrc = $work->work_image_low_url ?? ($work->work_image_url ?? '');
                                    $alt = $work->name ?? 'Work image';
                                    $aos = $index % 2 == 0 ? 'zoom-out-right' : 'zoom-out-left';
                                @endphp
                                <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                                    <a href="{{ route('frontend.works.show', $work->id) }}" title="{{ $work->name }}">
                                        <div class="portrait-box">
                                            <div class="recent-img-box" data-aos="{{ $aos }}"
                                                data-aos-duration="1500">
                                                <img src="{{ $imgSrc }}" alt="{{ $alt }}" loading="lazy">
                                                @if (!empty($work->image_left))
                                                    <img class="recent-img-hover img-left"
                                                        src="{{ asset($work->image_left) }}"
                                                        alt="{{ $alt }} Left Hover" loading="lazy">
                                                @endif
                                                @if (!empty($work->image_right))
                                                    <img class="recent-img-hover img-right"
                                                        src="{{ asset($work->image_right) }}"
                                                        alt="{{ $alt }} Right Hover" loading="lazy">
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            @if($itemsBook->isNotEmpty())
            <section class="section-gap px-4 pt-0">
                <div class="section-title-box">
                    <div class="row">
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-l d-none d-sm-flex">
                                <!-- <span>.</span> -->
                            </div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-c">
                                <center>
                                    <h2 class="m-0 text-uppercase jacques">books</h2>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-r d-none d-sm-flex">
                                <!-- <span>.</span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="all-portrait pt-4 pt-md-5">
                    <div class="row">
                        @foreach ($itemsBook as $book) 
                            <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                                <div class="portrait-box position-relative">
                                    {{-- Interactive PDF preview (with controls) --}}
                                    <iframe
                                        data-aos="flip-left"
                                        data-aos-duration="2000"
                                        src="{{ asset($book->book_pdf) }}#toolbar=1&navpanes=1&scrollbar=1"
                                        type="application/pdf"
                                        frameborder="0"
                                        style="width:100%; height:300px; border-radius:8px;"></iframe>

                                    {{-- Floating actions: Details + Download --}}
                                    <div class="position-absolute d-flex gap-2"
                                        style="top:8px; right:8px; z-index:5;">
                                        <a href="{{ route('frontend.works.show', $book->id) }}" target="_blank"
                                        class="btn btn-sm btn-dark shadow">Buy Now</a>
                                        <a href="{{ asset($book->book_pdf) }}" target="_blank"
                                        class="btn btn-sm btn-light shadow">Download</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        </div>
    </main>
@endsection
