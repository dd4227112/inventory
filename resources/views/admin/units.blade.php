@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Units Management</h4>
                <h6>List Units</h6>
            </div>
            @if(can_access('add_unit'))
            <div class="page-btn">
                <a href="#" class="btn btn-added add_unit"><img src="{{ asset('assets/img/icons/plus.svg')}}" alt="img" class="me-2">Add Unit</a>
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
            <tbody id="content">
            </tbody>
            </table>
    </div>
</div>

        </div>

    </div>
</div>

<!-- page content end -->

<!-- add unit -->
<div class="modal fade" id="add_unit" tabindex="-1" aria-labelledby="add_unit" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Unit</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="" method="post" enctype="" id="save_unit">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control">
                                    <input type="hidden" name="unit_id" class="form-control">

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
            text: "You want to delete this units!",
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
                    url: "{{url('deleteunit')}}",
                    dataType: 'json',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        unit_id: id
                    },
                    success: function(response) {
                        Swal.fire({
                            type: "success",
                            title: response.title,
                            text: response.message,
                            confirmButtonClass: "btn btn-success"
                        }).then(function() {
                            getUnits();
                        });
                    }
                });
            }
        });
    });
    add_unit = $('.add_unit').on('click', function() {
        $('#add_unit').modal('show');
    });
    $(document).ready(add_unit);

    $(document).on("submit", "#save_unit", function(e) {
        e.preventDefault();
        var data = $('#save_unit').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('addunit')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: response.type,
                    title: response.title,
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_unit').modal('hide');
                    $('#save_unit')[0].reset();
                    getUnits();
                });
            }
        });

    });


    // edit unit 
        $(document).on("click", ".edit", function() {
        $('.modal-title').text('Edit Unit');
        $('.btn-submit').text('Update');
        $('#save_unit').addClass('save_unit');
        $('#save_unit').removeAttr('id');
        var id = $(this).attr('id');
        $.ajax({
            type: 'GET',
            url: "{{url('fetchunit')}}?id=" + id,
            dataType: 'json',
            id: id,
            success: function(response) {
                $('input[name=unit_id]').val(response.id);
                $('input[name=name]').val(response.name);
                $('input[name=description]').val(response.description);

            }
        });

        $('#add_unit').modal('show');

    });

    $(document).on("submit", ".save_unit", function(e) {
        e.preventDefault();
        var data = $('.save_unit').serialize();
        $.ajax({
            type: 'POST',
            url: "{{url('updateunit')}}",
            dataType: 'json',
            data: data,
            success: function(response) {
                Swal.fire({
                    type: response.type,
                    title: response.title,
                    text: response.message,
                    confirmButtonClass: "btn btn-success"
                }).then(function() {
                    $('#add_unit').modal('hide');
                    $('.save_unit')[0].reset();
                    getUnits();
                });
            }
        });
    });
    $(document).ready(getUnits());

    function getUnits() {
        $.ajax({
            type: 'GET',
            url: "{{url('get_units')}}",
            dataType: 'html',
            success: function(response) {
                $('#content').html(response);
            }
        });
    }
</script>