<!DOCTYPE html>
<html lang="en" class="h-100" id="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Spyglass K Web</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url() ?>assets/images/favicon.png">
    <!-- Custom Stylesheet -->
    <link href="<?= base_url() ?>main/css/style.css" rel="stylesheet">

</head>

<body class="h-100" background="<?= base_url() ?>public/assets/images/landing-page.jpg">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div class="login-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content login-form">
                        <?php
                        $message = $this->session->flashdata('message');
                        if ($message) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                </button>
                                <strong>
                                    <i class="ace-icon fa fa-user-times"></i>
                                </strong>
                                <?php echo $message ?>
                            </div>
                        <?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="text-center mt-4">Spyglass K Web</h2>
                                <div class="logo text-center">
                                    <img src="<?= base_url() ?>public/assets/images/f-logo-koopsus.png" width="100" alt="">
                                </div>
                                <h4 class="text-center mt-4">Log into Your Account</h4>
                                <form class="mt-5 mb-5" action="<?= base_url() ?>login/login_action" method="POST">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="username" class="form-control" placeholder="Masukkan Username" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" placeholder="Masukkan Password" name="password" required>
                                    </div>
                                    <!-- <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <div class="form-check p-l-0">
                                                <input class="form-check-input" type="checkbox" id="basic_checkbox_1">
                                                <label class="form-check-label ml-3" for="basic_checkbox_1">Check me out</label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 text-right"><a href="javascript:void()">Forgot Password?</a>
                                        </div>
                                    </div> -->
                                    <div class="text-center mb-4 mt-4">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
                                    </div>
                                </form>
                                <!-- <div class="text-center">
                                    <h5 class="mb-5">Or with Login</h5>
                                    <ul class="list-inline">
                                        <li class="list-inline-item m-t-10"><a href="javascript:void()" class="btn btn-facebook"><i class="fa fa-facebook"></i></a>
                                        </li>
                                        <li class="list-inline-item m-t-10"><a href="javascript:void()" class="btn btn-twitter"><i class="fa fa-twitter"></i></a>
                                        </li>
                                        <li class="list-inline-item m-t-10"><a href="javascript:void()" class="btn btn-linkedin"><i class="fa fa-linkedin"></i></a>
                                        </li>
                                        <li class="list-inline-item m-t-10"><a href="javascript:void()" class="btn btn-google-plus"><i class="fa fa-google-plus"></i></a>
                                        </li>
                                    </ul>
                                    <p class="mt-5">Dont have an account? <a href="javascript:void()">Register Now</a>
                                    </p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->
    <!-- Common JS -->
    <script src="<?= base_url() ?>main/common/common.min.js"></script>
    <script src="<?= base_url() ?>main/js/custom.min.js"></script>
    <script src="<?= base_url() ?>main/js/settings.js"></script>
    <script src="<?= base_url() ?>main/js/gleek.js"></script>
</body>

</html>