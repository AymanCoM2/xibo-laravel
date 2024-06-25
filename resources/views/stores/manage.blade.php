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
                            <th style="width: 45%;">Screen</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <img class="img-avatar img-avatar48" src="assets/media/avatars/avatar5.jpg" alt="">
                            </td>
                            <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">Laura Carr</a>
                            </td>
                            <td>client1<em class="text-muted">@example.com</em></td>

                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                                        title="Edit">
                                        <i class="fa fa-pencil-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                                        title="Delete">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
