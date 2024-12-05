@extends('admin.layouts.master')
@section('content')
    @include('admin.messages.message')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">Quản lý Role</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-pencil-alt"></i>
                Thêm role
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">#</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tên</th>
                        <td>Permission</td>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration + $roles->firstItem() - 1 }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span>{{ $permission->display_name }}, </span>
                                @endforeach
                            </td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="btn btn-warning btn-circle mr-2">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn btn-danger btn-circle">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Chưa có role nào</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <div class="paginate d-flex justify-content-end">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
