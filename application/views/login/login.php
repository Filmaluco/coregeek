<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CoreGeek - Login</title>


    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url(); ?>/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo assets_url(); ?>/js/main/jquery.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo assets_url(); ?>/js/plugins/forms/styling/uniform.min.js"></script>

    <script src="<?php echo assets_url(); ?>/js/app.js"></script>
    <script src="<?php echo assets_url(); ?>/js/demo_pages/login.js"></script>
    <!-- /theme JS files -->

</head>
<body class="bg-slate-800">

<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">

            <!-- Login card -->
                <?php echo form_open('login/login', 'class="login-form"');?>
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="icon-people icon-2x text-warning-400 border-warning-400 border-3 rounded-round p-3 mb-3 mt-1"></i>
                            <h5 class="mb-0">Login to your account</h5>
                            <span class="d-block text-muted">Your credentials</span>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="text" class="form-control" placeholder="Username">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input type="password" class="form-control" placeholder="Password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <div class="form-check mb-0">
                                <label class="form-check-label">
                                    <input type="checkbox" name="remember" class="form-input-styled" checked data-fouc>
                                    Remember me
                                </label>
                            </div>


                        </div>

                        <div class="form-group">
                            <button type="submit" value="login" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                        </div>


                        <span class="form-text text-center text-muted">By continuing, you're confirming that you've read our Terms &amp; Conditions and <a href="#">Cookie Policy</a></span>
                    </div>
                </div>
            <?php echo form_close();?>
            <!-- /login card -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>