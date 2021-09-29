@extends('admin.layouts.app')
@section('title', 'Admin Store')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>Admin Store</h4>
                            </div>
                        </div>
                        <!--div class="col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="" class="btn btn-primary btn-sm" style="margin-bottom: 0px!important;">
                                <i class="mdi mdi-content-save-move"></i> Memo</a>
                            </div>
                        </div-->
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    {{ Form::open(array('route' => 'admin.user.store', 'files' => true,'id'=>'form')) }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Admin Name</label>
                                    <input type="text" class="form-control" id="name" name="name" >
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="email">ID</label>
                                    <input type="text" class="form-control" id="email" name="email" >
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" >
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="level">Level</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="level" name="level" >
                                            <option value="">Select Level</option>
                                            <option value="1">Level 1</option>
                                            <option value="2">Level 2</option>
                                            <option value="3">Level 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2" style="margin-bottom: 0px!important;">
                                        <i class="mdi mdi-content-save-move"></i> Create
                                        <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                    </button>
                                    <a href="{{ url('admin/users') }}" class="btn btn-danger btn-sm m-2" style="margin-bottom: 0px!important;">
                                        <i class="mdi mdi-backspace-outline"></i> back</a>
                                </div>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection