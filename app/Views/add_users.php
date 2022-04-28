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
    <?php @include('admin_navbar.php') ?>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?= base_url('images/bg-01.jpg'); ?>');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <div class="listErrors">
                </div>
                <span class="login100-form-title p-b-49">
                    ADD USERS
                </span>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Phone no is reauired">
                    <span class="label-input100">Name</span>
                    <input class="input100" type="text" name="name" value="<?= set_value('name') ?>" placeholder="Add Name" autocomplete="off" maxlength="25">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Phone no is reauired">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" name="email" value="<?= set_value('email') ?>" placeholder="Add Email" autocomplete="off">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Phone no is reauired">
                    <span class="label-input100">Phone number</span>
                    <input class="input100" type="text" name="phone" value="<?= set_value('phone') ?>" placeholder="Add phone number" autocomplete="off" maxlength="10">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" id="saveDetails">
                            Save details
                        </button>
                    </div>
                </div>

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
            $("#saveDetails").click(function() {
                $.ajax({
                    // type: "POST",
                    method: 'post',
                    url: "<?= base_url() ?>/UserController/storeUser",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        name: $("input[name='name']").val(),
                        email: $("input[name='email']").val(),
                        phone: $("input[name='phone']").val(),
                    },
                    success: function(data) {
                        let response = JSON.parse(data);
                        if (response.data.success == 200) {
                            window.location.href = '/users/list-view';
                        } else {
                            let arr = [];
                            let objKeys = response.data.message;
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

        });
    </script>
</body>

</html>