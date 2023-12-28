<!doctype html>
<html lang="en">
<head> 
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('backend.includes.favicon')
    @include('backend.includes.css')
    <title>Sign in</title>
</head>

<body class="bg-login">
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="mb-4 text-center">
                        <img src="{{asset('backend_assets')}}/images/logo-img.png" width="180" alt="" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                
  
                                <div class="form-body" id="normalform">
                                    <form id="login_form" class="row g-3" method="POST" action="{{ route('code-verfication') }}">
                                        @csrf

                                        <div class="col-sm-12">
                                            <label for="inputUserName" class="form-label">Verfication Code Sent to ({{$phone_number}}) in 
                                            <span id="countdown"></span>
                                            </label>
                                            <input name="otp" type="text" class="form-control" id="otp" autofocus>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary"><i class="bx bxs-lock-open"></i>verify</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
@include('backend.includes.js')

<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>
<script>
    // Set the countdown duration in seconds
    var duration = 60;

    // Get the countdown element
    var countdownElement = document.getElementById('countdown');

    // Update the countdown every second
    var countdownInterval = setInterval(function() {
        // Calculate the minutes and seconds
        var minutes = Math.floor(duration / 60);
        var seconds = duration % 60;

        // Format the minutes and seconds as two digits
        var formattedMinutes = minutes.toString().padStart(2, '0');
        var formattedSeconds = seconds.toString().padStart(2, '0');

        // Update the countdown element
        countdownElement.textContent = formattedMinutes + ':' + formattedSeconds;

        // Decrease the duration by one second
        duration--;

        // Stop the countdown if the duration reaches zero
        if (duration < 0) {
            clearInterval(countdownInterval);
            countdownElement.textContent = '00:00'; // Optional: Show a different message when the countdown ends
        }
    }, 1000); // 1000 milliseconds = 1 second
</script>
</body>

</html>
