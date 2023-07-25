@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Product Listing</h1>

    <!-- Sort by Dropdown -->
    <div class="mb-3">
        <label for="sortby">Sort By:</label>
        <select id="sortby" class="form-select" onchange="sortProducts()">
            <option value="name_asc">Name A-Z</option>
            <option value="name_desc">Name Z-A</option>
            <option value="price_asc">Price Low to High</option>
            <option value="price_desc">Price High to Low</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Retail Price</th>
                    <th>Our Price</th>
                    <th>View Product</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->sku }}</td>
                        <td>
                            <img src="{{ Storage::url($product->image) }}" class="img-thumbnail" alt="Product Image" style="width: 100px; height: 100px;">
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>${{ $product->retail_price }}</td>
                        <td>${{ $product->our_price }}</td>
                        <td>
                            <a href="{{ route('product.view', ['id' => $product->id]) }}" class="btn btn-primary">View Product</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $products->links('custom_pagination') }}
    </div>
</div>

<script>
    function sortProducts() {
        var sortBy = document.getElementById('sortby').value;
        window.location.href = "{{ route('product.list') }}?sort_by=" + sortBy;
    }
</script>

@endsection
