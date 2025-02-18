<!DOCTYPE html>
<html lang="en">
  @include('layouts.header')
  <body class="hold-transition layout-top-nav">
    <div class="wrapper">
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <a href="/characters" class="navbar-brand">
          <img src="{{ asset('images/logo.svg') }}" class="img-fluid" style="width: 150px; height: 50px; margin: auto">
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="btn btn-outline-primary mr-2" href="/characters"><i class="fas fa-list mr-2"></i>List of Characters</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-success mr-2" href="/users/characters"><i class="far fa-save mr-2"></i>Saved Characters</a>
            </li>
            
            <!-- Logout Button -->
            <li class="nav-item">
              <button id="logoutBtn" class="btn btn-outline-danger">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
      @yield('content')
      @include('layouts.footer')
      <!-- jQuery -->
      <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
      <!-- Select2 -->
      <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
      <!-- Bootstrap4 Duallistbox -->
      <script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
      <!-- InputMask -->
      <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
      <!-- date-range-picker -->
      <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
      <!-- Tempusdominus Bootstrap 4 -->
      <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
      <!-- SweetAlert2 -->
      <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
      <!-- DataTables  & Plugins -->
      <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
      <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
      <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
      <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
      <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
      <script>
        $(document).on('click', '#logoutBtn', function() {
          Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, log out!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url: '{{ route("logout") }}',
                type: 'POST',
                data: {
                  _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                  Swal.fire({
                    icon: 'success',
                    title: 'Logged Out!',
                    text: 'You have been logged out successfully.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                  }).then(() => {
                    window.location.reload();
                  });
                },
                error: function(xhr, status, error) {
                  Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong while logging out!',
                    showConfirmButton: true,
                  });
                }
              });
            }
          });
        });
      </script>
      @yield('pagespecificscript')
    </div>
  </body>