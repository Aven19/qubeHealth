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

   <?php @include('navbar.php') ?>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('<?= base_url('images/bg-01.jpg'); ?>');">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <div class="listErrors">
                </div>
                <span class="login100-form-title p-b-49">
                    Please upload a verification document.
                </span>

                <form method="post" id="upload_image_form" enctype="multipart/form-data">
                    <div id="alertMessage" class="alert alert-warning mb-3" style="display: none">
                        <span id="alertMsg"></span>
                    </div>
                    <div class="d-grid text-center">
                        <img class="mb-3" id="ajaxImgUpload" alt="Preview Image" src="https://via.placeholder.com/300" />
                    </div>
                    <div class="mb-3">
                        <input type="file" name="file" multiple="true" id="finput" onchange="onFileUpload(this);" class="form-control form-control-lg" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger uploadBtn">Upload</button>
                    </div>
                </form>

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
        function onFileUpload(input, id) {
            id = id || '#ajaxImgUpload';
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(id).attr('src', e.target.result).width(300)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            $('#upload_image_form').on('submit', function(e) {
                $('.uploadBtn').html('Uploading ...');
                $('.uploadBtn').prop('Disabled');
                e.preventDefault();
                if ($('#file').val() == '') {
                    alert("Choose File");
                    $('.uploadBtn').html('Upload');
                    $('.uploadBtn').prop('enabled');
                    document.getElementById("upload_image_form").reset();
                } else {
                    $.ajax({
                        url: "<?php echo base_url(); ?>/DocumentController/upload",
                        method: "POST",
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        success: function(res) {
                            console.log(res.success);
                            if (res.success == true) {
                                $('#ajaxImgUpload').attr('src', 'https://via.placeholder.com/300');
                                $('#alertMsg').html(res.msg);
                                $('#alertMessage').show();
                            } else if (res.success == false) {
                                $('#alertMsg').html(res.msg);
                                $('#alertMessage').show();
                            }
                            setTimeout(function() {
                                $('#alertMsg').html('');
                                $('#alertMessage').hide();
                            }, 4000);
                            $('.uploadBtn').html('Upload');
                            $('.uploadBtn').prop('Enabled');
                            document.getElementById("upload_image_form").reset();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>