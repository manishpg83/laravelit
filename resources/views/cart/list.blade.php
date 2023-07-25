@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cart List</h1>

    <div class="row">
        <div class="col-md-8">
            @if(count($cartDetails) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartDetails as $cartDetail)
                    <tr>
                        <td>
                            @if($cartDetail->product)
                                {{ $cartDetail->product->name }}
                            @else
                                Product not found
                            @endif
                        </td>
                        <td>{{ $cartDetail->quantity }}</td>
                        <td>{{ $cartDetail->unit_price }}</td>
                        <td>{{ $cartDetail->total_price }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $cartDetail->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>No items in the cart.</p>
            @endif
        </div>
    </div>
</div>
@endsection
