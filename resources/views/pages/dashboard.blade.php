@extends('layouts.body')
@section('title', 'Dashboard')
@section('pageSpecificStyle')
@stop
@section('content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h2><i class="fas fa-users mr-2"></i>Characters</h2>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Saved Characters</h3>
              </div>

              <div class="card-body">
                <table class="table table-bordered" id="characterTable">
                  <thead>
                    <tr>
                      <td>ID</td>
                      <td>Name</td>
                      <td>Gender</td>
                      <td>Actions</td>
                    </tr>
                  </thead>
                  <tbody id="characterList">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="info-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Character information</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="info-card" class="card card-secondary card-outline">
                <div class="card-header">
                <input type="text" style="display:none" readonly id="url-id" />
                  <h4 class="text-muted text-center" id="input-id-text"><strong>Name: </strong> <span
                      class="small" id="character_name">{Sample Name}</span>
                  </h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <p class="mr-2">Height: <span class="text-muted" id="character-height">{Sample Height}</span></p>
                    </div>
                    <div class="col">
                      <p class="mr-2">Gender: <span class="text-muted" id="character-gender">{Sample Gender}</span></p>
                    </div>
                    <div class="col">
                      <p class="mr-2">Hair Color: <span class="text-muted" id="character-hair-color">{Sample Hair Color}</span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="closeBtn" class="btn btn-default" data-dismiss="modal">Close</button>
              <button id="saveBtn" type="button" class="btn btn-success"><i class="far fa-save mr-2"></i>Save Character</button>
              <button id="deleteBtn" type="button" class="btn btn-danger d-none">
                <i class="fas fa-trash mr-2"></i>Delete Character
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.modal-dialog -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('pagespecificscript')
<!-- Handles the dynamic input of data into the table -->
<script>
  $(document).ready(function () {
    const characterTable = $("#characterTable").DataTable({
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      pageLength: 10,
    });

    let isFirstFetch = true;

    function fetchAllCharacters(url = "https://swapi.dev/api/people/") {
      if (isFirstFetch) {
        Swal.fire({
          title: "Fetching Characters...",
          html: "Please wait...",
          allowOutsideClick: false,
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });
      }

      $.ajax({
        url,
        type: "GET",
        dataType: "json",
        success(data) {
          displayCharacters(data.results);

          if (isFirstFetch) {
            Swal.close();
            isFirstFetch = false;
          }

          if (data.next) {
            fetchAllCharacters(data.next);
          } else {
            Swal.fire({
              icon: "success",
              title: "Characters Loaded!",
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 4000,
              timerProgressBar: true,
            });
          }
        },
        error(xhr, status, error) {
          Swal.close();
          Swal.fire({
            icon: "error",
            title: "Error Fetching Data",
            text: "Something went wrong!",
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
          });
          console.error("Error fetching data:", error);
        },
      });
    }

    function displayCharacters(characters) {
      $.each(characters, (index, character) => {
        const row = `
          <tr>
            <td>${characterTable.rows().count() + 1}</td>
            <td>${character.name}</td>
            <td>${character.gender}</td>
            <td>
              <button
                type="button"
                id="view-btn"
                class="btn btn-primary btn-sm"
                data-url="${character.url}"
              >
                <i class="fas fa-info-circle mr-2"></i>View Full Information
              </button>
            </td>
          </tr>
        `;
        characterTable.row.add($(row)).draw();
      });
    }

    fetchAllCharacters();
  });
</script>

<!-- This is the character info modal -->
<script>
  $(document).ready(function () {
    // View button
    $(document).on('click', '#view-btn', function () {
      const url = $(this).data('url');

      Swal.fire({
        title: 'Fetching Character Info...',
        html: 'Please wait...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          Swal.close();

          $('#url-id').val(data.url);
          $('#character_name').text(data.name);
          $('#character-height').text(data.height);
          $('#character-gender').text(data.gender);
          $('#character-hair-color').text(data.hair_color);

          checkIfCharacterExists(data.url);

          $('#info-modal').modal('show');
        },
        error: function (xhr, status, error) {
          Swal.close();
          Swal.fire({
            icon: 'error',
            title: 'Error Fetching Data',
            text: 'Something went wrong while fetching character data!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
          });
          console.error('Error fetching data:', error);
        }
      });
    });

    function checkIfCharacterExists(characterUrl) {
      $.ajax({
        url: '/check-character',
        type: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          url: characterUrl
        },
        success: function (response) {
          if (response.exists) {
            $('#deleteBtn').removeClass('d-none');
            $('#saveBtn').addClass('d-none');
          } else {
            $('#saveBtn').removeClass('d-none');
            $('#deleteBtn').addClass('d-none');
          }
        },
        error: function () {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Something went wrong while checking character.'
          });
        }
      });
    }

    // Save button
    $(document).on('click', '#saveBtn', function () {
      const url = $('#url-id').val(); 
      const name = $('#character_name').text(); 
      const gender = $('#character-gender').text(); 
      const height = $('#character-height').text(); 
      const hairColor = $('#character-hair-color').text(); 

      Swal.fire({
        title: 'Saving Character...',
        text: 'Please wait while we save your character.',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: '/save-character', 
        method: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'), 
          character_url: url,
          character_name: name,
          character_gender: gender,
          character_height: height,
          character_hair_color: hairColor,
        },
        success: function (response) {
          Swal.close();

          Swal.fire({
              icon: 'success',
              title: 'Character Saved!',
              text: 'Character saved for later use',
              showConfirmButton: true, 
              confirmButtonText: 'OK', 
          });

          $('#info-modal').modal('hide');
        },
        error: function (xhr, status, error) {
          Swal.close();
          Swal.fire({
            icon: 'error',
            title: 'Error Saving Character',
            text: 'Something went wrong! Please try again.',
            showConfirmButton: true,
          });
        }
      });
    });

    // Delete button
    $('#deleteBtn').on('click', function() {
      var characterUrl = $('#url-id').val();

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '/delete-character',
            method: 'POST',
            data: {
              _token: $('meta[name="csrf-token"]').attr('content'),
              character_url: characterUrl,
            },
            success: function(response) {
              if (response.success) {
                Swal.fire({
                  icon: 'success',
                  title: 'Character Deleted!',
                  text: 'Character deleted from the list',
                  showConfirmButton: true,
                }).then((result) => {
                  if (result.isConfirmed) {
                    $('#info-modal').modal('hide');
                  }
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error Deleting Character',
                  text: 'Something went wrong! Please try again.',
                  showConfirmButton: true,
                });
              }
            },
            error: function(xhr, status, error) {
              Swal.fire({
                icon: 'error',
                title: 'Error Deleting Character',
                text: 'Something went wrong! Please try again.' + error.message,
                showConfirmButton: true,
              });
            }
          });
        }
      });
    });
  });
</script>
@endsection