@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Categorys Management</h4>
                <h6>List Categories</h6>
            </div>
            @if(can_access('add_category'))
            <div class="page-btn">
                <a href="#" class="btn btn-added add_category"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-2">Add Category</a>
            </div>
            @endif
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset">
                                <img src="{{ asset('assets/img/icons/search-white.svg')}}" alt="img">
                            </a>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="{{ asset('assets/img/icons/pdf.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="{{ asset('assets/img/icons/excel.svg')}}" alt="img"></a>
                            </li>
                            <li>
                                <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="{{ asset('assets/img/icons/printer.svg')}}" alt="img"></a>
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
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$categories->isEmpty())
                            @foreach($categories as $key => $category)
                            <tr>
                                <td>{{ ++$key}} </td>

                                <td>{{ $category->name}}</td>
                                <td>{{ $category->description}}</td>
                                <td>
                                    @if(can_access('edit_category'))
                                    <a class="me-3 edit" id="{{$category->id }}" href="javascript:void(0);">
                                        <img src="{{ asset('assets/img/icons/edit.svg')}}" alt="img">
                                    </a>
                                    @endif
                                    @if(can_access('delete_category'))
                                    <a class="me-3 delete" id="{{$category->id }}" href="javascript:void(0);">
                                        <img src="{{ asset('assets/img/icons/delete.svg')}}" alt="img">
                                    </a>
                                    @endif
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

<!-- add category -->
<div class="modal fade" id="add_category" tabindex="-1" aria-labelledby="add_category" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="" method="post" enctype="" id="save_category">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                    <input type="hidden" name="category_id" class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Descriptions</label>
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-submit">Save</button>
                            <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@include('authentication.footer')
<script>
    $(document).on("click", ".delete", function() {
        var id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You want to delete this category!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonClass: "btn btn-danger",
            cancelButtonClass: "btn btn-secondary ml-1",
            buttonsStyling: false
        }).then(function(t) {
            if (t.value && t.dismiss !== "cancel") {
                $.ajax({
                    type: 'POST',
                    url: "{{url('deletecategory')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        category_id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: "Deleted!",
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                });
            }
        });
    });
    add_category = $('.add_category').on('click', function() {
        $('#add_category').modal('show');
    });
    $(document).ready(add_category);

    $(document).on("submit", "#save_category", function(e) {
        e.preventDefault();
        var data = $('#save_category').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('addcategory')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: response.type,
                    title: response.title,
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_category').modal('hide');
                    $('#save_category')[0].reset();
                    window.location.reload();
                });
            }
        });

    });


    // edit category 
    edit_category = $('.edit').on('click', function() {
        $('.modal-title').text('Edit category');
        $('.btn-submit').text('Update');
        $('#save_category').addClass('save_category');
        $('#save_category').removeAttr('id');
        var id =  $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: "{{url('fetchcategory')}}?id="+id,
            dataType: 'json',
            id: id,
            success: function(response) {
                $('input[name=category_id]').val(response.id);
                $('input[name=name]').val(response.name);
                $('input[name=description]').val(response.description);

            }
        });

        $('#add_category').modal('show');

    });
    $(document).ready(edit_category);



    $(document).on("submit", ".save_category", function(e) {
        e.preventDefault();
        var data = $('.save_category').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('updatecategory')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: response.type,
                    title: response.title,
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_category').modal('hide');
                    $('.save_category')[0].reset();
                    window.location.reload();
                });
            }
        });

    });
</script>