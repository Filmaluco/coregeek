<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CoreGeek - Login</title>

    <?php $this->view('dashboard/layouts/js-variables'); ?>
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
                            <h5 class="mb-0">Bem Vindo a CoreGeek.pt</h5>
                            <span class="d-block text-muted">Por favor insira as suas credencias</span>
                        </div>

                        <?php if ($this->session->flashdata('errors')){
                            echo $this->session->flashdata('errors');
                        };?>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <?php echo form_input([ 'class' => 'form-control',
                                                    'placeholder' => 'username',
                                                    'name' => 'username'])?>
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <?php echo form_password([  'class' => 'form-control',
                                                        'placeholder' => 'password',
                                                        'name' => 'password'])?>
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
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

                        <div class="form-group">
                            <button type="submit" value="login" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 ml-2"></i></button>
                        </div>


                        <span class="form-text text-center text-muted">Ao continuar esta a concordar com a nossa <a href="#" data-toggle="modal" data-target="#CookiePolicy">Politica de Cookies</a></span>
                    </div>
                </div>
            <?php echo form_close();?>
            <!-- /login card -->

            <!-- Primary modal -->
            <div id="CookiePolicy" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h6 class="modal-title">Política de cookies</h6>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <h6 class="font-weight-semibold">O que são cookies?</h6>
                            <p>"Cookies" são pequenas etiquetas de software que são armazenadas nos equipamentos de acesso através do navegador (browser), retendo apenas informação relacionada com as preferências, não incluindo, como tal, os dados pessoais.
                            </p>

                            <hr>

                            <h6 class="font-weight-semibold">Para que servem os Cookies?</h6>
                            <p>Os cookies servem para ajudar a determinar a utilidade, interesse e o número de utilizações dos websites, permitindo uma navegação mais rápida e eficiente, eliminando a necessidade de introduzir repetidamente as mesmas informações.</p>

                            <hr>

                            <h6 class="font-weight-semibold">Que tipo de cookies existem?</h6>
                            <p>Existem dois grupos cookies que podem ser utilizados</p>
                            <ul>

                                <li> <b> Cookies permanentes </b>- são cookies que ficam armazenados ao nível do browser nos equipamentos de acesso (PC, mobile e tablet) e que são utilizados sempre que faz uma nova visita a um dos websites da Altice Portugal. São utilizados, geralmente, para direcionar a navegação aos interesses do utilizador, permitindo prestar um serviço mais personalizado.
                                </li>

                                <li> <b> Cookies de sessão </b>-  são cookies temporários que permanecem no arquivo de cookies do browser até sair do website. A informação obtida por estes cookies serve para analisar padrões de tráfego na web, permitindo identificar problemas e fornecer uma melhor experiência de navegação.
                                </li>

                            </ul>


                            <hr>

                            <h6 class="font-weight-semibold">Para que fins utilizamos cookies?</h6>
                            <ul>

                                <li> <b> Cookies estritamente necessários  </b>- Permitem a navegação no website e utilização das aplicações, bem como aceder a áreas seguras do website. Sem estes cookies, os serviços requerido não podem ser prestados.
                                </li>

                                <li> <b> Cookies analíticos  </b>- São utilizados anonimamente para efeitos de criação e análise de estatísticas, no sentido de melhorar o funcionamento do website.
                                </li>

                                <li> <b> Cookies de funcionalidade  </b>- Guardam as preferências do utilizador relativamente à utilização do site, para que não seja necessário voltar a configurar o site cada vez que o visita.
                                </li>

                            </ul>

                            <hr>

                            <h6 class="font-weight-semibold">Como pode gerir os cookies?</h6>
                            <p>
                                Todos os browsers permitem ao utilizador aceitar, recusar ou apagar cookies, e ainda informar o utilizador sempre que um cookie é recebido, nomeadamente através da seleção das definições apropriadas no respetivo navegador. O utilizador pode configurar os cookies no menu "opções" ou "preferências" do seu browser.
                                Note-se, no entanto, que, ao desativar cookies, pode impedir que alguns serviços da web funcionem corretamente, afetando, parcial ou totalmente, a navegação no website.

                            </p>
                            <hr>


                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /primary modal -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>