@include('home.header')
<div class="container">
  <h3>Search Results for: "{{ request('query') }}"</h3>

  <h4>Products</h4>
  @if($products->isEmpty())
      <p>No products found.</p>
  @else
      <ul>
          @foreach($products as $product)
              <li>
                  <a href="{{ url('/products/' . $product->id) }}">{{ $product->name }}</a>
              </li>
          @endforeach
      </ul>
  @endif

  <h4>Categories</h4>
  @if($categories->isEmpty())
      <p>No categories found.</p>
  @else
      <ul>
          @foreach($categories as $category)
              <li>
                  <a href="{{ route('products.search') }}?query={{ $category->name }}">{{ $category->name }}</a>
              </li>
          @endforeach
      </ul>
  @endif
</div>
@include('home.footer')