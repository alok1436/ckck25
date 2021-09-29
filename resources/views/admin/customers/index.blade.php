@extends('admin.layouts.app')
@section('title', 'Customers')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<style type="text/css">
    .dt-button-collection .dropdown-menu {
        position:relative !important
    }
    .dt-button-collection {
        left: unset !important;
        right: 10px ;
    }
    .dropdown-item.active, .dropdown-item:active {
        color: #f4f5f7;
        text-decoration: none;
        background-color: #7a6fbe;
    }
    .dropify-wrapper .dropify-message span.file-icon p {
        font-size:14px!important;
        color: #CCC;
    }
    #cutomerImportForm{
        display: flex !important;
    }
    .import-file{
        height: 33px;
    }
    .import-btn{
        width: 33%;
    }
</style>
<div class="container-fluid">
    <div class="row">

        <div class="mb-3 mt-1 col-md-2 d-flex">
            <button type="button" id="allcustomer" class="btn btn-primary btn-sm me-2 ps-3 pe-3">All</button>
            <select class="form-control search_filter" id="group_filter" required>
                <option value="">Group..</option>
                @foreach($groups as $group)
                    <option value="{{$group->id}}">{{$group->groupName}}</option>
                @endforeach
            </select>
            
        </div>
        <div class="mb-3 mt-1 col-md-2 d-flex">
            <select class="form-control search_filter" id="company_filter" required>
                <option value="">Companies..</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->companyName}}</option>
                @endforeach
            </select>
            
        </div>
        <div class="mb-3 mt-1 col-md-2 d-flex">
            <select class="form-control search_filter" id="route_filter" required>
                <option value="">Routes of Known..</option>
                @foreach($routeknowns as $routeknown)
                    <option value="{{$routeknown->id}}">{{$routeknown->routeName}}</option>
                @endforeach
            </select>
            
        </div>
        <div class="mb-3 mt-1 col-md-2 d-flex">
            <input type="text" class="form-control" id="daterange" name="daterange" placeholder="Date range" readonly required>
            
        </div>
        <div class="mb-3 mt-1 col-md-4">
            <div class="justify-content-end d-flex">
                <a href="javascript:void(0);" id="alldelete" style="padding-top:5px;" class="me-2"><i class="dripicons-warning" style="font-size:24px;"></i></a>
                <div class="custom_manage_button" style="padding-top:2px;">
                </div>
            </div>
        </div>
    </div>

    
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="page-title-custom">
                                <h4>Customers</h4>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="justify-content-end d-flex">
                                <div class="button-items">
                                    <div class="dropdown d-inline-block pt-1 mt-1" style="display: flex !important;">
                                        {{ Form::open(array('url' => '', 'files' => true,'id'=>'cutomerImportForm')) }}
                                            {{ Form::file('file',array('class'=>'form-control import-file' )) }}
                                            <button type="submit" class="btn btn-secondary import-btn">
                                                Import <i class="fas fa-file-import"></i> 
                                                <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                            </button>
                                        {{ Form::close() }}

                                        <a href="{{ url('admin/cutomerExport') }}" class="btn btn-secondary">
                                           Export <i class="fa fa-file-export"></i>
                                        </a>

                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Selected
                                            <i class="mdi mdi-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="page-header-user-dropdown">
                                            <!-- item-->
                                            <a class="dropdown-item customer_delete" href="javascript:void(0);"> Delete</a>
                                            <a class="dropdown-item" href="#"> Send SMS</a>
                                            <a class="dropdown-item d-block" href="#"> Send E-mail</a>
                                        </div>
                                        
                                         <a href="{{ url('admin/add_customer') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save-move"></i> Add Customer</a>
                                    </div>
                                    <div id="message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable-buttons" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                        </label>
                                    </th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>City</th>
                                    <th>Group</th>
                                    <th>Email</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--excel upload modal content -->
