@extends('admin.layouts.app')
@section('title', '파일전송')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- DataTables -->
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endsection
@section('content')
<div class="container-fluid">
    <div class="row mt-3 mb-3">
        <div class="button-items">
            <a href="{{ url('admin/user-record/stocks') }}" class="btn btn-custom-light waves-effect waves-light">주식이체</a>
            <a href="{{ url('admin/user-record/file-transfers') }}" class="btn btn-secondary waves-effect waves-light">파일전송</a>
            <a href="{{ url('admin/user-record/post-delivery') }}" class="btn btn-custom-light waves-effect waves-light">우편발송</a>
            <a href="{{ url('admin/user-record/visit-record') }}" class="btn btn-custom-light waves-effect waves-light">방문기록</a>
            <a href="{{ url('admin/user-record/inquery') }}" class="btn btn-custom-light waves-effect waves-light">전체메모</a>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="page-title-custom">
                                        <h4>파일전송</h4>
                                    </div>
                                </div>
                                <div class="mb-3 mt-1 col-md-3 d-flex">
                                    <select class="form-control search_filter" id="group_filter" required>
                                        <option value="">Group..</option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}">{{$group->groupName}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mb-3 mt-1 col-md-3 d-flex">
                                    <select class="form-control search_filter" id="company_filter" required>
                                        <option value="">Companies..</option>
                                        @foreach($companies as $company)
                                            <option value="{{$company->id}}">{{$company->companyName}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mb-3 mt-1 col-md-3 d-flex">
                                    <select class="form-control search_filter" id="route_filter" required>
                                        <option value="">Routes of Known..</option>
                                        @foreach($routeknowns as $routeknown)
                                            <option value="{{$routeknown->id}}">{{$routeknown->routeName}}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <form method="POST" accept-charset="UTF-8" id="mass_delete_form" action="{{ url ('admin/user-record/filedelete') }}">
                                    @csrf
                                    <input id="selected_rows" name="selected_rows" type="hidden">
                                    <input class="btn btn-secondary btn-sm me-2" id="delete-selected" type="submit" value="Delete">
                                </form>
                                <a href="{{ url('admin/user-record/add_file_transfer') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save-move"></i> Add</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                        </label>
                                    </th>
                                    <th>날짜</th>
                                    <th>이름</th>
                                    <th>기업</th>
                                    <th>파일 이름</th>
                                    <th>전송방법</th>
                                    <th>관리자</th>
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
<!--method modal content -->
<div id="methodmodal" class="modal fade" role="dialog" aria-labelledby="methodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="head_title">전송방법 선택</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body" id="manage_info">
                <form class="needs-validation" id="MethodForm" novalidate>
                    <meta name="csrf-token" content="{{ csrf_token() }}" />              
                    <div class="mb-3 row">
                        <label class="form-label" for="method">전송방법 <span class="text-danger">*</span></label>
                        <select class="form-control select_method" id="method" name="method" required>
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
@stop
@section('javascript')
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script>
    $("#delete-selected").hide();
    col_targets = [0, 1, 5];
    var file_table = $('#datatable').DataTable({
        aaSorting: [[ 1, "desc" ]],
        lengthChange:!1,
        processing: true,
        serverSide: true,
        searching: false, 
        paging: false, 
        info: false,
        "ajax": {
            "url": "/admin/user-record/file-transfers",
            "data": function ( d ) {
                d.group_filter = $('select#group_filter').val();
                d.company_filter = $('select#company_filter').val();
                d.route_filter = $('select#route_filter').val();
            }
        },
        "dom": 'Bfrtip',
        columnDefs: [ {
            "targets": col_targets,
            "orderable": false,
            "searchable": false
        } ],
        "columns":[
            {"data":"mass_delete"},
            {"data":"date"},
            {"data":"name"},
            {"data":"companyName"},
            {"data":"fileName"},
            {"data":"method"},
            {"data":"admin"},
            {"data":"action"}
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(2)').attr('class', 'bg-light text-primary fw-bold');
        },
    });
    $(".search_filter").select2({width: '100%'});
    $(".select_method").select2({width: '100%',dropdownParent: $("#manage_info")});
    $('select#group_filter, select#company_filter, select#route_filter').on('change', function(){
        file_table.ajax.reload();
    });
    $(document).on('click', '#delete-selected', function(e){
        e.preventDefault();
        var selected_rows = [];
        var i = 0;
        $('.form-check-input:checked').each(function () {
            selected_rows[i++] = $(this).val();
        }); 
        
        if(selected_rows.length > 0){
            $('input#selected_rows').val(selected_rows);
            Swal.fire({
                title: "Are you Sure?",
                icon: "warning",
                showCancelButton:!0,
                confirmButtonColor:"#7a6fbe",
                cancelButtonColor:"#f46a6a",
            }).then((willDelete) => {
                if (willDelete) {
                    $('form#mass_delete_form').submit();
                }
            });
        }  
    });
    $(document).on('click', "a.btn_method", function() {
        $("#method").val($(this).data('method'));
        $('#method').trigger('change');
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
                method: $("#method").val(),
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
    
</script>
@endsection