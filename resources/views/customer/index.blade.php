@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
            <h4>Customer Management</h4>
                <h6>List Customers</h6>
            </div>
            <div class="page-btn">
                <a href="{{route('add_customer')}}" class="btn btn-added"><img src="assets/img/icons/plus.svg" alt="img" class="me-2">Add Customer</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="assets/img/icons/printer.svg" alt="img"></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table  datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name </th>
                                <th>Phone</th>
                                <th>email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$customers->isEmpty())
                            @foreach($customers as $key => $customer)
                            <tr>
                                <td>{{ ++$key}} </td>
                                <td>{{ $customer->name}}</td>
                                <td>{{ $customer->phone}}</td>
                                <td>{{ $customer->email}}</td>
                                <td>{{ $customer->address}}</td>
                                <td>
                                    <a class="me-3" href="editcustomer.html">
                                        <img src="assets/img/icons/edit.svg"   alt="img">
                                    </a>
                                    <a class="me-3 confirm-text" id= "{{$customer->id }}" href="javascript:void(0);">
                                        <img src="assets/img/icons/delete.svg" alt="img">
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')