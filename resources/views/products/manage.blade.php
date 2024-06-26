@extends('layouts.dashboard')

@section('title')
    Manage Products
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Manage Products</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 200px;">
                                SKU
                            </th>
                            <th>Product Name</th>
                            <th style="width: 20%;">Store Name</th>
                            <th style="width: 20%;">Quantity</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allProducts as $product)
                            <tr>
                                <td class="text-center">
                                    {{ $product->sku }}
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{ $product->product_name }}</a>
                                </td>
                                <td>{{ $product->store->store_name }}</td>
                                <td> <span class="badge bg-danger">{{ $product->quantity }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                                            title="Edit">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>

                                        <form action="{{ route('delete-product') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm btn-alt-secondary"
                                                data-bs-toggle="tooltip" title="Delete">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $allProducts->links() }}
@endsection
