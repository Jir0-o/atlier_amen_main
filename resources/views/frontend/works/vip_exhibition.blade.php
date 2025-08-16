@extends('layouts.guest')

@section('title', 'Exhibition')

{{-- @php
    $catName = trim($category->name ?? '');
    $words   = preg_split('/\s+/', $catName, -1, PREG_SPLIT_NO_EMPTY);

    if (count($words) <= 1) {
        $word = $words[0] ?? '';
        $len  = mb_strlen($word);
        $cut  = $len > 3 ? $len - 3 : 0;  
        $titleFirst = $cut ? mb_substr($word, 0, $cut) : '';
        $titleLast  = mb_substr($word, $cut);  
    } else {
        $lastWordIndex = count($words) - 1;
        $titleFirst = implode(' ', array_slice($words, 0, $lastWordIndex));
        $titleLast  = $words[$lastWordIndex];
    }

    $catNameLower = mb_strtolower($catName);
@endphp --}}

@section('content')
<main>
    <div class="content"> 

        {{-- Page Title --}}
        <section class="section-gap px-4">
            <div class="playfair page-title onload">
                <div class="d-flex gap-0 justify-content-center text-nowrap">
                    <h1>
                        <span class="white px-2">Exhibition</span>
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
                                <h2 class="m-0 text-uppercase jacques">Vip Exhibition</h2>
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

                    {{-- If no VIP categories at all --}}
                    @if($categories->isEmpty())
                        <p class="text-muted text-center">No VIP categories are available right now.</p>

                    {{-- If user doesn't have access --}}
                    @elseif(empty($hasVipAccess) || !$hasVipAccess)
                        <div class="text-center my-5">
                            <h4 class="mb-3">Purchase a product to get VIP Exhibition access</h4>
                            <p class="text-light mb-4">Once you complete a purchase with your account, this page will unlock automatically.</p>

                            @guest
                                <a href="{{ route('login') }}" class="btn btn-primary me-2">Log in</a>
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Create Account</a>
                            @else
                                <a href="{{ route('shop') }}" class="btn btn-primary me-2">Go to Shop</a>
                                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary">View My Orders</a>
                            @endguest
                        </div>

                    {{-- Has access: show works --}}
                    @else
                        @if($vipWorks->isEmpty())
                            <p class="text-muted text-center">No works in this category yet.</p>
                        @else
                            <div class="row">
                                @foreach ($vipWorks as $index => $work)
                                    @php
                                        $imgSrc = $work->work_image_low_url ?? $work->work_image_url ?? '';
                                        $alt    = $work->name ?? 'Work image';
                                        $aos    = $index % 2 == 0 ? 'zoom-out-right' : 'zoom-out-left';
                                    @endphp
                                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                                        <a href="{{ route('frontend.works.show', $work->id) }}" title="{{ $work->name }}">
                                            <div class="portrait-box">
                                                <div class="recent-img-box"
                                                    data-aos="{{ $aos }}"
                                                    data-aos-duration="1500">
                                                    <img src="{{ $imgSrc }}" alt="{{ $alt }}" loading="lazy">
                                                    @if(!empty($work->image_left))
                                                        <img class="recent-img-hover img-left"
                                                            src="{{ asset($work->image_left) }}"
                                                            alt="{{ $alt }} Left Hover"
                                                            loading="lazy">
                                                    @endif
                                                    @if(!empty($work->image_right))
                                                        <img class="recent-img-hover img-right"
                                                            src="{{ asset($work->image_right) }}"
                                                            alt="{{ $alt }} Right Hover"
                                                            loading="lazy">
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            <div class="d-flex justify-content-center mt-4">
                                {{ $vipWorks->links() }}
                            </div>
                        @endif
                    @endif
                </div>
        </section>

    </div>
</main>
@endsection
