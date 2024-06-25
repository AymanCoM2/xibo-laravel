@extends('layouts.dashboard')

@section('title')
    Manage Stores
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Manage Stores</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">
                                Id
                            </th>
                            <th>Store Name</th>
                            <th style="width: 35%;">Screen</th>
                            <th style="width: 10%;">Products</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allStores as $store)
                            <tr>
                                <td class="text-center">
                                    {{ $store->id }}
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html"> {{ $store->store_name }}</a>
                                </td>
                                <td> {{ $store->screen_id }} | {{ $store->assigned_screen }}</td>
                                <td> <span class="badge bg-primary">{{ $store->products->count() }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group">


                                        <a type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                                            title="Edit" href="{{ route('edit-store',$store->id) }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('delete-store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="store_id" value="{{ $store->id }}">
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
    {{ $allStores->links() }}
@endsection
