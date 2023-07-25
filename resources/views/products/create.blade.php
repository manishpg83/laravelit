@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="mb-4">Add a New Product</h1>

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="sku">SKU:</label>
                        <input type="text" class="form-control" name="sku" required>
                    </div>

                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="retail_price">Retail Price:</label>
                        <input type="number" class="form-control" name="retail_price" required>
                    </div>

                    <div class="form-group">
                        <label for="our_price">Our Price:</label>
                        <input type="number" class="form-control" name="our_price" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image:</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
@endsection
