@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Profile</h4>
                <h6>User Profile</h6>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="profile-set">
                    <div class="profile-head">
                    </div>
                    <form action="{{route('update_photo')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="profile-top">
                            <div class="profile-content">
                                <div class="profile-contentimg">
                                    <img src="{{ asset('uploads/profiles/'.Auth::user()->photo) }}" alt="img" id="blah">
                                    <div class="profileupload">
                                        <input type="file" name="photo" id="imgInp">
                                        <a href="javascript:void(0);"><img src="assets/img/icons/edit-set.svg" alt="img"></a>
                                    </div>
                                </div>
                                <div class="profile-contentname">
                                    <h2>{{ Auth::user()->name }}</h2>
                                    <h4>Updates Your Photo and Personal Details.</h4>
                                </div>
                            </div>
                            <div class="ms-auto">
                                <button type="submit" class="btn btn-submit me-2">Update Photo</button>

                            </div>
                        </div>
                </div>
                </form>
                <form action="{{route('update_profile')}}" method="POST">
                        @csrf
                <div class="row">
                   
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label> Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="email">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="+2557123456789">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Shop</label>
                                <input type="text" readonly value=" <?= isset(Auth::user()->shop) ? Auth::user()->shop->name : '' ?>" placeholder="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label>Role</label>
                                <div class="pass-group">
                                    <input type="text" readonly value="{{ Auth::user()->role->name }}">

                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button href="javascript:void(0);" class="btn btn-submit me-2">Update Profile</button>
                        </div>
                   
                </div>
                </form>
            </div>
        </div>

    </div>
</div>
<!-- page content end -->

@include('authentication.footer')