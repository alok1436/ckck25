jQuery(function($) {
    jQuery.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    //------------- Create Record ----------//
    $("#form").off().on("submit", function() {
        var formData = new FormData($("#form")[0]);
        $.ajax({
            beforeSend: function() {
                $("#form").find('button').attr('disabled', true);
                $("#form").find('button>i.fa').show();
            },
            url: $("#form").attr('action'),
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    if (response.reload != '') {
                        location.reload();
                    } else if (response.redirect_url != '') {
                        toastr.success(response.message, 'Success');
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000);
                    }
                } else {
                    toastr.error('Something going wrong!', 'Opps!');
                }
            },
            complete: function() {
                $("#form").find('button').attr('disabled', false);
                $("#form").find('button>i.fa').hide();
            },
            error: function(status, error) {
                var errors = JSON.parse(status.responseText);
                if (status.status == 401) {
                    console.log(errors);
                    $("#form").find('button').attr('disabled', false);
                    $("#form").find('button>i.fa').hide();
                    $.each(errors.error, function(i, v) {
                        toastr.error(v[0], 'Opps!');
                    });
                } else {
                    toastr.error(errors.message, 'Opps!');
                }
            }
        });
        return false;
    });
    
    $("body").on('click','.copyAddress',function(){
       var address = $(this).data('address');
       $(".pastAddress").val(address);
    });
});