@extends('layouts.dashboard')

@section('title')
    Manage Displays
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Manage Displays</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;">
                                Id
                            </th>
                            <th class="text-center" style="width: 100px;">
                                Xibo Id
                            </th>
                            <th>Displays Name</th>
                            <th style="width: 35%;">Layout</th>
                            <th style="width: 10%;">IsAuthorized</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allDisplays as $display)
                            <tr>
                                <td class="text-center">
                                    {{ $display->id }}
                                </td>
                                <td class="text-center">
                                    {{ $display->xiboId }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $display->displayName }}
                                </td>
                                <td> {{ $display->displayLayout }}</td>
                                <td> <span class="badge bg-primary">{{ $display->isAuthorized }}</span></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip"
                                            title="Edit" href="">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    {{ $allDisplays->links() }}
@endsection
