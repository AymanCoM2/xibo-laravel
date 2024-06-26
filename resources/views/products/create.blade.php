@extends('layouts.dashboard')

@section('title')
    Create new Product
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
        </div>
        <div class="block-content">
            <form action="{{ route('create-product-post') }}" method="POST" enctype="multipart/form-data">
                <!-- Basic Elements -->
                @csrf
                <h4 class="content-heading pt-0">Create new Product</h4>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Write the Name of the Store
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="store-text-input">Product Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="Product-text-input" name="product_name"
                                placeholder="Enter Product name">
                        </div>
                    </div>
                </div>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Select Store for the Product
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="example-select">Select Store <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="example-select" name="product_store">
                                <option selected>SELECT A STORE</option>
                                @foreach ($allStores as $store)
                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Product SKU
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="Product-sku-input">Product SKU <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="Product-sku-input" name="product_sku"
                                placeholder="Enter Product SKU">
                        </div>
                    </div>
                </div>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Product Quantity
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="store-text-input">Product quantity <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="Product-text-input" name="product_quantity"
                                placeholder="Enter Product Quantity">
                        </div>
                    </div>
                </div>

                <!-- END Basic Elements -->


                <div class="row push">
                    <div class="col-lg-4">
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <button type="submit" class="btn btn-sm btn-alt-primary">
                                <i class="fa fa-check opacity-50 me-1"></i> Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
