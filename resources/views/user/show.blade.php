@extends('layouts.app')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-sm text-start">
                    <h5 class="card-title mb-0">{{ $page->title }}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            @empty($users)
            <div class="alert alert-danger">
                <h5><i class="bi bi-exclamation-triangle-fill"></i> Data tidak ditemukan</h5>
            </div>
            @else
            <div class="row mb-4">
                <div class="col-2">
                    <img src="{{ $avatar }}" alt="" class="avatar" style="width: 130px; height: 130px;">
                </div>
                <div class="col-10">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle" id="table_role"
                            width="100%">
                            <tr>
                                <th>ID User</th>
                                <td>{{ $users->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $users->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $users->role->role_nama }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            @endempty

            <a href="{{ route('user.index') }}" class="btn btn-sm btn-primary mt-2">Kembali</a>
        </div>
    </div>
</section>
@endsection
