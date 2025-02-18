@extends('layouts.body')

@section('title', 'Email Verification')

@section('content')
<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                title: 'Email Verification Required!',
                text: 'Please check your email and click the verification link before continuing.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        });
    </script>

    <script>
        document.getElementById("resendVerification").addEventListener("click", function() {
            fetch("{{ route('verification.send') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                });
            })
            .catch(error => {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to resend verification email.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        });
    </script>
@endsection