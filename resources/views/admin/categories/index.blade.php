@extends('admin.products.header')
@include('admin.navbar')

<div class="container mt-4">
  <a class="btn btn-secondary btn-sm mb-3" href="{{ route('admin.home') }}">
      <i class="fa fa-home"></i> Home
  </a>
</div>

<div class="card mt-5">
  <h2 class="card-header">categories</h2>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('admin.categories.create') }}"> <i class="fa fa-plus"></i> Create New category</a>
        </div>
  
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th width="250px">Action</th>
                </tr>
            </thead>
  
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>
                      @if($category->image_url)
                          <img src="/images/{{ $category->image }}" width="100px">
                      @else
                          <p>No image available</p>
                      @endif
                  </td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <form action="{{ route('admin.categories.destroy',$category->id) }}" method="POST">
             
                            <a class="btn btn-info btn-sm" href="{{ route('admin.categories.show',$category->id) }}"><i class="fa-solid fa-list"></i> Show</a>
              
                            <a class="btn btn-primary btn-sm" href="{{ route('admin.categories.edit',$category->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
             
                            @csrf
                            @method('DELETE')
                
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">There are no data.</td>
                </tr>
            @endforelse
            </tbody>
  
        </table>
        
        {!! $categories->withQueryString()->links('pagination::bootstrap-5') !!}
  
  </div>
</div>      
@extends('admin.categories.footer')
