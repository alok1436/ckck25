<!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{asset('assets/libs/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{asset('assets/js/app.js') }}"></script>
<script src="{{ asset('assets/js/validations.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/tagsinput.js') }}"></script>
<script src="{{ asset('assets/timepicker/bootstrap-timepicker.min.js') }}"></script>
<!-- <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script> -->
<script src="{{ asset('assets/libs/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('assets/dropify/dist/js/dropify.min.js') }}"></script>

<!-- toastr -->
<script src="{{ url('assets/toastr/js/toastr.min.js') }}"></script>
<script src="{{ url('assets/toastr/js/toastr.init.js') }}"></script>

<script src="{{ asset('js/custom.js?v='.time()) }}"></script>

<script>
    $("#select-all-row").on('click', function(e) {
        if(this.checked){
            $(this).closest('table').find('tbody').find('input.form-check-input').each( function(){
                if(!this.checked){
                    $(this).prop('checked', true).change();
                    $('#delete-selected').show();
                }
            });
        } else {
            $(this).closest('table').find('tbody').find('input.form-check-input').each( function(){
                if(this.checked){
                    $(this).prop('checked', false).change();
                    $('#delete-selected').hide();
                }
            });
        } 
    });
    $(document).on('change', "input.form-check-input", function(){
        if(this.checked){
            $(this).closest('tr').addClass('selected');
            $('#delete-selected').show();
        } else {
            $(this).closest('tr').removeClass('selected');
            $('#delete-selected').hide();
        } 
    });
</script>
<!-- Sweet Alerts js -->
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@yield('javascript')