@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Product Details Column -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $product->name }}</h2>
                    </div>
                    <div class="card-body">
                        <p><strong>SKU:</strong> {{ $product->sku }}</p>
                        <p><strong>Description:</strong> {{ $product->description }}</p>
                        <p><strong>Retail Price:</strong> ${{ $product->retail_price }}</p>
                        <p><strong>Our Price:</strong> ${{ $product->our_price }}</p>
                    </div>
                    <div class="card-footer">
                        <!-- Cart Button -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Product Image Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <img src="{{ Storage::url($product->image) }}" class="img-thumbnail" alt="Product Image">
                    </div>
                </div>
            </div>

            <!-- Recently Viewed Products Column -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2>Recently Viewed</h2>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach($recentlyViewedProducts as $item)
                                <li>
                                    <a href="{{ route('product.view', $item->product->id) }}">
                                        {{ $item->product->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
