@extends('layouts.guest')

@section('title', 'Shop')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- shop page start --> 
        <section class="section-gap px-4 pt-0">
            <div class="section-title-box">
                <div class="row">
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-l d-none d-sm-flex"></div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-c">
                            <center>
                                <h2 class="m-0 text-uppercase jacques">Buy the best</h2>
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-r d-none d-sm-flex"></div>
                    </div>
                </div>
            </div>

            <div class="all-portrait pt-4 pt-md-5">
                <div class="row">
                    @forelse ($Works as $index => $work)
                        <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                            <a href="{{ route('frontend.works.show', $work->id) }}" title="{{ $work->name }}">
                                <div class="recent-img-box"
                                    data-aos="{{ $index % 2 == 0 ? 'zoom-out-right' : 'zoom-out-left' }}"
                                    data-aos-duration="1500">
                                    <img class="img-thumb" src="{{ asset($work->work_image_low) }}" alt="{{ $work->name }}" loading="lazy">
                                    <img class="recent-img-hover img-left" src="{{ asset($work->image_left_low) }}" alt="{{ $work->name }}" loading="lazy">
                                    <img class="recent-img-hover img-right" src="{{ asset($work->image_right_low) }}" alt="{{ $work->name }}" loading="lazy">
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted text-center">No works available in the shop yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="pagination justify-content-center mt-4">
                {{ $Works->links() }}
            </div>
        </section>
        <!-- shop page end -->
    </div>
</main>

<!-- main content end -->
@endsection