<div id="exceluploadmodal" class="modal fade" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">Add New Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation p-3" id="ExceluploadForm" enctype="multipart/form-data" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                    <div id="text_error" class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
                    </div>
                    <div class="mb-3 row pt-2">
                        <label for="excel_file" class="col-md-4 col-form-label">Excel File:</label>
                        <div class="col-md-8">
                            <input class="dropify" type="file" id="excel_file" name="excel_file" required>
                        </div>
                    </div>
                </form>           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm btn_exceladd">Upload</button>
                
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
<!-- Buttons examples -->
<script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.maskedinput/jquery.maskedinput.js') }}"></script>

<script src="{{ asset('assets/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
    $('.dropify').dropify();
    col_targets = [0, 1, 5];
    //Default settings for daterangePicker
    var ranges = {};
    ranges['today'] = [moment(), moment()]; 
    ranges['yesterday'] = [moment().subtract(1, 'days'), moment().subtract(1, 'days')]; 
    ranges['last 7 days'] = [moment().subtract(6, 'days'), moment()]; 
    ranges['last 30 days'] = [moment().subtract(29, 'days'), moment()];
    ranges['this month'] = [moment().startOf('month'), moment().endOf('month')];
    ranges['last month'] = [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')];
    ranges['Reset'] = [null,null];
    var moment_date_format = "YYYY.MM.DD";
    var dateRangeSettings = {
        ranges: ranges,
        autoUpdateInput:false,
        format: 'YYYY.MM.DD',
        showWeekNumbers: true,
        howDropdowns: true,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-success',
        cancelClass: 'btn-danger',
        locale: {
            cancelLabel: '취소',
            applyLabel: '적용',
            customRangeLabel: 'custom range',
            format: moment_date_format,
            toLabel: "~",
            daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
            monthNames: ['1 월', '2 월', '3 월', '4 월', '5 월', '6 월', '7 월', '8 월', '9 월', '10 월', '11 월', '12 월'],
        }
    };
    
    //date filter for expense table
    if($('#daterange').length == 1){
        $('#daterange').daterangepicker(
            dateRangeSettings,
            function (start, end) {
                if(start._isValid && end._isValid) {
                    $('#daterange').val(start.format(moment_date_format) + ' ~ ' + end.format(moment_date_format));
                } else {
                    $('#daterange').data('daterangepicker').setStartDate(moment().startOf('month'));
                    $('#daterange').data('daterangepicker').setEndDate(moment().endOf('month'));
                    $("#daterange").val("");
                }
                customer_table.ajax.reload();
            }
        );
        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
            customer_table.ajax.reload();
        });
        $('#daterange').data('daterangepicker').setStartDate(moment().startOf('month'));
        $('#daterange').data('daterangepicker').setEndDate(moment().endOf('month'));
    }
    $('#daterange').val('');
    var customer_table = $('#datatable-buttons').DataTable({
        aaSorting: [[ 0, "desc" ]],
        
        lengthChange:!1,
        processing: true,
        serverSide: true,
        searching: false, 
        paging: false, 
        info: false,
        "ajax": {
            "url": "/admin/customers",
            "data": function ( d ) {
                d.group_filter = $('select#group_filter').val();
                d.company_filter = $('select#company_filter').val();
                d.route_filter = $('select#route_filter').val();
                d.start_date = $('input#daterange').data('daterangepicker').startDate.format('YYYY.MM.DD');
                d.end_date = $('input#daterange').data('daterangepicker').endDate.format('YYYY.MM.DD');
            }
        },
        "dom": 'Bfrtip',
        columnDefs: [ {
            "targets": col_targets,
            "orderable": false,
            "searchable": false
        } ],
        select: true,
        "columns":[
            {"data":"mass_delete"},
            {"data":"date"},
            {"data":"name"},
            {"data":"phonenumber1"},
            {"data":"gender"},
            {"data":"age"},
            {"data":"cityName"},
            {"data":"customerGroupID"},
            {"data":"email"},
            {"data":"action"}
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(2)').attr('class', 'bg-light text-primary fw-bold');
        },
        buttons: [
            {
                extend: 'pdfHtml5',
                text: "PDF",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copyHtml5',
                text: "Copy",
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: "Display",
                postfixButtons: [ 'colvisRestore' ]
            },
        
        ],
    });
    
    $("#text_error").hide();
    $('.phoneMask').mask('(999) 9999-9999');
    customer_table.buttons().container().appendTo(".custom_manage_button");
    $(".dataTables_length select").addClass("form-select form-select-sm");
    $(".search_filter").select2({width: '100%'});
    $('select#group_filter, select#company_filter, select#route_filter').on('change', function(){
        customer_table.ajax.reload();
    });
    $('#allcustomer').on('click', function(e) {
        
        location.reload();
    })
    $(".btn_exceladd").on('click', function(e){
        var form = $("#ExceluploadForm");
        if (form[0].checkValidity() === false) {
            event.preventDefault()
            event.stopPropagation()
            form.addClass('was-validated');
            return;
        }
        
        var excel_file = $("#excel_file").prop('files')[0];
        console.log(excel_file);
        var form_data = new FormData();
        form_data.append('excel_file', excel_file);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: `/admin/excel-upload`,
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data) {
                if (data.status == "Success") {
                    location.reload();
                } else {
                    $("#text_error").html("File empty or bad file");
                    $("#text_error").show();
                }
            },
            error: function(data){
                $("#text_error").html(data);
                $("#text_error").show();
            }
       });
    });
    $('#excel_file').on('change', function(event) {
		var inputFile = event.currentTarget;
		var file_name = inputFile.files[0].name;
		var arr_file_name = file_name.split(".");
		var file_extension = arr_file_name[arr_file_name.length - 1];

		if (file_extension == "xls" || file_extension == "xlsx"){
			$("#text_error").html("");
            $("#text_error").hide();
            $(".btn_exceladd").prop('disabled', false);
		} else {
            $("#text_error").html("Should be Excel file");
			$("#text_error").show();
			$('#excel_file').empty();
            $(".btn_exceladd").prop('disabled', true);
        }
    });
    $("#alldelete").on('click', function(e){
        e.preventDefault();
        var selected_rows = [];
        var i = 0;
        $('.form-check-input').each(function () {
            if($(this).val() != "on") {
                selected_rows[i++] = $(this).val();
            }
            
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(selected_rows.length > 0) {
            $.ajax({
                url: `/admin/customerdelete`,
                data: {
                    selected_rows: selected_rows,
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
        }
    })

    $(".customer_delete").on('click', function(e){
        e.preventDefault();
        var selected_rows = [];
        var i = 0;
        $('.form-check-input:checked').each(function () {
            selected_rows[i++] = $(this).val();
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if(selected_rows.length > 0) {
            $.ajax({
                url: `/admin/customerdelete`,
                data: {
                    selected_rows: selected_rows,
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
        }
    });

    $("#cutomerImportForm").on('submit', function(){
        var formData = new FormData($("#cutomerImportForm")[0]);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $("#cutomerImportForm").find('button').attr('disabled', true);
                $("#cutomerImportForm").find('button>.fa.fa-spinner.fa-spin').show();
            },
            url: `/admin/cutomerImport`,
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    var html = '<span style="color:green;">'+response.message+'</span>';
                    $('#message').html(html);
                    location.reload();
                } 
            },
            complete: function() {
                $("#cutomerImportForm").find('button').attr('disabled', false);
                $("#cutomerImportForm").find('button>i.fa.fa-spinner.fa-spin').hide();
            },
            error: function(data){
                var errors = JSON.parse(data.responseText);
                if (data.status == 401) {
                    $("#cutomerImportForm").find('button').attr('disabled', false);
                    $("#cutomerImportForm").find('button>i.fa.fa-spinner.fa-spin').hide();
                    $.each(errors.error, function(i, v) {
                        console.log(v[0]);
                        var html = '<span style="color:red;">'+v[0]+'</span>';
                        $('#message').html(html);
                    });
                }
            }
        });
        return false;
    });

</script>
@endsection