@include('authentication.header')

@include('admin.top_bar')

@include('admin.sidebar')

<!-- page content -->
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
            <h4>Deleted Items</h4>
                <h6>Restore/Delete all deleted items</h6>
            </div>
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
                       
                    </div>
                </div>

                <div class="table-responsive">
                    <!-- <table class="table  datanew">
                        <thead>
                            <tr class="text-center">
                               

                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr class="text-center">
                                
                            </tr>
                           
                        </tbody>
                    </table> -->
                </div>
            </div>
        </div>

    </div>
</div>
<!-- page content end -->

@include('authentication.footer')