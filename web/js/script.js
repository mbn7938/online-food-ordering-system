$(document).ready(function () {

    $('#order-table_no').hide();


    $("#order-type").change(function () {


        if ($(this).val() == 2) {

            $('#order-table_no').show();

            //$("#order-table_no").attr("display","inline");
        }

    });

    $("#order").on('click', function () {

        $("#order-form").submit();

    });


    $('#order-form').on('beforeSubmit', function (e) {


        //alert('haha');

        var form = $(this);

        var email = $('#guest-email').val()

        var tel_no = $('#guest-tel_no').val()


        var tableno = $('#order-table_no').val()

        var type = $('#order-type').val()

        var checkedRowId = $("#order-menu-gridview").yiiGridView('getSelectedRows');

        if(checkedRowId == null)
        {
            alert('No menu selected');
        }


        $('#order').append('<i class="fa fa-spinner fa-spin spinner" ></i>');


        $.ajax({

            url: form.attr("action"),

            type: form.attr("method"),

            data: {
                'checkedRowId': checkedRowId,
                'email': email,
                'tel_no': tel_no,
                'tableno': tableno,
                'type': type
            },

            success: function (data) {

                window.location.replace(data);
            },

            error: function () {

                alert('No menu selected');

            }

        });

    }).on('submit', function (e) {

        e.preventDefault();

    });


});


