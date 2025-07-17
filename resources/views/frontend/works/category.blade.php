@extends('layouts.guest')

@section('title', $category->name)

@section('content')
<div class="container py-5">
    <h1 class="mb-4">{{ $category->name }}</h1>
    @if($items->isEmpty())
        <p class="text-muted">No items in this category yet.</p>
    @else
        <div class="row g-4">
            @foreach ($items as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100">
                        {{-- Adjust: thumbnail, title, link, etc. --}}
                        @if(!empty($item->thumbnail_url))
                            <img src="{{ $item->thumbnail_url }}" class="card-img-top" alt="{{ $item->title }}">
                        @endif
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1">{{ $item->title ?? 'Untitled' }}</h6>
                        </div>
                        <div class="card-footer p-2 text-end">
                            <a href="{{ route('frontend.work.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
