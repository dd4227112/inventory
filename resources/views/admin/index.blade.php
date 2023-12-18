@include('authentication.header')

@include('admin.top_bar')

<!-- @include('admin.sidebar') -->

<!-- page content -->
<div class="page-wrapper cardhead">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col">
                    <h3 class="page-title">Shops</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Select Shops</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{route('admin.home')}}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Select</label>
                                <div class="col-md-10">
                                    <select class="form-select" name="id">
                                        <option value="">-- Select --</option>
                                        @if(!$shops->isEmpty())
                                        @foreach($shops as $shop)
                                        <option value="{{ $shop->id}}">{{ $shop->name}} - {{ $shop->location }}</option>
                                        @endforeach
                                        @else
                                        <option value="">No data found..</option>
                                        @endif
                                       
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-0 row"> 
                                <div class="col-md-10">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-primary" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- page content end -->

@include('authentication.footer')