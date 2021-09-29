@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('css')
<!-- C3 Chart css -->
<link href="{{ asset('assets/libs/c3/c3.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <div class="mt-2">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h5 class="font-size-14 mb-4">Recent Activity Feed</h5>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled activity-feed ms-1">
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">15 Jul</div>
                                    <p class="activity-text mb-0">Responded to need “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">14 Jul</div>
                                    <p class="activity-text mb-0">neque porro quisquam est <a href="javascript:void(0);" class="text-success">@Christi</a> dolorem ipsum quia dolor sit amet</p>
                                </div>
                            </div> 
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">14 Jul</div>
                                    <p class="activity-text mb-0">Sed ut perspiciatis unde omnis iste natus error sit “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">13 Jul</div>
                                    <p class="activity-text mb-0">Responded to need “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <div class="mt-1">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-title-custom">
                                <h5 class="font-size-14 mb-4">Recent User's Memo</h5>
                            </div>
                        </div>
                    </div>
                    <ul class="list-unstyled activity-feed ms-1">
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">15 Jul</div>
                                    <p class="activity-text mb-0">Responded to need “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>

                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">14 Jul</div>
                                    <p class="activity-text mb-0">neque porro quisquam est <a href="javascript:void(0);" class="text-success">@Christi</a> dolorem ipsum quia dolor sit amet</p>
                                </div>
                            </div> 
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">14 Jul</div>
                                    <p class="activity-text mb-0">Sed ut perspiciatis unde omnis iste natus error sit “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>
                        <li class="feed-item">
                            <div class="feed-item-list">
                                <div>
                                    <div class="date">13 Jul</div>
                                    <p class="activity-text mb-0">Responded to need “Volunteer Activities”</p>
                                </div>
                            </div> 
                        </li>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mt-1">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="page-title-custom">
                                    <h5 class="font-size-14 mb-4">Routs of Known Rate</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="justify-content-end d-flex">
                                    <select class="form-control select2" id="routs_year" required>
                                    <option value="">Year</option>
                                    @foreach($years as $year)
                                        <option value="{{$year}}">{{$year}}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>
                            <div id="routs-chart" dir="ltr"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/libs/d3/d3.min.js') }}"></script>
<script src="{{ asset('assets/libs/c3/c3.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.full.min.js') }}"></script>
<script>
    ! function(e) {
        "use strict";

        function t() {}
        t.prototype.init = function() {
            c3.generate({
                bindto: "#routs-chart",
                data: {
                    columns: [
                        ["Campaign", 78],
                        ["Orther", 55],
                        ["Registered", 40],
                        ["Visitor", 25]
                    ],
                    type: "donut"
                },
                donut: {
                    title: "Customers",
                    width: 15,
                    label: {
                        show: !1
                    }
                },
                color: {
                    pattern: ["#7a6fbe", "#ec536c", "#58db83", "#0dcaf0"]
                }
            })
        }, e.ChartC3 = new t, e.ChartC3.Constructor = t
    }(window.jQuery),
    function() {
        "use strict";
        window.jQuery.ChartC3.init()
    }();
    $(".select2").select2({width: "100%"});
</script>
@endsection