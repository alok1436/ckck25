@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>Admin account management</h4>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="justify-content-end d-flex">
                                <div class="button-items">
                                    <div class="dropdown d-inline-block pt-1 mt-1" style="display: flex !important;">
                                         <a href="{{ route('admin.user.store') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-plus"></i> Add Admin</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable-buttons" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>ID</th>
                                    <th>Password</th>
                                    <th>Level</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{ date('Y.m.d', strtotime($user->created_at)) }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>********</td>
                                    <td>
                                        {{ $user->level==1 ? 'Level 1' : ($user->level==2 ? 'Level 2' : 'Level 3') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.edit',$user->id) }}" data-data="{{ $user }}" class="btn btn-primary btn-sm editAdmin"><i class="mdi mdi-pencil"></i> Edit</a>
                                        <a href="{{ route('admin.user.delete',$user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm"><i class="mdi mdi-delete"></i> Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection