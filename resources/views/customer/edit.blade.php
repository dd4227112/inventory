@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Customer Management</h4>
                <h6>Edit Customer</h6>
            </div>
        </div>
        <form action=" {{ route('update_customer') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{$customer->name }}" class="form-control">
                                <input type="hidden" name="customer_id" value="{{$customer->id }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="{{$customer->phone }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{$customer->email }}">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Address</label>
                                <div class="pass-group">
                                    <input type="text" name="address" value="{{$customer->address }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Shop</label>
                                <select class="select" name="shop_id">
                                    <option>--Select--</option>
                                    @if(!$shops->isEmpty())
                                    @foreach($shops as $shop)
                                    <option <?= $shop->id == $customer->shop_id ? 'selected' : '' ?> value="{{ $shop->id}}"> {{ $shop->name}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
                            <a href="{{ route('list_customer')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')