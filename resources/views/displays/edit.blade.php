@extends('layouts.dashboard')

@section('title')
    Edit Display | {{ $editedDisplay->displayName }}
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Display</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('edit-display-post') }}" method="POST" enctype="multipart/form-data">
                <!-- Basic Elements -->
                @csrf
                <h2 class="content-heading pt-0">Edit Display</h2>
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Display Name:
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <input type="hidden" name="edited_display_id" value="{{ $editedDisplay->id }}">
                            <input type="hidden" name="xibo_display_id" value="{{ $editedDisplay->xiboId }}">
                            <input type="text" class="form-control" id="store-text-input" name="display_name"
                                value="{{ $editedDisplay->displayName }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Is Logged in
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <input type="text" class="form-control" id="store-text-input" name="display_name"
                                value="{{ $editedDisplay->isLoggedIn ? 'Yes' : 'No' }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Select Layout for the Display
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <select class="form-select" id="example-select" name="layout_id">
                                @foreach (\App\Models\Layout::all() as $layout)
                                    <option value="{{ $layout->xiboId }}"
                                        {{ $layout->name == $editedDisplay->displayLayout ? 'selected' : '' }}>
                                        {{ $layout->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- END Basic Elements -->

                <div class="row push">
                    <div class="col-lg-4">
                        <p class="text-muted">
                            Is Authroized
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="mb-4">
                            <select class="form-select" id="example-select" name="authorization">
                                <option value="1" {{ $editedDisplay->isAuthorized == '1' ? 'selected' : '' }}>Yes
                                </option>
                                <option value="0" {{ $editedDisplay->isAuthorized == '0' ? 'selected' : '' }}>No
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

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
