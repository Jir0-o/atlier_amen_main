@if($categories->count())
    <h4>Category</h4>
    <ul class="list-unstyled search-cat-list">
        @foreach($categories as $cat)
            <li><a class="dropdown-item" href="{{ route('works.category', $cat) }}">{{ $cat->name }}</a></li>
        @endforeach
    </ul>
@endif

@if($products->count())
    <h4>Product</h4>
    <div class="row" id="search-result-product">
        @foreach($products as $product)
            <a class="col-sm-6 col-md-4 col-xl-2 p-0" href="{{ route('frontend.works.show', $product->id) }}" title="{{ $product->name }}">
                <div class="p-3">
                    <img src="{{ asset($product->work_image_low) }}" alt="{{ $product->name }}" class="search-img" loading="lazy">
                    <h6 class="pt-2">{{ $product->name }}</h6>
                </div>
            </a>
        @endforeach
    </div>
@endif
