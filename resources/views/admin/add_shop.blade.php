@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>shop Management</h4>
                <h6>Add shop</h6>
            </div>
        </div>
        <form action=" {{ route('admin.store_shop') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" required class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" required class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-12">
                            <div class="form-group">
                                <label>Location</label>
                                <input type="text" class="form-control"  required name="location">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <div class="pass-group">
                                    <textarea name="description" rows="3"></textarea>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="{{ route('admin.list_shop')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')