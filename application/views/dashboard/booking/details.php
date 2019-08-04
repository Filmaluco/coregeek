<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $controller_Name. ' '. $current_Method;?></title>

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


            <div class="card bg-dark">
                <div class="card-header bg-dark header-elements-sm-inline">
                    <h4 class="card-title">
                        OR <b><?php echo $OR->get_ORID(); ?></b>
                        <span class="d-block font-size-base"><b>Estado actual:</b> <?php echo $OR->get_State() . " por " . $OR->get_StateAlteredBy(); ?>  </span>
                    </h4>
                    <div class="header-elements">
                        <ul class="pagination pagination-sm pagination-pager justify-content-between">
                            <?php
                            if($OR->get_RepairOffset() < ($OR->get_NumberRepairs()-1)){
                                $url = site_url('r/booking/details/' . $OR->get_ORID().'/'. ($OR->get_RepairOffset()+1).'');
                                echo '
                                    <ul class="pagination pagination-sm pagination-pager justify-content-between">
                                        <li class="page-item"><a name="2" href="'.$url.'" class="page-link" data-popup="tooltip" title="Alteracao anterior">&larr;</a></li>
                                    </ul> &nbsp; &nbsp;';
                            } ?>
                        </ul>
                        &nbsp; &nbsp;
                        <ul class="list-inline mb-0">
                            <?php
                            if($OR->get_RepairOffset() == 0){
                                echo '<li class="list-inline-item text-success" data-popup="tooltip" title="versao mais recente"><b>' .date('d, M Y', strtotime($OR->get_LastRepairInfo()->Creation_Date)) . '</b></li>';
                            }else{
                                echo '<li class="list-inline-item text-warning" data-popup="tooltip" title="versao antiga"><b>' .date('d, M Y', strtotime($OR->get_LastRepairInfo()->Creation_Date)) . '</b></li>';
                            }
                            ?>
                        </ul>
                        &nbsp; &nbsp;<?php
                                if($OR->get_RepairOffset() > 0){
                                    $url = site_url('r/booking/details/' . $OR->get_ORID().'/'. ($OR->get_RepairOffset()-1).'');
                                    echo '
                                    <ul class="pagination pagination-sm pagination-pager justify-content-between">
                                        <li class="page-item"><a name="2" href="'.$url.'" class="page-link" data-popup="tooltip" title="Alteracao seguinte">&rarr;</a></li>
                                    </ul> &nbsp; &nbsp;';
                        } ?>
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php
                                        $url = site_url('r/booking/edit/' . $OR->get_ORID().'');
                                        echo ' <a href="'. $url .'" class="dropdown-item" class="dropdown-item">Editar</a>';
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item" onclick="displayHistory()">Ver historico de estados</a>
                                    <?php
                                    if($OR->get_RepairOffset() > 0){
                                        $url = site_url('r/booking/details/' . $OR->get_ORID().'');
                                        echo ' <a href="'. $url .'" class="dropdown-item" class="dropdown-item">Ir para alteracao mais recente</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-body bg-light-alpha ">
                    <div class="row">
                        <div class="col">
                            Cliente
                            <blockquote class="blockquote d-flex py-2 mb-0">
                                <div class="mr-3">
                                    <img class="rounded-circle" src="<?php echo assets_url()?>/images/Avatar-Logo.jpg" alt="" width="46" height="46">
                                </div>
                                <div>
                                    <b class="mb-1">Nome:</b> <?php echo $OR->get_Client()->get_Name();?> <br>
                                    <i class="fa fa-envelope"></i> <?php echo $OR->get_Client()->get_Email(); echo $OR->get_Client()->get_Phone() ? "| <i class=\"fa fa-phone\"></i> " . $OR->get_Client()->get_Phone() : ""?>
                                </div>
                            </blockquote>
                        </div>

                        <div class="col text-right">
                            altercao feita por:
                            <blockquote class="blockquote d-flex py-2 mb-0">
                                <div class="mr-auto "></div>
                                    <div>
                                        <?php echo $OR->get_LastRepairUser_toString();?>
                                    </div>
                            </blockquote>

                        </div>
                    </div>
                </div>

                <script>
                    function displayHistory() {
                        $('#state_history').removeAttr('hidden');
                    }
                </script>

                <div id="state_history" class="card-body" hidden="true">
                   <?php
                        foreach($OR->get_StateHistory() as $history){
                          echo $history->Name . " por " . $history->Username . " [ " . $history->Creation_date .' ]<br>';
                        }
                   ?>
                </div>

                    <div class="card">
                        <div class="card-body text-dark ">
                            <?php echo $OR->get_LastRepairInfo()->Device;?>
                            <h5><i class="fa fa-wrench"></i>   <?php echo $OR->get_LastRepairInfo()->Brand . "-". $OR->get_LastRepairInfo()->Model;?></b>  </h5>
                            <b>Cor: </b>&emsp; &emsp;  <?php echo $OR->get_LastRepairInfo()->Color;?>  <br>
                            <b>IMEI: </b> &emsp;&emsp;   <?php echo $OR->get_LastRepairInfo()->IMEI;?> <br>
                            <b>Acessórios entregues: </b> <br>&emsp;  <?php echo $OR->get_LastRepairInfo()->Acessories ? $OR->get_LastRepairInfo()->Acessories : "nenhum";?>
                            <br><br>
                            <b>Sobre a dispositvo: </b><br>
                            <i>&emsp;&emsp;<?php echo $OR->get_LastRepairInfo()->Unlock_Code;?> </i>
                            <br>&emsp;&emsp;<?php echo $OR->get_LastRepairInfo()->Desc ? $OR->get_LastRepairInfo()->Desc : "<i>nada especificado</i>" ;?> <br>
                        </div>
                        <div class="card-body text-dark ">
                            <h5><i class="fa fa-info-circle"></i> Observações</h5>
                            <b><i>Recolha </b>  &emsp; <?php echo date('d, M Y', strtotime($OR->get_LastRepairInfo()->Schedule_To_Date));?> </i><br>
                            <?php echo $OR->get_LastRepairInfo()->Obs;?>
                        </div>

                        <?php

                        if($OR->get_LastRepairInfo()->Price > 0){
                            echo "
                                
                                <div class=\"card-body text-dark text-right\">
                                    <h5><i class=\"fa fa-money\"></i> Orçamento dado de ". $OR->get_LastRepairInfo()->Price ."€</h5>
                                </div>
                                
                                
                                ";
                        }

                        ?>

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