@extends('admin.layouts.app')
@section('title', 'Customer Add')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <a href="" class="btn btn-primary btn-sm" style="margin-bottom: 0px!important;">
                                    <i class="mdi mdi-content-save-move"></i> Memo</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/add_customer') }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name></label>
                                    <input type="text" class="form-control" id="name" name="name" >
                                    <!--<span class="text-danger">{{ $errors->first('name') }}</span>-->
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="group">Groups></label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="group" name="group" >
                                            <option value="">Group..</option>
                                            @foreach($groups as $group)
                                                <option value="{{$group->id}}">{{$group->groupName}}</option>
                                            @endforeach
                                        </select>
                                    
                                        <a href="javascript:void(0);" id="groupmanage" class="btn btn-primary input-group-text">추가</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="age">Age></label>
                                            <input type="text" class="form-control" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" id="age" name="age" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="gender">Gender></label>
                                            <select class="form-control select2" id="gender" name="gender" >
                                                <option value="">성별..</option>
                                                <option value="M">남자</option>
                                                <option value="F">여자</option>
                                                <option value="O">기타</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="form-label" for="cities">Cities></label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="cities" name="cities" >
                                            <option value="">Cities..</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}">{{$city->cityName}}</option>
                                            @endforeach
                                        </select>

                                        <a href="javascript:void(0);" id="citiesmanage" class="btn btn-primary input-group-text" >추가</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address></label>
                                    <input type="text" class="form-control" id="address" name="address" >
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="phonenumber1">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phonenumber" name="phonenumber1" required>
                                </div>
                                
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="stock_firm">Stock Firm</label>
                                    <div class="input-group">
                                        <select class="form-control select2" id="stock_firm" name="stock_firm" >
                                            <option value="">StockBroker..</option>
                                            @foreach($stockbrokers as $stockbroker)
                                                <option value="{{$stockbroker->id}}">{{$stockbroker->brokerName}}</option>
                                            @endforeach
                                        </select>

                                        <a href="javascript:void(0);" id="stockmanage" class="btn btn-primary input-group-text">추가</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="account_number">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number">
                                    <!--<input type="text" class="form-control" id="account_number" name="account_number" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" >-->
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="phonenumber2">Phone Number 2</label>
                                    <input type="text" class="form-control" id="phonenumber2" name="phonenumber2" >
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="edited_by">Edited By</label>
                                    <select class="form-control select2" id="edited_by" name="edited_by" >
                                        <option value="">Edited By..</option>
                                        @foreach($admins as $admin)
                                            <option value="{{$admin->id}}">{{$admin->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="edited_date">Edited Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edited_date" name="edited_date" >
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="email">E-mail</label>
                                    <input type="email" class="form-control" id="email" name="email" >
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
                                        <select class="form-control select2" id="routsofknown" name="routsofknown" >
                                            <option value="">Routes of Known..</option>
                                            @foreach($routeknowns as $routeknown)
                                                <option value="{{$routeknown->id}}">{{$routeknown->routeName}}</option>
                                            @endforeach
                                        </select>
                                        <a href="javascript:void(0);" id="routs_manage" class="btn btn-primary input-group-text" >추가</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2" style="margin-bottom: 0px!important;"><i class="mdi mdi-content-save-move"></i> Create</button>
                                    <a href="{{ url('admin/customers') }}" class="btn btn-danger btn-sm m-2" style="margin-bottom: 0px!important;"><i class="mdi mdi-backspace-outline"></i> back</a>
                                </div>
                            </div>
                        </div>
                    </form>
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
<div id="routemodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
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
    $(".select2").select2({width: "100%"});
    $('.phoneMask').mask('(999) 9999-9999');
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
</script>
@endsection