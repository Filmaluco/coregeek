<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $controller_Name. ' '. $current_Method;?></title>

    <?php $this->view('dashboard/layouts/head'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>/css/patternlock.css"/>
    <script src="<?php echo assets_url(); ?>/js/custom/patternlock.js"></script>

    <script src="<?php echo assets_url(); ?>/js/plugins/forms/wizards/steps.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/forms/styling/uniform.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/forms/inputs/inputmask.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/forms/validation/validate.min.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/extensions/cookie.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.time.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/legacy.js"></script>


    <script src="<?php echo assets_url(); ?>/js/custom/bookWizard.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.date.js"></script>
    <script src="<?php echo assets_url(); ?>/js/plugins/pickers/pickadate/picker.time.js"></script>



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

            <?php if ($this->session->flashdata('errors')){
                echo $this->session->flashdata('errors');
            };?>

            <div class="card">
                <div class="card-header bg-white header-elements-inline">
                    <h6 class="card-title">Booking</h6>
                </div>


            <?php echo form_open('booking/add', 'class="wizard-form steps-validation" method="post" data-fouc id="form"');?>


            <h6>Dados Cliente</h6>
            <fieldset data-step-start>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nome Cliente:<span class="text-danger">*</span></label>
                            <input type="text" name="cliente_nome" class="form-control required" placeholder="Ana Alves" required title="Insira o nome do Cliente">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email:</label><span class="text-danger">*</span>
                            <input type="email" name="cliente_email" class="form-control required" placeholder="your@email.com" required title="É obrigatório um email para contacto">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telemóvel:</label>
                            <input type="text" name="cliente_telemovel" id="cliente_telemovel" class="form-control" placeholder="9x0-000-000" data-mask="999-999-999">
                        </div>
                    </div>
                </div>
            </fieldset>

            <h6>Dados Orçamento</h6>
            <fieldset>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Estado:<span class="text-danger">*</span></label>
                            <select name="or_estado" onchange="or_estadoCheck(this);" data-placeholder="Estado Orçamento" class="form-control form-control-select2 required" data-fouc required title="Recebido ou é necessario agendamento?">
                                <option></option>
                                <option value="Recebido na loja">Recebido na Loja</option>
                                <option value="Agendar Entrega">Agendar Entrega</option>
                            </select>
                        </div>


                        <div id="data-agendamento" style="display: none;">

                            <div class="form-group">
                        <span class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-calendar3"></i></span>
                            <input id="data" name="or_data_entrega" type="text" class="form-control pickadate"><span class="text-danger">*</span>
                        </span>
                            </div>
                        </div>

                    </div>

                </div>

                <script>
                    function or_estadoCheck(that) {
                        if (that.value == "Agendar Entrega") {
                            document.getElementById("data-agendamento").style.display = "block";
                            document.getElementById("data").classList.add('required');
                        } else {
                            document.getElementById("data-agendamento").style.display = "none";
                            document.getElementById("data").classList.remove('required');
                        }
                    }
                </script>



                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo Orçamento:</label>
                            <select name="or_tipo" onchange="or_tipoCheck(this);" data-placeholder="Tipo Orçamento" class="form-control form-control-select2" data-fouc>
                                <option></option>
                                <option selected="selected" value="Orçamentado">Orçamentado</option>
                                <option value="Orçamentar">Orçamentar</option>
                                <option value="Garantia">Garantia</option>
                            </select>
                        </div>
                    </div>

                    <script>
                        function or_tipoCheck(that) {
                            if (that.value == "Orçamentado") {
                                document.getElementById("valor-requiredMark").style.display = "";
                                document.getElementById("valor").classList.add('required');
                            } else {
                                document.getElementById("valor-requiredMark").style.display = "none";
                                document.getElementById("valor").classList.remove('required');

                            }
                        }
                    </script>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Preço:</label><span id="valor-requiredMark" class="text-danger">*</span>
                            <div class="form-group form-group-feedback form-group-feedback-left">
                                <input id="valor" style="" name="or_valor" type="number" class="form-control form-control-lg required" placeholder="00.00">
                                <div class="form-control-feedback form-control-feedback-lg">
                                    <i class="icon-coin-euro"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>

            <h6>Dados Equipamento</h6>
            <fieldset>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tipo Equipamento:<span class="text-danger">*</span></label>
                            <select name="tipo" data-placeholder="Tipo Equipamento" class="form-control form-control-select2 required" data-fouc>
                                <option>Outro</option>
                                <option selected="selected" value="SmartPhone">SmartPhone</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Portatil">Portatil</option>
                                <option value="Camera">Camera</option>
                                <option value="iPod">iPod</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Marca:<span class="text-danger">*</span></label>
                            <input type="text" name="marca" class="form-control required" placeholder="Xiaomi" required title="Campo Obrigatório">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Modelo:<span class="text-danger">*</span></label>
                            <input type="text" name="modelo" class="form-control required" placeholder="Mi 6" required title="Campo Obrigatório">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cor Ecrã:<span class="text-danger">*</span></label>
                            <input type="text" name="cor" class="form-control required" placeholder="Azul" required title="Campo Obrigatório">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Imei:</label>
                            <input type="text" name="imei" id="imei" class="form-control" placeholder="nnnnnn-nn-nnnnnn-n" data-mask="999999-99-999999-9">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Codigo Bloqueio</label>
                            <br>
                            <input type="radio" name="codeType" value="none"> S/ Codigo<br>
                            <input type="radio" name="codeType" value="alphanumeric"> Codigo<br>
                            <input type="radio" name="codeType" value="pattern"> Padrao<br>
                        </div>
                    </div>

                    <script>
                        $('input[type=radio][name=codeType]').change(function() {
                            if (this.value == 'none') {
                                document.getElementById("codigoDesbloqueio").style.display = "none";
                                document.getElementById("padraoDesbloqueio").style.display = "none";
                                document.getElementById("cod_bloqueio").classList.remove('required');
                            }
                            else if (this.value == 'alphanumeric') {
                                document.getElementById("codigoDesbloqueio").style.display = "";
                                document.getElementById("padraoDesbloqueio").style.display = "none";
                                document.getElementById("cod_bloqueio").classList.add('required');
                            }
                            else{
                                document.getElementById("codigoDesbloqueio").style.display = "none";
                                document.getElementById("padraoDesbloqueio").style.display = "";
                                document.getElementById("cod_bloqueio").classList.remove('required');

                            }
                        });
                    </script>


                    <div id="codigoDesbloqueio" style="display: none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" name="cod_bloqueio" class="form-control required" placeholder="codigo alfanumerico">
                            </div>
                        </div>
                    </div>

                    <div id="padraoDesbloqueio" style="display: none;">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Padrao</label>
                                <input type="password" id="padrao_bloqueio" name="password" class="patternlock"/>
                            </div>
                        </div>
                    </div>
                </div>


            </fieldset>

            <h6>Informação Adicional</h6>
            <fieldset>

                </br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Acessórios: &nbsp;&nbsp; </label>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="SimTray" name="acessorios[]" class="form-input-styled" data-fouc>
                                    SimTray
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="Caixa" name="acessorios[]" class="form-input-styled" data-fouc>
                                    Caixa
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="Capa" name="acessorios[]" class="form-input-styled" data-fouc>
                                    Capa
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="Carregador" name="acessorios[]" class="form-input-styled" data-fouc>
                                    Carregador
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="Manuais" name="acessorios[]" class="form-input-styled" data-fouc>
                                    Manuais
                                </label>
                            </div>

                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" value="Pelicula" name="acessorios[]" class="form-input-styled" data-fouc>
                                    Pelicula
                                </label>
                            </div>
                        </div>
                    </div>
                </div>


                </br>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Descrição da Avaria:</label>
                            <textarea name="obs_equipamento" rows="5" cols="5" placeholder="Pintura danificada do lado direito, chassi torto, ..." class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Outras observações:</label>
                            <textarea name="obs_or" rows="5" cols="5" placeholder="Cliente requer que ..." class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <input type="hidden" value="wizard-form steps-validation>" name="form-style" />

            </fieldset>


            <?php echo form_close();?>
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