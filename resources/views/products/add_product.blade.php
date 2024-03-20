@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Product Management</h4>
                <h6>Add Product</h6>
            </div>
        </div>
        <form action=" {{ route('store_product') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number"  class="form-control" required name="quantity">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="number"  class="form-control" required name="cost">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number"  class="form-control" required name="price">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="select2" name="unit_id" required>
                                    <option>--Select--</option>
                                    @if(!$units->isEmpty())
                                    @foreach($units as $unit)
                                    <option value="{{ $unit->id}}"> {{ $unit->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select2" name="category_id" required>
                                    <option>--Select--</option>
                                    @if(!$categories->isEmpty())
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id}}"> {{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Shop</label>
                                <select class="select2" name="shop_id">
                                        <option>--Select--</option>
                                        @if(!$shops->isEmpty())
                                        @foreach($shops as $shop)
                                        <option value="{{ $shop->id}}"> {{ $shop->name}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="{{ route('list_product')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')