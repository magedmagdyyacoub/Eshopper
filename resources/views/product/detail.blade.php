@include('home.header')
    <!-- Topbar Start -->
    @include('home.topbar')
    <div class="container">
      <div class="row">
          <div class="col-md-6">
              <img class="img-fluid" src="/images/{{ $product->image }}" alt="{{ $product->name }}">
          </div>
          <div class="col-md-6">
              <h1>{{ $product->name }}</h1>
              <h4>${{ number_format($product->price, 2) }}</h4>
              <p>{{ $product->description }}</p>
              <a href="" class="btn btn-primary">Add to Cart</a>
          </div>
      </div>
  </div>
    @include('home.footer')