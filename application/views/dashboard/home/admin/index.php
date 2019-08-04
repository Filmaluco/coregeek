<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $current_Method;?></title>

    <?php $this->view('dashboard/layouts/head'); ?>

</head>

<body>

<?php $this->view('dashboard/layouts/navbar'); ?>

<!-- Page content -->
<div class="page-content">

<?php $this->view('dashboard/layouts/sidebar'); ?>



    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"><?php echo $controller_Name?></span> - <?php echo $current_Method?></h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    <div class="breadcrumb">
                        <a href="<?php echo $parent_Path?>" class="breadcrumb-item"><i class="icon-home2 mr-2"></i><?php echo $parent_Path_Name?></a>
                        <span class="breadcrumb-item active"><?php echo $current_Method?></span>
                    </div>

                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

            </div>
        </div>
        <!-- /page header -->
        <!-- Content area------------------------------------------------------------------------------------------- -->
        <div class="content">

            <?php

            $now = time(); // or your date as well
            $your_date = strtotime("2019-08-4");
            $datediff = $now - $your_date;

           $time = round($datediff / (60 * 60 * 24));
            ?>

            <div class="card border-success">
                <div class="card-header alpha-success border-success d-flex justify-content-between">
                    <span class="font-size-sm text-uppercase font-weight-semibold">Aug 4, 3:00pm</span>
                    <span class="font-size-sm text-uppercase text-success-700 font-weight-semibold"><?php echo $time;?> dia(s) atras</span>
                </div>
                <div class="card-body">
                    <h6 class="card-title">Aviso</h6>
                    <p class="card-text">O website
                        encontra-se em desenvolvimento, apenas as funções de booking estão ativas.</p>
                    <p class="card-text">Assim que sistema de booking esteja confirmado como estável as restantes funcionalidades serão ativadas:</p>
                </div>

                <div class="card card-body bg-light mb-0">
                    <dl class="mb-0">

                        <dt>Sistema notificações</dt>
                        <dd>
                            Os utilizadores serão notificados sempre que a administração tome políticas novas ou alterações importantes aconteçam nos seus bookings <br>
                            ex:
                            booking fechado por outra pessoa, telemóvel arranjado, ….
                        </dd>

                        <dt>Gestao de Loja</dt>
                        <dd>Cada loja tem acesso aos seus funcionários e contas associadas. <br>
                            Cada funcionário terá um código associado para autenticação.
                        </dd>

                        <dt>Estatísticas</dt>
                        <dd>Poderão consultar as vossas estatísticas</dd>

                    </dl>
                </div>

                <div class="card-footer bg-transparent d-flex justify-content-between border-top-0 pt-0">
                    <span class="text-muted">publicado por Coregeek</span>
                </div>
            </div>

        </div>
        <!-- /content area------------------------------------------------------------------------------------------ -->
        <?php $this->view('dashboard/layouts/footer'); ?>

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>