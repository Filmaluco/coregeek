<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->


    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        <a href="<?php echo site_url('r/home');?>"><img src="<?php echo assets_url()?>/images/avatar-logo.jpg" width="38" height="38" class="rounded-circle" alt="loading"></a>
                    </div>
                    <div class="media-body">
                        <div class="media-title font-weight-semibold"><?php echo $username?></div>
                        <div class="font-size-xs opacity-50">
                            <i class="icon-store font-size-sm"></i> &nbsp; <?php echo $store_name; ?>
                        </div>
                    </div>

                    <div class="ml-3 align-self-center">
                        <!-- <a href="#" class="text-white"><i class="icon-cog3"></i></a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item">
                    <a href="<?php echo site_url('v1/home');?>" class="nav-link <?php if($current_Method == 'Home' && $controller_Name == 'Home'){echo 'active';}?>">
                        <i class="icon-home4"></i>
                        <span>Home</span>
                    </a>
                </li>

                <!-- Reparações -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Reparações</div> <i class="icon-menu" title="reparacoes"></i></li>


                <li class="nav-item nav-item-submenu <?php if( $controller_Name == 'Pricing'){echo 'nav-item-expanded nav-item-open';}?>">
                    <a href="#" class="nav-link <?php if( $controller_Name == 'Pricing'){echo 'active';}?>"><i class="icon-coin-dollar "></i> <span>Tabela Preços</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Themes">
                        <li class="nav-item"><a href="<?php echo site_url('v1/pricing/add');?>" class="nav-link <?php if($current_Method == 'Add' && $controller_Name == 'Pricing'){echo 'active';}?>">Nova Tabela</a></li>
                        <li class="nav-item"><a href="<?php echo site_url('v1/pricing/search');?>" class="nav-link <?php if($current_Method == 'Search' && $controller_Name == 'Pricing'){echo 'active';}?>">Consulta</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="<?php echo site_url('v1/booking/search');?>" class="nav-link <?php if($current_Method == 'Procura' && $controller_Name == 'Booking'){echo 'active';}?>"><i class="icon-search4"></i> <span>Pesquisa</span></a></li>
                <li class="nav-item"><a href="<?php echo site_url('v1/booking/book');?>" class="nav-link <?php if($current_Method == 'Novo Booking' && $controller_Name == 'Booking'){echo 'active';}?>"><i class="icon-add-to-list"></i> <span>Adicionar</span></a></li>





                <!-- /main -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->