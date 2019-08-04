<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $controller_Name. ' '. $current_Method;?></title>

    <?php $this->view('dashboard/layouts/head'); ?>


    <script src="<?php echo assets_url(); ?>/js/plugins/ui/moment/moment.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/daterangepicker.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/notifications/bootbox.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/cookies/jquery.cookie.js"></script>
    <script src="<?php echo assets_url(); ?>/js/custom/bookingEdit.js"></script>

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
            <?php echo form_open('r/booking/update', ' method="post" class="form-validate-jquery" data-fouc id="form"');?>
            <div class="card bg-dark">
                <div class="card-header bg-dark header-elements-sm-inline">
                    <h4 class="card-title">
                        OR <b><?php echo $OR->get_ORID(); ?></b>
                    </h4>
                    <div class="header-elements">

                       <select name="state" class="form-control text-warning">
                                <option value="1" <?php if($OR->get_StateID() == 1) echo "selected";?>>Agendado</option>
                                <option value="2" <?php if($OR->get_StateID() == 2) echo "selected";?>>Recebido na Loja </option>
                                <option value="4" <?php if($OR->get_StateID() == 4) echo "selected";?>>Recebido em Laboratorio</option>
                                <option value="7" <?php if($OR->get_StateID() == 7) echo "selected";?>>OR Recusado</option>
                                <option value="8" <?php if($OR->get_StateID() == 8) echo "selected";?>>Aguarda Stock</option>
                                <option value="9" <?php if($OR->get_StateID() == 9) echo "selected";?>>Em Reparação</option>
                                <option value="10" <?php if($OR->get_StateID() ==10) echo "selected";?>>Reparado</option>
                                <option value="15" <?php if($OR->get_StateID() == 15) echo "selected";?>>Entregue (Reparado)</option>
                                <option value="16" <?php if($OR->get_StateID() == 16) echo "selected";?>>Entregue (S/ Reparação)</option>
                                <option value="17" <?php if($OR->get_StateID() == 17) echo "selected";?>>Cancelado</option>
                            </select>
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
                    <div class="card-body text-warning-400 ">
                        <h5><i class="fa fa-info-circle"></i> Observações</h5>


                        <b><i>Recolha </b>
                        <div class="form-group ">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="icon-calendar22"> </i> </span> &nbsp;&nbsp;
                                <input type="text" name="or_data_entrega" class="form-control daterange-single" value="<?php echo date('d/m/Y', strtotime($OR->get_LastRepairInfo()->Schedule_To_Date));?>">
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Outras observações:</label>
                                    <textarea rows="2"  class="form-control" disabled> <?php echo $OR->get_LastRepairInfo()->Obs;?></textarea>
                                    <textarea name="obs_or" rows="5" cols="5" placeholder="informacao nova ..." class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="card-body text-warning">
                            <h5><i class="fa fa-money"></i> Orçamento</h5>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="form-group form-group-feedback form-group-feedback-left">
                                        <input id="valor" style="" name="or_valor" type="number" class="form-control form-control-lg required" placeholder=" <?php echo $OR->get_LastRepairInfo()->Price;?>">
                                        <div class="form-control-feedback form-control-feedback-lg">
                                            <i class="icon-coin-euro"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    <input type="hidden" id="cod_func" value="" name="cod_func"/>
                    <input type="hidden" id="cod_func" value="<?php echo $OR->get_ORID();?>" name="or_id"/>
                    
                    <div class="form-group">
                        <button type="button" id="submit_btn" value="login" class="btn btn-primary btn-block">Editar<i class="icon-circle-right2 ml-2"></i></button>
                    </div>

                </div>
                <?php echo form_close();?>
            </div>
        <!-- /content area------------------------------------------------------------------------------------------ -->
        <?php $this->view('dashboard/layouts/footer'); ?>

        </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>