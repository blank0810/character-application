<!DOCTYPE html>
<html lang="en">
  @extends('layouts.header')
  @section('title', 'Register')
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Register Here!</p>

          <form action="/register" method="post" id="registerForm">
            <div class="input-group mb-3">
              <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <button type="button" id="registerBtn" class="btn btn-primary btn-block">Sign Up</button>
              </div>
            </div>
          </form>

          <br>
          <p class="mb-0">
            <a href="/" class="text-center">Already a member? Sign in</a>
          </p>
        </div>
      </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
      $(document).ready(function () {
        $('#registerBtn').on('click', function (e) {
          Swal.fire({
            icon: 'question',
            title: 'Confirm registration',
            text: 'Do you wish to register?',
            showCancelButton: true,
            confirmButtonText: '<i class="far fa-check-circle"></i> Yes',
            cancelButtonText: '<i class="far fa-times-circle"></i> Cancel',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Registering...',
                html: 'Please wait...',
                timerProgressBar: true,
                didOpen: () => {
                  Swal.showLoading();
                }
              });
              registerUser();
            }
          })
        })
      })

      function registerUser() {
        var form = $('#registerForm');
        var formData = form.serialize();

        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/register',
          type: 'post',
          data: formData,
          success: function (response) {
            if (response.success) {
              Swal.close();
              swal.fire({
                icon: 'success',
                title: 'Registration Success',
                text: response.message,
                confirmButtonText: '<i class="far fa-check-circle"></i> Yes',
                confirmButtonColor: '#28a745',
              }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = "/login"; 
                }
              })
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred: ' + response.message,
              });
            }
          },
          error: function (xhr) {
            console.log('An error occurred: ' + xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'An error occurred: ' + xhr.responseText,
            });
          }
        });
      }
    </script>
  </body>
</html>