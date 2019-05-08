$(document).ready(function () {

    $('#order-table_no').hide();


    $("#order-type").change(function () {


        if ($(this).val() == 2) {

            $('#order-table_no').show();

            //$("#order-table_no").attr("display","inline");
        }

    });

    $("#order").on('click', function () {

        $("#w0").submit();

    });


    // $('#w0').on('beforeSubmit', function (e) {
    //
    //
    //     //alert('haha');
    //
    //     var form = $(this);
    //
    //     var name = $('#guest-name').val()
    //
    //
    //     var tableno = $('#order-table_no').val()
    //
    //     var type = $('#order-type').val()
    //
    //     var checkedRowId = $("#w1").yiiGridView('getSelectedRows');
    //
    //
    //     $('#order').append('<i class="fa fa-spinner fa-spin spinner" ></i>');
    //
    //
    //     $.ajax({
    //
    //         url: form.attr("action"),
    //
    //         type: form.attr("method"),
    //
    //         data: {
    //             'checkedRowId': checkedRowId,
    //             'name': name,
    //             'tableno': tableno,
    //             'type': type
    //         },
    //
    //         success: function (data) {
    //
    //             window.location.replace(data);
    //         },
    //
    //         error: function () {
    //
    //             alert("Something went wrong");
    //
    //         }
    //
    //     });
    //
    // }).on('submit', function (e) {
    //
    //     e.preventDefault();
    //
    // });


});


