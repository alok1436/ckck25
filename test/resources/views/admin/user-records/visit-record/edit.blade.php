@extends('admin.layouts.app')
@section('title', '방문기록 수정')
@section('css')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<style>
    .form-control {
        padding: 0.50rem .75rem;
    }

</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h4>방문기록 수정</h4>
                            </div>
                        </div>
                        <div class="mb-3 mt-1 col-md-6">
                            <div class="justify-content-end d-flex">
                                <a href="{{ url('admin/user-record/visit-record') }}" class="btn btn-primary btn-sm"> 돌아가기</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-auto flex-grow-1 mt-1 mb-3" style="height:1px;">
                    <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/user-record/edit_visit_record/'.$visitrecord->id) }}" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="date">날짜 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="date" name="date" value="{{date('Y.m.d', strtotime($visitrecord->date))}}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="mb-3">
                                    <label class="form-label" for="title">제목 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$visitrecord->title}}" required>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="time">시간 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control timepicker" id="time" name="time" value="{{$visitrecord->time}}" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="visit_status">상태 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="visit_status" name="visit_status" required>
                                        <option value="">상태..</option>
                                        <option value="Active" @if($visitrecord->status == "Active") selected @endif>완료</option>
                                        <option value="Pending" @if($visitrecord->status == "Pending") selected @endif>진행중</option>
                                        <option value="Canceled" @if($visitrecord->status == "Canceled") selected @endif>취소</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="customer">고객 <span class="text-danger">*</span></label>
                                    <select class="form-control select2" id="customer" name="customer" required>
                                        <option value="">고객..</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}" @if($customer->id == $visitrecord->userId) selected @endif>{{$customer->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="justify-content-start d-flex">
                                    <button type="sumbit" name="submit" value="submit" class="btn btn-success btn-sm m-2"><i class="mdi mdi-content-save-move"></i>  저장하기 </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
<script type="text/javascript">
    $(".select2").select2();
    $('#date').datepicker({
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
</script>
@endsection