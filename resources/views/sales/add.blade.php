@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')
<!-- page start -->
<style>
    .pick_product {
        cursor: pointer;

    }

    input[type="number"] {
        border: none;
        background-color: inherit;
    }
</style>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4> Sale Management</h4>
                <h6>Add sale</h6>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Customer</label>
                            <div class="row">
                                <div class="col-lg-10 col-sm-10 col-10">
                                    <select class="select2" id="getCustomer" required>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                    <div class="add-icon">
                                        <span><img src="assets/img/icons/plus1.svg" alt="img"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Date</label>
                            <div class="input-groupicon">
                                <input type="date" class="form-control" value="{{ date('Y-m-d')}}" name="date">
                                <!-- <div class="addonset">
                                    <img src="assets/img/icons/calendars.svg" alt="img">
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label>Reference/Invoice No.</label>
                            <input type="text" name="reference" value="{{ reference() }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label>Search Product</label>
                            <div class="input-groupicon">
                                <input type="text" placeholder="Please type product name or code and select..." id="serchProduct" name="searchProduct">
                                <div class="addonset">
                                    <img src="assets/img/icons/scanner.svg" alt="img">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6col-sm-6 col-6" id="searchResult">

                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>QTY</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="selectedProduct">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="row"  style="border: 1px solid #ff9f43; margin-left: 1px; margin-bottom: 5px;">
                        <div class="col-lg-6 ">
                            <div class="total-order w-100 max-widthauto m-auto mb-4">

                            </div>
                        </div>
                        <div class="col-lg-6 ">
                            <div class="total-order w-100 max-widthauto m-auto mb-4">
                                <ul>
                                    <li>
                                        <h4>Quantity</h4>
                                        <h5>0.00</h5>
                                    </li>
                                    <li>
                                        <h4>Sub Total</h4>
                                        <h5>$ 0.00</h5>
                                    </li>
                                    <li class="total">
                                        <h4>Grand Total</h4>
                                        <h5>$ 1750.00</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 align-right">
                        <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page end -->

@include('authentication.footer')