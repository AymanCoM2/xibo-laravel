@extends('layouts.dashboard')

@section('title')
    Edit Store  | {{ $editedStore->store_name }}
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Store</h3>
        </div>
        <div class="block-content">
            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Basic Elements -->
                @csrf
                <h2 class="content-heading pt-0">Edit Store</h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Write the Name of the Store
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="store-text-input">Store Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="store-text-input" name="store_name"
                                placeholder="Enter Store name" value="{{ $editedStore->store_name  }}">
                        </div>
                    </div>
                </div>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Select Dispaly for the Store
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <label class="form-label" for="example-select">Select Display</label>
                            <select class="form-select" id="example-select" name="screen_id">
                                <option selected></option>
                                <option value="1">Option #1</option>
                                <option value="2">Option #2</option>
                                <option value="3">Option #3</option>
                            </select>
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
