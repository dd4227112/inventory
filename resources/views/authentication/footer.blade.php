</div>
<script src="{{ asset('/assets/js/jquery-3.6.0.min.js')}}"></script>

<script src="{{ asset('/assets/js/feather.min.js')}}"></script>

<script src="{{ asset('/assets/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{ asset('/assets/js/jquery.slimscroll.min.js')}}"></script>

<script src="{{ asset('/assets/js/jquery.dataTables.min.js')}}"></script>

<script src="{{ asset('/assets/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/apexchart/apexcharts.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/apexchart/chart-data.js')}}"></script>

<script src="{{ asset('/assets/plugins/toastr/toastr.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/select2/js/select2.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/select2/js/custom-select.js')}}"></script>

<script src="{{ asset('/assets/js/moment.min.js')}}"></script>

<script src="{{ asset('/assets/js/bootstrap-datetimepicker.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>

<script src="{{ asset('/assets/js/script.js')}}"></script>
<script src="{{ asset('/assets/js/project.js')}}"></script>



@if (session()->has('success'))
<script>
    $(document).ready(function() {
            toastr.success("{{ session('success') }}", "Success", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0,
                
            })
    });
</script>
@endif

@if (session()->has('warning'))
<script>
    $(document).ready(function() {
        toastr.warning("{{ session('warning') }}",  "Warning", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0,
                
            })
    });
</script>
@endif

@if (session()->has('error'))
<script>
    $(document).ready(function() {
        toastr.error("{{ session('error') }}", "Error", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0,
                
            })
    });
</script>
@endif

@isset($message)
@if ($message['status'] == 'success')
<script>
    $(document).ready(function() {
        toastr.success("{{ $message['message']}}", "Success", {
                closeButton: !0,
                tapToDismiss: !1,
                progressBar: !0,
                
            })
    });
</script>
@endif
@endisset

</body>

</html>