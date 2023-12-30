$(document).ready(function () {
    getTotalItems();
    grand_sub_total();
    calculteTotalAmount();

});
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
    const payment_amount = document.getElementById("payment_amount");
    const grand_sub = document.getElementById("grand_sub");
    var inputs = document.querySelectorAll("#sub_total");
    var amount = 0
    for (let i = 0; i < inputs.length; i++) {
        amount += parseFloat(inputs[i].value);
    }

    var amount = amount.toLocaleString("en-US");
    return grand_total.innerHTML = amount, grand_sub.value = amount, payment_amount.value = amount;
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
        url: 'getpayment',
        dataType:'json',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            uuid: uuid
        },
        success: function (response) {
            $('#purchase_amount').val(response.balance);
            $('#amount').val(response.balance);
            $('#supplier').val(response.supplier);
            $('#purchase_id').val(response.purchase_id);
            $('#createpayment').modal('show');
        },
        error: function (error) {
            console.log(error);
        }
    });

});
$(document).ready(add_payment);