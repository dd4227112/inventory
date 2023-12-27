@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Profile</h4>
                <h6>Change Password</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.changepassword')}}" method="POST">
                        @csrf
                <div class="row">
                   
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label> Current Password</label>
                                <input type="password" required name="current_password"  placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>New  Password</label>
                                <input type="password" required max="5" name="new_password"  placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" required max="5" name="confirm_password"  placeholder="">
                            </div>
                        </div>
                        <div class="col-12">
                            <button href="javascript:void(0);" class="btn btn-submit me-2">Change Password</button>
                        </div>
                   
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- page content end -->

@include('authentication.footer')