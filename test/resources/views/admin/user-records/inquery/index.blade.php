@extends('admin.layouts.app')
@section('title', '전체메모')
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
            <a href="{{ url('admin/user-record/file-transfers') }}" class="btn btn-custom-light waves-effect waves-light">파일전송</a>
            <a href="{{ url('admin/user-record/post-delivery') }}" class="btn btn-custom-light waves-effect waves-light">우편발송</a>
            <a href="{{ url('admin/user-record/visit-record') }}" class="btn btn-custom-light waves-effect waves-light">방문기록</a>
            <a href="{{ url('admin/user-record/inquery') }}" class="btn btn-secondary waves-effect waves-light">전체메모</a>
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
                                        <h4>전체메모</h4>
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
                                <form method="POST" accept-charset="UTF-8" id="mass_delete_form" action="{{ url ('admin/user-record/inquerydelete') }}">
                                    @csrf
                                    <input id="selected_rows" name="selected_rows" type="hidden">
                                    <input class="btn btn-secondary btn-sm me-2" id="delete-selected" type="submit" value="Delete">
                                </form>
                                <a href="{{ url('admin/user-record/add_inquery') }}" class="btn btn-primary btn-sm"><i class="mdi mdi-content-save-move"></i> 등록하기</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-1">
                        <table id="datatable_button" class="table table-bordered align-middle dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id='select-all-row'><span></span>
                                        </label>
                                    </th>
                                    <th>날짜</th>
                                    <th>이름</th>
                                    <th>내용</th>
                                    <th>키워드</th>
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
    var inquery_table = $('#datatable_button').DataTable({
        aaSorting: [[ 1, "desc" ]],
        lengthChange:!1,
        processing: true,
        serverSide: true,
        searching: false, 
        paging: false, 
        info: false,
        "ajax": {
            "url": "/admin/user-record/inquery",
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
            {"data":"note"},
            {"data":"keyword"},
            {"data":"admin"},
            {"data":"action"}
        ],
        "createdRow": function( row, data, dataIndex ) {
            $( row ).find('td:eq(2)').attr('class', 'bg-light text-primary fw-bold');
        },
    });
    $(".select2").select2({width: '100%'});
    $(".search_filter").select2({width: '100%'});
    $('select#group_filter, select#company_filter, select#route_filter').on('change', function(){
        inquery_table.ajax.reload();
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
    })
</script>
@endsection