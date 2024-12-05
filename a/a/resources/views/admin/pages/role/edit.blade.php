@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">Chỉnh sửa role</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form điền thông tin</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tên role</label>
                            <input type="text" class="form-control" name="display_name" value="{{ $role->display_name }}">
                            @error('display_name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Permission</label>
                            <select name="permission_ids[]" id="permission" class="form-control" data-live-search="true"
                                    multiple>
                                @php
                                    $permissionIds = $role->permissions->pluck('id')->toArray();
                                @endphp
                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->id }}" @if(in_array((int)$permission->id, $permissionIds)) selected @endif>
                                        {{ $permission->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('permission_ids')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Thêm</button>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(function () {
            $("#permission").selectpicker();
        })
    </script>
@endpush

