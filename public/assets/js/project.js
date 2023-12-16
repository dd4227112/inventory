$(document).ready(function () {
    getcustomer();
});


function getcustomer() {
    $.ajax({
        type: 'GET',
        url: "getcustomer",
        dataType: "html",
        success: function (response) {
            $('#getCustomer').html(response);
        }
    });

}

search = $('#serchProduct').keyup(function () {
    var seachkey = $('input[name =searchProduct]').val();
    if (seachkey.length >= 2) {
        $.ajax({
            method: 'GET',
            url: "/getProduct/" + seachkey,
            dataType: "html",
            success: function (response) {
                $('#searchResult').html(response);
            }
        });
    } else {
        $('#searchResult').html('');
    }
});


$(document).ready(search);


$(document).on("click", ".pick_product", function () {
    var id = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: 'fetch_product',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            product_id: id
        },
        success: function (response) {
            $('#selectedProduct').append(response);
            $('input[name =searchProduct]').val('');
            $('#searchResult').html('');
        },
        error: function (error) {
            console.log(error);
        }
    });

});
