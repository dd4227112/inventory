@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>User Management</h4>
                <h6>Edit User</h6>
            </div>
        </div>
        <form action=" {{ route('updateProduct') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" value="{{ $product->code }}" required class="form-control">
                                <input type="hidden" name="product_id" value="{{ $product->id }}" required>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $product->name }}" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" value="{{ $product->description }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" class="form-control" value="{{ $product->quantity }}" required name="quantity">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Cost</label>
                                <input type="text" class="form-control" value="{{ $product->cost }}" required name="cost">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control" value="{{ $product->price }}" required name="price">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="select" name="unit_id" required>
                                    <option>--Select--</option>
                                    @if(!$units->isEmpty())
                                    @foreach($units as $unit)
                                    <option <?= $product->unit_id == $unit->id ? 'selected' : '' ?> value="{{ $unit->id}}"> {{ $unit->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select" name="category_id" required>
                                    <option>--Select--</option>
                                    @if(!$categories->isEmpty())
                                    @foreach($categories as $category)
                                    <option <?= $product->category_id == $category->id ? 'selected' : '' ?> value="{{ $category->id}}"> {{ $category->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Shop</label>
                                <select class="select" name="shop_id">
                                    <option>--Select--</option>
                                    @if(!$shops->isEmpty())
                                    @foreach($shops as $shop)
                                    <option <?= $product->shop_id == $shop->id ? 'selected' : '' ?> value="{{ $shop->id}}"> {{ $shop->name}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Update</button>
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