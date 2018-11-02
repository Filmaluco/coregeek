<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/bootstrap_limitless.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/components.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo assets_url()?>/css/colors.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="<?php echo assets_url()?>/js/main/jquery.min.js"></script>
    <script src="<?php echo assets_url()?>/js/main/bootstrap.bundle.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/loaders/blockui.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="<?php echo assets_url()?>/js/app.js"></script>
    <!-- /theme JS files -->

    <script src="<?php echo assets_url(); ?>/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/demo_pages/login.js"></script>

</head>

<body>

<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="<?php echo site_url('r/home');?>" class="d-inline-block">
            <img src="<?php echo assets_url()?>/images/banner-logo.png" alt="">
        </a>
    </div>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">

            <!-- Unlock form -->

            <?php
            $hidden = array('username' => $username);
            echo form_open('login/login', 'class="login-form"', $hidden);?>
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center">
                            <div class="card-img-actions d-inline-block mb-3">
                                <img class="rounded-circle" src="<?php echo assets_url()?>/images/avatar-logo.jpg" width="160" height="160" alt="">
                                <div class="card-img-actions-overlay card-img rounded-circle">
                                    <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round">
                                        <i class="icon-question7"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <h6 class="font-weight-semibold mb-0"><?php echo $username?></h6>
                            <span class="d-block text-muted">A sua conta foi bloqueada por inatividade</span>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-right">
                            <?php echo form_password([  'class' => 'form-control',
                                'placeholder' => 'password',
                                'name' => 'password'])?>
                            <div class="form-control-feedback">
                                <i class="icon-user-lock text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center">
                            <div class="form-check mb-0">
                                <label class="form-check-label">
                                    <?php echo form_checkbox([  'name' => 'remember_Me',
                                        'class' => 'form-input-styled'], 'true', true);?>
                                    Remember me
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block"><i class="icon-unlocked mr-2"></i> Unlock</button>
                    </div>
                </div>
            <?php echo form_close();?>
            <!-- /unlock form -->

        </div>
        <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2015 - 2018. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</span>

                <ul class="navbar-nav ml-lg-auto">
                    <li class="nav-item"><a href="https://kopyov.ticksy.com/" class="navbar-nav-link" target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                    <li class="nav-item"><a href="http://demo.interface.club/limitless/docs/" class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i> Docs</a></li>
                    <li class="nav-item"><a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="navbar-nav-link font-weight-semibold"><span class="text-pink-400"><i class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                </ul>
            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>

<?php $this->user->logout(); ?>