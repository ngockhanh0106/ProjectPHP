@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush
@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h1 class="h3 mb-2 text-gray-800">Thêm nhân viên</h1>
        </div>
        <div class="col-sm-6 text-right">
            <a href="{{ route('admin.staffs.index') }}" class="btn btn-sm btn-primary">
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
            <form method="POST" action="{{ route('admin.staffs.update', $staff->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tên nhân viên</label>
                            <input type="text" class="form-control" name="name" autocomplete="off" value="{{ $staff->name }}">
                            @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" autocomplete="off" value="{{ $staff->email }}">
                            @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role_ids[]" id="permission" class="form-control" data-live-search="true"
                                    multiple>
                                @php
                                    $roleIds = $staff->roles->pluck('id')->toArray();
                                @endphp
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @if(in_array((int)$role->id, $roleIds)) selected @endif>
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_ids')
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

