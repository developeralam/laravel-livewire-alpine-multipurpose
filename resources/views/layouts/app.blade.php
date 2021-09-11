<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Laravel Livewire Multipurpose Admin Panel @yield('title')</title>

        <!-- Google Font: Source Sans Pro -->
        <link
            rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        />
        <!-- Font Awesome Icons -->
        <link
            rel="stylesheet"
            href="{{
                asset('backend/plugins/fontawesome-free/css/all.min.css')
            }}"
        />
        <link rel="stylesheet" href="{{asset('backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')
                        }}">
        <!-- Theme style -->
        <link
            rel="stylesheet"
            href="{{ asset('backend/dist/css/adminlte.min.css') }}"
        />
        
        {{-- Toastr --}}
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
            integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        @livewireStyles
    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <div class="dj"></div>
            <!-- Navbar -->
            @include('layouts.partials.navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts.partials.aside')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                {{ $slot }}
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            @include('layouts.partials.footer')
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->

        <!-- jQuery -->
        <script src="{{
                asset('backend/plugins/jquery/jquery.min.js')
            }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{
                asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')
            }}"></script>
            <!-- Moment js -->
            <script src="{{
                                        asset('backend/plugins/moment/moment.min.js')
                                    }}"></script>
            <!-- Date Time picker 4 -->
            <script src="{{asset('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')
                        }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
        {{-- Toastr --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js
"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"
    integrity="sha512-2RLMQRNr+D47nbLnsbEqtEmgKy67OSCpWJjJM394czt99xj3jJJJBQ43K7lJpfYAYtvekeyzqfZTx2mqoDh7vg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    console.log($("#test").val());
</script>
    <script>
        $(document).ready(function () {
            //Show Form
            window.addEventListener("show-form", (event) => {
                $("#" + event.detail.id).modal("show");
            });
            //Close form
            window.addEventListener("close-form", (event) => {
                $("#" + event.detail.id).modal("hide");
            });
            
            //Toastr
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
            };
            //Success Message
            window.addEventListener("success-msg", (event) => {
                toastr.success(event.detail.msg, "Success!");
            });
            
            
            // Tempusdominus
            $('#datetimepicker4').datetimepicker({
                format: 'L'
            });
            
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
            
            //setup date time picker
            $("#datetimepicker4").on("change.datetimepicker", function(e){
                let date = $(this).data('appointmentdate');
                eval(date).set('state.date', $('#appointmentDateInput').val());
            });
            $('#datetimepicker3').on("change.datetimepicker", function(e){
                let time = $(this).data('appointmenttime');
                eval(time).set('state.time', $('#appointmentTimeInput').val());
            });

        });
        </script>
        @livewireScripts
</body>
</html>
