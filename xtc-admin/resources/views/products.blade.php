@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Products</h6>
          <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#addProductModal">Add a new product</button>
          <div class="table-responsive">
            <table id="productTable" class="table">
              <thead>
                <tr>
                  <th>Product ID</th>
                  <th>Product nam</th>
                  <th>File name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                <tr id="product-row-{{$product->pid}}">
                    <td>{{$product->pid}}</td>
                    <td>{{$product->product_name}}</td>
                    <td>{{$product->file_name}}</td>
                    <td><button onclick="deleteProduct({{$product->pid}})" class="btn btn-danger">Delete</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductModalLabel">Add a new product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="product-name" class="form-label">Product name</label>
                <input type="text" class="form-control" id="product-name" autocomplete="off" placeholder="Product name">
            </div>

            <div class="mb-3">
                <label for="file-name" class="form-label">File name</label>
                <input type="text" class="form-control" id="file-name" autocomplete="off" placeholder="File name">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="button-add-product" type="button" class="btn btn-success">Add</button>
        </div>
      </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/js/products.js') }}"></script>
@endpush
