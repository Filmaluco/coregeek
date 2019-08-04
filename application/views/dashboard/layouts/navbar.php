<!-- Main navbar -->
<div class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-brand">
        <a href="<?php echo site_url('r/home');?>" class="d-inline-block">
            <img src="<?php echo assets_url()?>/images/banner-logo.png" alt="loading">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <!----------------------------------- NOTIFICATIONS ------------------------------------------------------->

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                    <i class="icon-bell2"></i>
                    <span class="d-md-none ml-2">Notifications</span>
                    <?php if($user_nr_notifications > 0){
                        echo '<span class="badge badge-danger badge-pill">'.$user_nr_notifications.'</span>';
                    } ?>
                </a>


                <?php

                if($user_nr_notifications > 0){

                    echo '<div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-300">';
                        echo '<div class="dropdown-content-header">';
                             echo '<span class="font-weight-semibold">Notifications</span>';
                        echo '</div>';
                    echo '<div class="dropdown-content-body dropdown-scrollable">';
                        echo '<ul class="media-list">';

                        foreach ($last_notifications as $notification){

                            echo '<li class="media">';

                                echo '<div class="mr-3">';
                                     echo '<a href="#" class="btn bg-transparent border-danger text-danger rounded-round border-2 btn-icon"><i class="'.$notification->get_Icon().'"></i></a>';
							    echo '</div>';

                                echo '<div class="media-body">';
                                    echo $notification->get_Message();
                                        echo '<div class="text-muted font-size-sm">';
                                            echo $notification->get_time_since();
                                        echo '</div>';
                                 echo '</div>';
                            echo '</li>';
                        }

                        echo '</ul>';
                    echo '</div>';

                    echo '<div class="dropdown-content-footer bg-light">';
                        echo '<a href="#" class="text-grey mr-auto">';
                            echo 'All Notifications</a>';
                        echo '<div>';
                            echo '<a href="#" class="text-grey" data-popup="tooltip" title="Mark all as read"><i class="icon-radio-unchecked"></i></a>';
                       echo ' </div>';
                    echo '</div>';
               echo '</div>';

                } ?>
            </li>

            <!----------------------------------- NOTIFICATIONS ------------------------------------------------------->

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="<?php echo assets_url()?>/images/avatar-logo.jpg" class="rounded-circle mr-2" height="34" width="34" alt="loading">
                    <span> <?php echo $username?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <!-- <a href="#" class="dropdown-item"><i class="icon-user-plus"></i>O meu Perfil</a>
                    <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Definições de Conta</a> -->
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo site_url('login/logout/') ?>" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->