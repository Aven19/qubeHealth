<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login V4</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="<?= base_url('images/icons/favicon.ico'); ?>" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('fonts/iconic/css/material-design-iconic-font.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/animate/animate.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/css-hamburgers/hamburgers.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/animsition/css/animsition.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/select2/select2.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('vendor/daterangepicker/daterangepicker.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/util.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/main.css'); ?>">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?= base_url('images/bg-01.jpg'); ?>');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <?php if (isset($validation)) : ?>
                    <div class="alert alert-danger">
                        <?= $validation->listErrors() ?>
                    </div>
                <?php endif; ?>
                <div class="listErrors">
                </div>
                <span class="login100-form-title p-b-49">
                    Login
                </span>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Phone no is required">
                    <span class="label-input100">Phone number</span>
                    <input class="input100" type="text" name="phone" value="<?= set_value('phone') ?>" placeholder="Type your phone number" autocomplete="off" maxlength="10">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="User type is required">
                    <select class="input100" aria-label="" name="userType" required id="userType">
                        <option value="" selected>Select user type</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <div class="wrap-input100 validate-input m-b-23 otp-div" data-validate="Otp is reauired" id="" style="display: none;">
                    <span class="label-input100">One time password</span>
                    <input class="input100" type="text" name="otp" value="<?= set_value('otp') ?>" placeholder="Enter your OTP" autocomplete="off" maxlength="4">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="container-login100-form-btn otp-div" style="display: none;">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" id="verifyOtp">
                            VERIFY OTP
                        </button>
                    </div>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" id="postLogin">
                            Login
                        </button>
                    </div>
                </div>

                <!-- <div class="flex-col-c p-t-10">
                        <span class="txt1 p-b-17">
                            Or Sign Up Using
                        </span>

                        <a href="#" class="txt2">
                            Sign Up
                        </a>
                    </div> -->
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/jquery/jquery-3.2.1.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/animsition/js/animsition.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/bootstrap/js/popper.js'); ?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/select2/select2.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/daterangepicker/moment.min.js'); ?>"></script>
    <script src="<?= base_url('vendor/daterangepicker/daterangepicker.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('vendor/countdowntime/countdowntime.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?= base_url('js/main.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $(".otp-div").hide();
            $("#postLogin").click(function() {
                $.ajax({
                    // type: "POST",
                    method: 'post',
                    url: "<?= base_url() ?>/SignupController/verifyUser",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        phone: $("input[name='phone']").val(),
                        userType: $("#userType option:selected").val()
                    },
                    success: function(data) {
                        let response = JSON.parse(data);
                        if (response.data.success == 200) {
                            $("#postLogin").hide();
                            $(".otp-div").show();
                        }else {
                            let arr = [];
                            let objKeys = response.data.message;
                            console.log(objKeys);
                            for (var key of Object.keys(objKeys)) {
                                arr = objKeys[key];
                            }
                            $(".listErrors").append("<div class='alert alert-danger listErrors'>" + arr + "</div>");
                            setTimeout(function() {
                                $(".listErrors").empty();
                            }, 5000);
                        }
                    }
                });
            });

            $("#verifyOtp").click(function() {
                $.ajax({
                    // type: "POST",
                    method: 'post',
                    url: "<?= base_url() ?>/SignupController/verifyOtp",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        phone: $("input[name='phone']").val(),
                        otp: $("input[name='otp']").val()
                    },
                    success: function(data) {
                        let response = JSON.parse(data);
                        if (response.data.success == 200) {
                            window.location.href = '/users/list-view';
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>