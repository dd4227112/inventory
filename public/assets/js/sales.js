

// get total items
function getTotalItems() {
    const element = document.getElementById("total_items");
    var inputs = document.querySelectorAll("#quantity");
    var sum = 0;

    for (let i = 0; i < inputs.length; i++) {
        sum += parseInt(inputs[i].value, 10);
    }
    return element.innerHTML = sum;
}



//calculate total amount

function calculteTotalAmount() {
    const grand_total = document.getElementById("grand_total");
    const total = document.getElementById("total");
    const grand_sub = document.getElementById("grand_sub");
    var inputs = document.querySelectorAll("#sub_total");
    var amount = 0
    for (let i = 0; i < inputs.length; i++) {
        amount += parseFloat(inputs[i].value);
    }

    var amount = amount.toLocaleString("en-US");
    return grand_total.innerHTML = amount, grand_sub.value = amount;
}

//remove product from list
$(document).on("click", "#remove", function () {
    $(this).closest('tr').remove();
    getTotalItems();
    grand_sub_total();
    calculteTotalAmount();
});

$(document).on("change", "#quantity", function () {
    var row = $(this).closest('tr');
    var a = row.children().children('#price').val();
    var b = row.children().children('#quantity').val();
    var sub_total = parseFloat(a * b);
    row.children().children('#sub_total').val(sub_total);
    getTotalItems();
    grand_sub_total();
    calculteTotalAmount();

});

function grand_sub_total() {
    const grand_sub_total = document.getElementById("grand_sub_total");
    var inputs = document.querySelectorAll("#sub_total");
    var amount = 0
    for (let i = 0; i < inputs.length; i++) {
        amount += parseFloat(inputs[i].value);
    }

    var amount = amount.toLocaleString("en-US");
    return grand_sub_total.innerHTML = amount;

}

// add payment modal
add_payment = $('.createpayment').click(function () {
    var uuid = $(this).attr('id');
    $.ajax({
        type: 'POST',
        url: 'getsalepayment',
        dataType: 'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            uuid: uuid
        },
        success: function (response) {
            $('#purchase_amount').val(response.balance);
            $('#amount').val(response.balance);
            $('#customer').val(response.customer);
            $('#sale_id').val(response.sale_id);
            $('#createpayment').modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });

});
$(document).ready(add_payment);

$(document).ready(function () {
    $(".delete_sale").on("click", function () {
        var id = $(this).attr('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false
        }).then(function (t) {
            if (t.value && t.dismiss !== "cancel") {
                $.ajax({
                    type: 'POST',
                    url: 'deletesale',
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        id: id
                    },
                    success: function (response) {
                        Swal.fire({
                            type: "success",
                            title: "Deleted!",
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    });
});

