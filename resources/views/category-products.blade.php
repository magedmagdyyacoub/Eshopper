@include('home.header')
    <!-- Topbar Start -->
    @include('home.topbar')
    <div class="container pt-5">
        <h3>{{ $category->name }}</h3>
        <p>{{ $category->products->count() }} Products</p>

        <div class="row">
            @forelse($category->products as $product)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img class="card-img-top" src="/images/{{ $product->image }}" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">${{ number_format($product->price, 2) }}</p>
                            <a href="{{ route('product.detail', $product->id) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No products found in this category.</p>
            @endforelse
        </div>
    </div>

    @include('home.footer')