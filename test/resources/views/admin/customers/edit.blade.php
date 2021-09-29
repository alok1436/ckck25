@extends('admin.layouts.app')
@section('title', 'Customer Edit')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<style>
    .form-control {
        padding: 0.50rem .75rem;
    }
    .input-group {
        flex-wrap: nowrap;
    }
    .input-group-append {
        margin-left: -1px;
        display: flex;
    }
    
    .input-group > .input-group-append > .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .badge {
        padding: .5em .75em;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>Customer Info</h4>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/customer/delete/'.$customer->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm" style="margin-bottom: 0px!important;"><i class="mdi mdi-delete"></i> Delete</a>&nbsp;
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" style="margin-bottom: 0px!important;"><i class="mdi mdi-content-save-move"></i> Memo</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/edit_customer/'.$customer->id) }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$customer->name}}">
                                    <!--<span class="text-danger">{{ $errors->first('name') }}</span>-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="group">Groups</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="group" name="group">
                                            <option value="">Group..</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}" @if($group->id == $customer->customerGroupID) selected @endif>{{$group->groupName}}</option>
                                            @endforeach
                                        </select>
                                        <a href="javascript:void(0);" id="groupmanage" class="btn btn-primary btn-sm pt-2 input-group-text">추가</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="age">Age</label>
                                            <input type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="age" name="age" value="{{$customer->age}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="gender">Gender</label>
                                            <select class="form-control select2" id="gender" name="gender">
                                                <option value="">성별..</option>
                                                <option value="M" @if($customer->gender == "M") selected @endif>남자</option>
                                                <option value="F" @if($customer->gender == "F") selected @endif>여자</option>
                                                <option value="O" @if($customer->gender == "O") selected @endif>기타</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label" for="cities">Cities</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="cities" name="cities">
                                            <option value="">Cities..</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" @if($city->id == $customer->city_id) selected @endif>{{$city->cityName}}</option>
                                            @endforeach
                                        </select>

                                        <a href="javascript:void(0);" id="citiesmanage" class="btn btn-primary btn-sm pt-2 input-group-text" >추가</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{$customer->address}}">
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="phonenumber1">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phonenumber" name="phonenumber1" value="{{$customer->phonenumber1}}" required>
                                </div>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="stock_firm">Stock Firm</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="stock_firm" name="stock_firm">
                                            <option value="">StockBroker..</option>
                                            @foreach($stockbrokers as $stockbroker)
                                                <option value="{{$stockbroker->id}}" @if($stockbroker->id == $customer->stockBroker) selected @endif>{{$stockbroker->brokerName}}</option>
                                            @endforeach
                                        </select>

                                        <a href="javascript:void(0);" id="stockmanage" class="btn btn-primary btn-sm pt-2 input-group-text" >추가</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="account_number">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number" value="{{$customer->accountNumber}}">
                                    <!--<input type="text" class="form-control" id="account_number" name="account_number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" value="{{$customer->accountNumber}}">-->
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="phonenumber2">Phone Number 2</label>
                                    <input type="text" class="form-control" id="phonenumber2" value="{{$customer->phonenumber2}}" name="phonenumber2">
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="edited_by">Edited By</label>
                                    <select class="form-control select2" disabled id="edited_by" name="edited_by">
                                        <option value="">Edited By..</option>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}" @if($admin->id == $customer->createdBy) selected @endif>{{$admin->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="edited_date">Edited Date</label>
                                    <input type="text" class="form-control" disabled id="edited_date" name="edited_date" value="{{ date('Y.m.d', strtotime($customer->date)) }}">
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$customer->email}}">
                                    <!--<span class="text-danger">{{ $errors->first('email') }}</span>-->
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <hr class="my-auto flex-grow-1 mt-2 mb-3" style="height:2px;">
                                    <div class="row p-1">
                                        <div class="col-md-6">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row mt-2">
                                                <div class="form-check col-sm-4">
                                                    <input class="form-check-input" type="radio" name="formRadios" id="newble">
                                                    <label class="form-check-label" for="newble">
                                                        Newble
                                                    </label>
                                                </div>
                                                <div class="form-check col-sm-4">
                                                    <input class="form-check-input" type="radio" name="formRadios" id="intermediate" checked>
                                                    <label class="form-check-label" for="intermediate">
                                                        Intermediate
                                                    </label>
                                                </div>
                                                <div class="form-check col-sm-4">
                                                    <input class="form-check-input" type="radio" name="formRadios" id="expert">
                                                    <label class="form-check-label" for="expert">
                                                        Expert
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="routsofknown">Routs of Known</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="routsofknown" name="routsofknown">
                                            <option value="">Routes of Known..</option>
                                            @foreach($routeknowns as $routeknown)
                                                <option value="{{$routeknown->id}}" @if($routeknown->id == $customer->routesOfKnownID) selected @endif>{{$routeknown->routeName}}</option>
                                            @endforeach
                                        </select>
                                        <a href="javascript:void(0);" id="routs_manage" class="btn btn-primary btn-sm pt-2 input-group-text">추가</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2" style="margin-bottom: 0px!important;"><i class="mdi mdi-content-save-move"></i> Update</button>
                                    <a href="{{ url('admin/customers') }}" class="btn btn-danger btn-sm m-2" style="margin-bottom: 0px!important;"><i class="mdi mdi-backspace-outline"></i> back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="stocktab" href="#stocktransaction" role="tab">
                                <span class="d-block d-sm-none">ST</span>
                                <span class="d-none d-sm-block">Stock Transaction
                                    <span class="badge rounded-circle bg-secondary float-end">  {{$stocksCount}}</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="filetab" href="#filetransfer" role="tab">
                                <span class="d-block d-sm-none">FT</span>
                                <span class="d-none d-sm-block">File Transfer
                                    <span class="badge rounded-circle bg-secondary float-end">  {{$filetransfersCount}}</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="postertab" href="#poster" role="tab">
                                <span class="d-block d-sm-none">PT</span>
                                <span class="d-none d-sm-block">Post
                                    <span class="badge rounded-circle bg-secondary float-end">  {{$postdeliveriesCount}}</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="visittab" href="#visitrecord" role="tab">
                                <span class="d-block d-sm-none">VR</span>
                                <span class="d-none d-sm-block">Visit Record
                                    <span class="badge rounded-circle bg-secondary float-end">  {{$visitrecordsCount}}</span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" id="inquerytab" href="#inquery" role="tab">
                                <span class="d-block d-sm-none">IQ</span>
                                <span class="d-none d-sm-block">Inquery
                                    <span class="badge rounded-circle bg-secondary float-end">  {{$inqueriesCount}}</span>
                                </span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane p-3" id="stocktransaction" role="tabpanel">
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="stock_list">
                                        <div class="table-responsive pt-1">
                                            <table id="stock_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                                            </label>
                                                        </th>
                                                        <th>Date</th>
                                                        <th>Company</th>
                                                        <th>Stock Price</th>
                                                        <th>Quantity</th>
                                                        <th>Invested</th>
                                                        <th>Admin</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($stocks as $stock)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" value="{{$stock->id}}" />
                                                        </td>
                                                        <td class="align-middle">{{$stock->date}}</td>
                                                        <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="stock_edit" data-id="{{$stock->id}}">{{$stock->companyName}}</a></td>
                                                        <td class="align-middle">{{number_format($stock->stockPrice)}}</td>
                                                        <td class="align-middle">{{number_format($stock->quantity)}}</td>
                                                        <td class="align-middle">{{number_format($stock->invested)}}</td>
                                                        <td class="align-middle">{{$stock->adminname}}</td>
                                                        <td class="align-middle">
                                                            @if($stock->status == "Active")
                                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_stock_status" data-status="{{$stock->status}}" data-id="{{$stock->id}}">이체완료</a>
                                                            @elseif ($stock->status == "Pending")
                                                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_stock_status" data-status="{{$stock->status}}" data-id="{{$stock->id}}">진행중</a>
                                                            @elseif ($stock->status == "Canceled")
                                                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_stock_status" data-status="{{$stock->status}}" data-id="{{$stock->id}}">취소</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="formstock">
                                        <form id="stockForm" class="form-horizontal mt-4 needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stockdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="stockdate" name="stockdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="company">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group" >
                                                            <select class="form-control select2 companytab" id="company" name="company" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="input-group-append">
                                                                <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stock_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="stock_status" name="stock_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">이체완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="stockPrice">주가 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="stockPrice" name="stockPrice" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="quantity">주식 수 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="quantity" name="quantity" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="invested">투자금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="invested" name="invested" required readonly>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_stockadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_stockback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" id="upformstock">
                                        <form id="upstockForm" class="form-horizontal mt-4 needs-validation" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ustockdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ustockdate" name="ustockdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ucompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="ucompany" name="ucompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ustock_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="ustock_status" name="ustock_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">이체완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ustockPrice">주가 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ustockPrice" name="ustockPrice" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uquantity">주식 수 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uquantity" name="uquantity" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uinvested">투자금액 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uinvested" name="uinvested" required readonly>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <input type="hidden" id="upstockid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_stockupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_stockback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_stockshow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="filetransfer" role="tabpanel">
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="filetransfer_list">
                                        <div class="table-responsive pt-1">
                                            <table id="file_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                                            </label>
                                                        </th>
                                                        <th>날짜</th>
                                                        <th>기업</th>
                                                        <th>파일 이름</th>
                                                        <th>관리자</th>
                                                        <th>전송방법</th>
                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($filetransfers as $filetransfer)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" value="{{$filetransfer->id}}" />
                                                        </td>
                                                        <td class="align-middle">{{$filetransfer->date}}</td>
                                                        <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="transfer_edit" data-id="{{$filetransfer->id}}">{{$filetransfer->companyName}}</a></td>
                                                        <td class="align-middle">{{$filetransfer->fileName}}</td>
                                                        <td class="align-middle">{{$filetransfer->adminname}}</td>
                                                        <td class="align-middle">
                                                            @if($filetransfer->method == "Email")
                                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">이메일</a>
                                                            @elseif ($filetransfer->method == "Post")
                                                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">우편</a>
                                                            @elseif ($filetransfer->method == "SMS")
                                                            <a href="javascript:void(0);" class="btn btn-info waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">SMS</a>
                                                            @elseif ($filetransfer->method == "Messenger")
                                                            <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_file_method" data-method="{{$filetransfer->method}}" data-id="{{$filetransfer->id}}">카카오톡</a>
                                                            @endif
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="formfiletransfer">
                                        <form class="form-horizontal mt-4 needs-validation" id="transferForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filedate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="filedate" name="filedate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filecompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="filecompany" name="filecompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="filemethod">전송방법 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="filemethod" name="filemethod" required>
                                                            <option value="">전송방법..</option>
                                                            <option value="Email">이메일</option>
                                                            <option value="Post">우편</option>
                                                            <option value="SMS">SMS</option>
                                                            <option value="Messenger">카카오톡</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="fileName">파일 이름 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="fileName" name="fileName" required>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_fileadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_fileback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" id="upformfiletransfer">
                                        <form class="form-horizontal mt-4 needs-validation" id="uptransferForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufiledate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ufiledate" name="ufiledate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufilecompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2 companytab" id="ufilecompany" name="ufilecompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufilemethod">전송방법 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="ufilemethod" name="ufilemethod" required>
                                                            <option value="">전송방법..</option>
                                                            <option value="Email">이메일</option>
                                                            <option value="Post">우편</option>
                                                            <option value="SMS">SMS</option>
                                                            <option value="Messenger">카카오톡</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ufileName">파일 이름 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="ufileName" name="ufileName" required>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <input type="hidden" id="fileid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_fileupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_fileback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_transfershow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                        </div>
                        <div class="tab-pane p-3" id="poster" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="poster_list">
                                        <div class="table-responsive pt-1">
                                            <table id="poster_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                                            </label>
                                                        </th>
                                                        <th>날짜</th>
                                                        <th>기업</th>
                                                        <th>주소</th>
                                                        <th>지역</th>
                                                        <th>관리자</th>
                                                        <th>상태</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($postdeliveries as $postdelivery)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" value="{{$postdelivery->id}}" />
                                                        </td>
                                                        <td class="align-middle">{{ $postdelivery->date }}</td>
                                                        <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="poster_edit" data-id="{{$postdelivery->id}}">{{$postdelivery->companyName}}</a></td>
                                                        <td class="align-middle">{{ $postdelivery->address }}</td>
                                                        <td class="align-middle">{{ $postdelivery->city->cityName }}</td>
                                                        <td class="align-middle">{{ $postdelivery->adminname }}</td>
                                                        <td class="align-middle">
                                                            @if($postdelivery->status == "Delivered")
                                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">발송완료</a>
                                                            @elseif ($postdelivery->status == "Pending")
                                                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">발송중</a>
                                                            @elseif ($postdelivery->status == "Returned")
                                                            <a href="javascript:void(0);" class="btn btn-secondary waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">반송됨</a>
                                                            @elseif ($postdelivery->status == "Canceled")
                                                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_post_status" data-status="{{$postdelivery->status}}" data-id="{{$postdelivery->id}}">취소</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="formposter">
                                        <form class="form-horizontal mt-4 needs-validation" id="posterForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="postdate" name="postdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="postcompany" name="postcompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="postcity">지역 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="postcity" name="postcity" required>
                                                            <option value="">지역..</option>
                                                            @foreach($cities as $city)
                                                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="post_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="post_status" name="post_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Delivered">발송완료</option>
                                                            <option value="Pending">발송중</option>
                                                            <option value="Returned">반송됨</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a class="btn btn-success btn-sm me-2 btn_posteradd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_posterback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" id="upformposter">
                                        <form class="form-horizontal mt-4 needs-validation" id="upposterForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="upostdate" name="upostdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostcompany">기업 <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <select class="form-control select2" id="upostcompany" name="upostcompany" required>
                                                                <option value="">기업 ..</option>
                                                                @foreach($companies as $company)
                                                                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                                                                @endforeach
                                                            </select>
                                                        
                                                            <a href="javascript:void(0);" class="btn btn-primary companymanage input-group-text">추가</a>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upostcity">지역 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="upostcity" name="upostcity" required>
                                                            <option value="">지역..</option>
                                                            @foreach($cities as $city)
                                                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="upost_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="upost_status" name="upost_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Delivered">발송완료</option>
                                                            <option value="Pending">발송중</option>
                                                            <option value="Returned">반송됨</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="postid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a class="btn btn-success btn-sm me-2 btn_posterupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_posterback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_postershow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-3" id="visitrecord" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="visit_list">
                                        <div class="table-responsive pt-1">
                                            <table id="visit_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                                            </label>
                                                        </th>
                                                        <th>날짜</th>
                                                        <th>Name</th>
                                                        <th>제목</th>
                                                        <th>시간</th>
                                                        <th>관리자</th>
                                                        <th>상태</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($visitrecords as $visitrecord)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" value="{{$visitrecord->id}}" />
                                                        </td>
                                                        <td class="align-middle">{{$visitrecord->date}}</td>
                                                        <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="visit_edit" data-id="{{$visitrecord->id}}">{{$visitrecord->name}}</a></td>
                                                        <td class="align-middle">{{$visitrecord->title}}</td>
                                                        <td class="align-middle">{{$visitrecord->time}}</td>
                                                        <td class="align-middle">{{$visitrecord->adminname}}</td>
                                                        <td class="align-middle">
                                                            @if($visitrecord->status == "Active")
                                                            <a href="javascript:void(0);" class="btn btn-success waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">완료</a>
                                                            @elseif ($visitrecord->status == "Pending")
                                                            <a href="javascript:void(0);" class="btn btn-primary waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">진행중</a>
                                                            @elseif ($visitrecord->status == "Canceled")
                                                            <a href="javascript:void(0);" class="btn btn-danger waves-effect waves-light btn_visit_status" data-status="{{$visitrecord->status}}" data-id="{{$visitrecord->id}}">취소</a>
                                                            @endif
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="formvisit">
                                        <form class="form-horizontal mt-4 needs-validation" id="visitForm" novalidate>
                        
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visitdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="visitdate" name="visitdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="title">제목 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="title" name="title" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="time">시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="time" name="time" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="visit_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="visit_status" name="visit_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_visitadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_visitback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" id="upformvisit">
                                        <form class="form-horizontal mt-4 needs-validation" id="upvisitForm" novalidate>
                        
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uvisitdate">날짜 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="uvisitdate" name="uvisitdate" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label" for="utitle">제목 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="utitle" name="utitle" required>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="utime">시간 <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control timepicker" id="utime" name="utime" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="uvisit_status">상태 <span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="uvisit_status" name="uvisit_status" required>
                                                            <option value="">상태..</option>
                                                            <option value="Active">완료</option>
                                                            <option value="Pending">진행중</option>
                                                            <option value="Canceled">취소</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        
                                            </div>
                                            <input type="hidden" id="visitid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_visitupdate"><i class="mdi mdi-content-save-move"></i>  저장하기</a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_visitback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_visitshow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>            
                        </div>
                        <div class="tab-pane p-3" id="inquery" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row" id="inquery_list">
                                        <div class="table-responsive pt-1">
                                            <table id="inquery_datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="align-middle">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                                            </label>
                                                        </th>
                                                        <th>날짜</th>
                                                        <th>Name</th>
                                                        <th>내용</th>
                                                        <th>키워드</th>
                                                        <th>관리자</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($inqueries as $inquery)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="form-check-input" value="{{$inquery->id}}" />
                                                        </td>
                                                        <td class="align-middle">{{$inquery->date}}</td>
                                                        <td class="align-middle bg-light text-primary fw-bold"><a href="javascript:void(0);" class="inquery_edit" data-id="{{$inquery->id}}">{{$inquery->name}}</a></td>
                                                        <td class="align-middle">{{$inquery->note}}</td>
                                                        <td class="align-middle">
                                                            <span class="tag badge bg-info p-1 me-1">{{$inquery->keyword}}</span>
                                                        </td>
                                                        <td class="align-middle">{{$inquery->adminname}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row" id="forminquery">
                                        <form class="form-horizontal mt-4 needs-validation" id="inqueryForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="note">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" rows="5" id="note" name="note" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="keyword">키워드 </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="keyword" name="keyword" data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_inqueryadd"><i class="mdi mdi-content-save-move"></i>  등록하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_inqueryback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row" id="upforminquery">
                                        <form class="form-horizontal mt-4 needs-validation" id="upinqueryForm" novalidate>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="unote">내용 <span class="text-danger">*</span></label>
                                                        <textarea type="text" class="form-control" rows="5" id="unote" name="unote" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="ukeyword">키워드 </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" id="ukeyword" name="ukeyword" data-role="tagsinput">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="inqueryid" />
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="justify-content-start d-flex">
                                                        <a href="javascript:void(0);" class="btn btn-success btn-sm me-2 btn_inqueryupdate"><i class="mdi mdi-content-save-move"></i>  저장하기 </a>
                                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm btn_inqueryback"><i class="mdi mdi-backspace-outline"></i> 돌아가기</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="justify-content-start d-flex">
                                                <a href="javascript:void(0);" class="btn btn-primary btn-sm btn_inqueryshow me-2"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--group modal content -->
<div id="groupmodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">그룹 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="group_info">
                <form class="needs-validation p-3" id="GroupForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="mgroup">그룹명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mgroup" name="mgroup" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_groupadd">저장하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--city modal content -->
<div id="citymodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">지역 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="city_info">
                <form class="needs-validation p-3" id="CityForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="mcity">지역 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mcity" name="mcity" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_cityadd">저장하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--stock modal content -->
<div id="stockmodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">증권사 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="stock_info">
                <form class="needs-validation p-3" id="StockForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="mstock">증권사 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mstock" name="mstock" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_stockadd">저장하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Route modal content -->
<div id="routemodal" class="modal fade" role="dialog" aria-labelledby="routeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">알게된 경로 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="route_info">
                <form class="needs-validation p-3" id="RouteForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="mroute">알게된 경로 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mroute" name="mroute" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_routeadd">저장하기</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--company modal content -->
<div id="companymodal" class="modal fade" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">기업명 추가하기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="company_info">
                <form class="needs-validation p-3" id="CompanyForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="mcompany">기업명 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mcompany" name="mcompany" required>
                    </div>
                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_companyadd">Add</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--stock status modal content -->
<div id="stockstatusmodal" class="modal fade" role="dialog" aria-labelledby="stockstatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="mstock_info">
                <form class="needs-validation" id="StockstatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="smstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_stock_status" id="smstatus" name="smstatus" required>
                            <option value="Active">이체완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mstockid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_stock_change">Add</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--method modal content -->
<div id="methodmodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">전송방법 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="method_info">
                <form class="needs-validation" id="MethodForm" novalidate>             
                    <div class="mb-3 row">
                        <label class="form-label" for="smethod">전송방법 <span class="text-danger">*</span></label>
                        <select class="form-control select_method" id="smethod" name="smethod" required>
                            <option value="Email">이메일</option>
                            <option value="Post">우편</option>
                            <option value="SMS">SMS</option>
                            <option value="Messenger">카카오톡</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="filetransferid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_transfer_change">Add</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--post status modal content -->
<div id="poststatusmodal" class="modal fade" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="poster_info">
                <form class="needs-validation" id="PostStatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="pmstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_status_post" id="pmstatus" name="pmstatus" required>
                            <option value="Delivered">발송완료</option>
                            <option value="Pending">발송중</option>
                            <option value="Returned">반송됨</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mpostid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_post_change">Add</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--visit status modal content -->
<div id="visitstatusmodal" class="modal fade" role="dialog" aria-labelledby="visitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">상태 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="mvisit_info">
                <form class="needs-validation" id="VisitStatusForm" novalidate>            
                    <div class="mb-3 row">
                        <label class="form-label" for="mvstatus">상태 <span class="text-danger">*</span></label>
                        <select class="form-control select_visit_status" id="mvstatus" name="mvstatus" required>
                            <option value="Active">완료</option>
                            <option value="Pending">진행중</option>
                            <option value="Canceled">취소</option>
                        </select>
                    </div>
                </form>
                <input type="hidden" id="mvisitid" />
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_visit_change">Add</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2({width:'100%'});
        $(".select_stock_status").select2({width: '100%',dropdownParent: $("#mstock_info")});
        $(".select_method").select2({width: '100%',dropdownParent: $("#method_info")});
        $(".select_status_post").select2({width: '100%',dropdownParent: $("#poster_info")});
        $(".select_visit_status").select2({width: '100%',dropdownParent: $("#mvisit_info")});
    });
    $('a[role=tab]').click(function(){
        if (this.id == "stocktab") {
            localStorage.setItem("tabitem", '1');
        } else if (this.id == "filetab") {
            localStorage.setItem("tabitem", '2');
        } else if (this.id == "postertab") {
            localStorage.setItem("tabitem", '3');
        } else if (this.id == "visittab") {
            localStorage.setItem("tabitem", '4');
        } else if (this.id == "inquerytab") {
            localStorage.setItem("tabitem", '5');
        }
        
    });
    var tabactive = localStorage.getItem("tabitem");
    
    if (tabactive == null || tabactive == '1') {
        $("#stocktab").addClass('active');
        $("#filetab").removeClass('active');
        $("#postertab").removeClass('active');
        $("#visittab").removeClass('active');
        $("#inquerytab").removeClass('active');

        $("#stocktransaction").addClass('active');
        $("#filetransfer").removeClass('active');
        $("#poster").removeClass('active');
        $("#visitrecord").removeClass('active');
        $("#inquery").removeClass('active');

    } else if (tabactive == '2') {
        $("#filetab").addClass('active');
        $("#stocktab").removeClass('active');
        $("#postertab").removeClass('active');
        $("#visittab").removeClass('active');
        $("#inquerytab").removeClass('active');

        $("#stocktransaction").removeClass('active');
        $("#filetransfer").addClass('active');
        $("#poster").removeClass('active');
        $("#visitrecord").removeClass('active');
        $("#inquery").removeClass('active');
    } else if (tabactive == '3'){
        $("#postertab").addClass('active');
        $("#stocktab").removeClass('active');
        $("#filetab").removeClass('active');
        $("#visittab").removeClass('active');
        $("#inquerytab").removeClass('active');

        $("#stocktransaction").removeClass('active');
        $("#filetransfer").removeClass('active');
        $("#poster").addClass('active');
        $("#visitrecord").removeClass('active');
        $("#inquery").removeClass('active');
    } else if (tabactive == '4'){
        $("#visittab").addClass('active');
        $("#stocktab").removeClass('active');
        $("#filetab").removeClass('active');
        $("#postertab").removeClass('active');
        $("#inquerytab").removeClass('active');

        $("#stocktransaction").removeClass('active');
        $("#filetransfer").removeClass('active');
        $("#poster").removeClass('active');
        $("#visitrecord").addClass('active');
        $("#inquery").removeClass('active');
    } else if (tabactive == '5'){
        $("#inquerytab").addClass('active');
        $("#stocktab").removeClass('active');
        $("#filetab").removeClass('active');
        $("#postertab").removeClass('active');
        $("#visittab").removeClass('active');

        $("#stocktransaction").removeClass('active');
        $("#filetransfer").removeClass('active');
        $("#poster").removeClass('active');
        $("#visitrecord").removeClass('active');
        $("#inquery").addClass('active');
    }
    $('.phoneMask').mask('(999)-9999-9999');
    $('#edited_date').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#stockdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#ustockdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#visitdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('.timepicker').timepicker({
        showInputs: false
    });
    $('#uvisitdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#filedate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#ufiledate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#postdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $('#upostdate').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        numberOfMonths: 2,
        dateFormat: 'yy.mm.dd',
        monthNames: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월",
        "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: [ "일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일" ],
        dayNamesShort: [ "일", "월", "화", "수", "목", "금", "토" ],
        dayNamesMin: [ "일", "월", "화", "수", "목", "금", "토" ],

    });
    $("#stock_datatable").DataTable({
        aaSorting: [[ 0, "desc" ]],
        searching: false, 
        paging: false, 
        info: false,
    });
    $("#groupmanage").on('click', function(e){
        $("#groupmodal").modal('show');
    });
    $(".btn_groupadd").on('click', function(e){
        var form = $("#GroupForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/new-group`,
            data: {
                group: $("#mgroup").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    var newOption = new Option(data.groupName, data.id, true, true);
                    $("#group").append(newOption).trigger('change');
                    $("#groupmodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    });

    $("#citiesmanage").on('click', function(e){
        $("#citymodal").modal('show');
    });
    $(".btn_cityadd").on('click', function(e){
        var form = $("#CityForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/new-city`,
            data: {
                city: $("#mcity").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    var newOption = new Option(data.cityName, data.id, true, true);
                    $("#cities").append(newOption).trigger('change');
                    $("#citymodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    });
    $("#stockmanage").on('click', function(e){
        $("#stockmodal").modal('show');
    });
    $(".btn_stockadd").on('click', function(e){
        var form = $("#StockForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/new-stock`,
            data: {
                stock: $("#mstock").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    var newOption = new Option(data.brokerName, data.id, true, true);
                    $("#stock_firm").append(newOption).trigger('change');
                    $("#stockmodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    });
    $("#routs_manage").on('click', function(e){
        $("#routemodal").modal('show');
    });
    $(".btn_routeadd").on('click', function(e){
        var form = $("#RouteForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/new-route`,
            data: {
                route: $("#mroute").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    var newOption = new Option(data.routeName, data.id, true, true);
                    $("#routsofknown").append(newOption).trigger('change');
                    $("#routemodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    });
    $("#formstock").hide();
    $("#upformstock").hide();
    $("#formfiletransfer").hide();
    $("#upformfiletransfer").hide();
    $("#formposter").hide();
    $("#upformposter").hide();
    $("#formvisit").hide();
    $("#upformvisit").hide();
    $("#forminquery").hide();
    $("#upforminquery").hide();
    $(".btn_stockshow").on('click', function(e) {
        $("#quantity").val('');
        $("#stockPrice").val('');
        $("#invested").val('');
        $("#stockdate").val('');
        $("#company").val('');
        $('#company').trigger('change');
        $("#stock_status").val('');
        $('#stock_status').trigger('change');
        $(this).hide();
        $("#formstock").show();
        $("#stock_list").hide();
        $("#upformstock").hide();
    });
    $(".btn_transfershow").on('click', function(e) {
        $("#filedate").val('');
        $("#fileName").val('');
        $("#filecompany").val('');
        $('#filecompany').trigger('change');
        $("#filemethod").val('');
        $('#filemethod').trigger('change');
        $(this).hide();
        $("#formfiletransfer").show();
        $("#filetransfer_list").hide();
        $("#upformfiletransfer").hide();
    });
    $(".btn_postershow").on('click', function(e){
        $("#postdate").val('');
        $("#postcity").val('');
        $('#postcity').trigger('change');
        $("#postcompany").val('');
        $('#postcompany').trigger('change');
        $("#post_status").val('');
        $('#post_status').trigger('change');
        $(this).hide();
        $("#formposter").show();
        $("#poster_list").hide();
        $("#upformposter").hide();
    });
    $(".btn_posterback").on('click', function(e){
        $("#formposter").hide();
        $("#poster_list").show();
        $(".btn_postershow").show();
        $("#upformposter").hide();
    });
    $(".btn_stockback").on('click', function(e){
        $("#formstock").hide();
        $("#stock_list").show();
        $(".btn_stockshow").show();
        $("#upformstock").hide();
    });
    $(".btn_fileback").on('click', function(e){
        $("#formfiletransfer").hide();
        $("#filetransfer_list").show();
        $(".btn_transfershow").show();
        $("#upformfiletransfer").hide();
    });
    $(".btn_posteradd").on('click', function(e){
        var form = $("#posterForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/posterfrom`,
            data: {
                date: $("#postdate").val(),
                company: $("#postcompany").val(),
                status: $("#post_status").val(),
                city: $("#postcity").val(),
                customer: '{{$customer->id}}'

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    })
    $("#quantity").keyup(function () {
        var total = $('#stockPrice').val();
        $("#quantity").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#invested").val(total);
    });
    $("#stockPrice").keyup(function () {
        var total = $('#quantity').val();
        $("#stockPrice").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#invested").val(total);
    });
    $("#uquantity").keyup(function () {
        var total = $('#ustockPrice').val();
        $("#uquantity").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#uinvested").val(total);
    });
    $("#ustockPrice").keyup(function () {
        var total = $('#uquantity').val();
        $("#ustockPrice").each(function (index, item) {
            var temp = parseFloat($(item).val());
            if (isNaN(temp))
                temp = 1
            total = total * temp;
        });
        $("#uinvested").val(total);
    });
    $(".btn_stockadd").on('click', function(e){
        var form = $("#stockForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/stockform`,
            data: {
                date: $("#stockdate").val(),
                company: $("#company").val(),
                status: $("#stock_status").val(),
                stockPrice: $("#stockPrice").val(),
                quantity: $("#quantity").val(),
                invested: $("#invested").val(),
                customerId: '{{$customer->id}}'

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".stock_edit").on('click', function(e){
        $("#formstock").hide();
        $(".btn_stockshow").hide();
        $("#stock_list").hide();
        $("#upstockid").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/getstock`,
            data: {
                upstock: $("#upstockid").val(),
            },
            type: 'POST',
            success: function(data) {               
                $("#uquantity").val(data.quantity);
                $("#ustockPrice").val(data.stockPrice);
                $("#uinvested").val(data.invested);
                $("#ustockdate").val(data.stockdate);
                $("#ucompany").val(data.company);
                $('#ucompany').trigger('change');
                $("#ustock_status").val(data.stock_status);
                $('#ustock_status').trigger('change');
                $("#upformstock").show();
            },
            error: function(data){
                console.log(data);
            }
        });
        
        
    });
    $(".poster_edit").on('click', function(e){
        $("#formposter").hide();
        $(".btn_postershow").hide();
        $("#poster_list").hide();
        $("#postid").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/getposterfrom`,
            data: {
                postid: $("#postid").val(),
            },
            type: 'POST',
            success: function(data) {               
                $("#upostdate").val(data.date);
                $("#upostcity").val(data.city);
                $('#upostcity').trigger('change');
                $("#upostcompany").val(data.company);
                $('#upostcompany').trigger('change');
                $("#upost_status").val(data.status);
                $('#upost_status').trigger('change');
                $("#upformposter").show();
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".btn_posterupdate").on('click', function(e){
        
        var form = $("#upposterForm");
        
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/updateposterfrom`,
            data: {
                date: $("#upostdate").val(),
                company: $("#upostcompany").val(),
                status: $("#upost_status").val(),
                city: $("#upostcity").val(),
                customer: '{{$customer->id}}',
                postid: $("#postid").val()

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".btn_stockupdate").on('click', function(e){
        var form = $("#upstockForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/updatestockform`,
            data: {
                date: $("#ustockdate").val(),
                company: $("#ucompany").val(),
                status: $("#ustock_status").val(),
                stockPrice: $("#ustockPrice").val(),
                quantity: $("#uquantity").val(),
                invested: $("#uinvested").val(),
                customerId: '{{$customer->id}}',
                upstockid: $("#upstockid").val()

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".btn_fileadd").on('click', function(e){
        var form = $("#transferForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/filefrom`,
            data: {
                date: $("#filedate").val(),
                company: $("#filecompany").val(),
                method: $("#filemethod").val(),
                fileName: $("#fileName").val(),
                customerId: '{{$customer->id}}'

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".transfer_edit").on('click', function(e){
        $("#formfiletransfer").hide();
        $("#filetransfer_list").hide();
        $(".btn_transfershow").hide();
        $("#fileid").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/getfiletransfer`,
            data: {
                fileid: $("#fileid").val(),
            },
            type: 'POST',
            success: function(data) {               
                $("#ufiledate").val(data.date);
                $("#ufileName").val(data.fileName);
                $("#ufilecompany").val(data.company);
                $('#ufilecompany').trigger('change');
                $("#ufilemethod").val(data.method);
                $('#ufilemethod').trigger('change');
                $("#upformfiletransfer").show();
            },
            error: function(data){
                console.log(data);
            }
        });

    });
    $(".btn_fileupdate").on('click', function(e){
        var form = $("#uptransferForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/updatetransferform`,
            data: {
                date: $("#ufiledate").val(),
                company: $("#ufilecompany").val(),
                method: $("#ufilemethod").val(),
                fileName: $("#ufileName").val(),
                customerId: '{{$customer->id}}',
                fileid: $("#fileid").val()

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    })
    $(".companymanage").on('click', function(e){
        $("#companymodal").modal('show');
    });
    $(".btn_companyadd").on('click', function(e){
        var form = $("#CompanyForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/new-company`,
            data: {
                company: $("#mcompany").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    var newOption = new Option(data.companyName, data.id, true, true);
                    $(".companytab").append(newOption).trigger('change');
                    $("#companymodal").modal('hide');
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
    });
    $(".btn_visitshow").on('click', function(e){
        $("#visitdate").val('');
        $("#title").val('');
        $("#time").val('');
        $("#visit_status").val('');
        $('#visit_status').trigger('change');
        $(this).hide();
        $("#formvisit").show();
        $("#visit_list").hide();
        $("#upformvisit").hide();
    });
    $(".btn_visitadd").on('click', function(e){
        var form = $("#visitForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/visitform`,
            data: {
                date: $("#visitdate").val(),
                title: $("#title").val(),
                time: $("#time").val(),
                status: $("#visit_status").val(),
                customer: '{{$customer->id}}'

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });

    $(".btn_visitupdate").on('click', function(e){
        var form = $("#upvisitForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/updatevisitform`,
            data: {
                date: $("#uvisitdate").val(),
                title: $("#utitle").val(),
                time: $("#utime").val(),
                status: $("#uvisit_status").val(),
                customer: '{{$customer->id}}',
                visitid: $("#visitid").val()

            },
            type: 'POST',
            success: function(data) {
                console.log("data", data)
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".visit_edit").on('click', function(e){
        $("#formvisit").hide();
        $("#visit_list").hide();
        $(".btn_visitshow").hide();
        $("#visitid").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/getvisitform`,
            data: {
                visitid: $("#visitid").val(),
            },
            type: 'POST',
            success: function(data) {               
                $("#uvisitdate").val(data.date);
                $("#utitle").val(data.title);
                $("#utime").val(data.time);
                $("#uvisit_status").val(data.status);
                $("#upformvisit").show();
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".btn_visitback").on('click', function(e){
        $("#formvisit").hide();
        $("#visit_list").show();
        $(".btn_visitshow").show();
        $("#upformvisit").hide();
    });
    $(".btn_inqueryshow").on('click', function(e){
        $("#note").val('');
        $("#keyword").val('');
        $("#forminquery").show();
        $("#upforminquery").hide();
        $("#inquery_list").hide();
        $(this).hide();
    });
    $(document).on('keydown', ".bootstrap-tagsinput input", function(event){
        if ( event.which == 13 ) {
            $(this).blur();
            $(this).focus();
            return false;
        }
    });
    $(".btn_inqueryadd").on('click', function(e){
        var form = $("#inqueryForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/inqueryform`,
            data: {
                note: $("#note").val(),
                keyword: $("#keyword").val(),
                customer: '{{$customer->id}}'

            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".inquery_edit").on('click', function(e) {
        $("#forminquery").hide();
        $("#inquery_list").hide();
        $(".btn_inqueryshow").hide();
        $("#inqueryid").val($(this).data('id'));
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/getinqueryform`,
            data: {
                inqueryid: $("#inqueryid").val(),
            },
            type: 'POST',
            success: function(data) {     
                console.log($("#ukeyword").tagsinput());        
                $("#unote").val(data.note);
                $("#ukeyword").tagsinput('removeAll');
                $("#ukeyword").tagsinput('add',data.keyword);
                $("#upforminquery").show();
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    $(".btn_inqueryback").on('click', function(e){
        $("#upforminquery").hide();
        $("#forminquery").hide();
        $("#inquery_list").show();
        $(".btn_inqueryshow").show();
    });
    $(".btn_inqueryupdate").on('click', function(e) {
        var form = $("#upinqueryForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/updateinqueryform`,
            data: {
                note: $("#unote").val(),
                keyword: $("#ukeyword").val(),
                customer: '{{$customer->id}}',
                inqueryid: $("#inqueryid").val()

            },
            type: 'POST',
            success: function(data) {
                console.log("data", data)
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
        });
    });
    
    $(document).on('click', "a.btn_stock_status", function() {
        $("#smstatus").val($(this).data('status'));
        $('#smstatus').trigger('change');
        $("#mstockid").val($(this).data('id'));
        $("#stockstatusmodal").modal('show');
    });
    $(".btn_stock_change").on('click', function(e){
        var form = $("#StockstatusForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/stock-status`,
            data: {
                status: $("#smstatus").val(),
                stockid: $("#mstockid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
    $(document).on('click', "a.btn_file_method", function() {
        $("#smethod").val($(this).data('method'));
        $('#smethod').trigger('change');
        $("#filetransferid").val($(this).data('id'));
        $("#methodmodal").modal('show');
    });
    $(".btn_transfer_change").on('click', function(e){
        var form = $("#MethodForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/file-transfer-method`,
            data: {
                method: $("#smethod").val(),
                fileid: $("#filetransferid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
    $(document).on('click', "a.btn_post_status", function() {
        $("#pmstatus").val($(this).data('status'));
        $('#pmstatus').trigger('change');
        $("#mpostid").val($(this).data('id'));
        $("#poststatusmodal").modal('show');
    });
    $(".btn_post_change").on('click', function(e){
        var form = $("#StockstatusForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/post-status`,
            data: {
                status: $("#pmstatus").val(),
                postid: $("#mpostid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
    $(document).on('click', "a.btn_visit_status", function() {
        $("#mvstatus").val($(this).data('status'));
        $('#mvstatus').trigger('change');
        $("#mvisitid").val($(this).data('id'));
        $("#visitstatusmodal").modal('show');
    });
    $(".btn_visit_change").on('click', function(e){
        var form = $("#VisitStatusForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/visit-status`,
            data: {
                status: $("#mvstatus").val(),
                visitid: $("#mvisitid").val()
            },
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } 
            },
            error: function(data){
                console.log(data);
            }
       });
        
    });
</script>
@endsection