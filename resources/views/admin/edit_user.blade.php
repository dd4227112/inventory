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
        <form action=" {{ route('admin.update_user') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" name="email">
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Role</label>
                                <select class="select" name="role_id">
                                    <option>--Select--</option>
                                    @if(!$roles->isEmpty())
                                    @foreach($roles as $role)
                                    <option <?= $role->id == $user->role_id ? 'selected' : '' ?> value="{{ $role->id}}"> {{ $role->name }}</option>
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
                                    <option <?= $shop->id == $user->shop_id ? 'selected' : '' ?> value="{{ $shop->id}}"> {{ $shop->name}}</option>
                                    @endforeach
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label> User Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="photo">
                                        <div class="image-uploads">
                                            <img src="{{ asset('assets/img/icons/upload.svg')}}" alt="img">
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label> Current Image</label>
                                    <div class="image-uploads">
                                        <img src="{{ asset('uploads/profiles/'.$user->photo)}}" width="40%" height="40%" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-submit me-2">Save</button>
                            <a href="{{ route('admin.list_user')}}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- page content end -->

@include('authentication.footer')