<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $controller_Name. ' '. $current_Method;?></title>

    <?php $this->view('dashboard/layouts/js-variables'); ?>
    <?php $this->view('dashboard/layouts/head'); ?>


    <script src="<?php echo assets_url()?>/js/plugins/uploaders/fileinput/plugins/purify.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/uploaders/fileinput/plugins/sortable.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/uploaders/fileinput/fileinput.min.js"></script>

    <script src="<?php echo assets_url()?>/js/custom/pricingFileUpload.js"></script>


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

            <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="panel-title">Tabela de Precos</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-lg-2 col-form-label font-weight-semibold">Excel upload:</label>
                        <div class="col-lg-10">
                            <input type="file" name="file" class="file-input-ajax"  data-fouc>
                            <span class="form-text text-muted">Pode fazer download da <a href="<?php echo assets_url(). '/pricing/'.EXCEL_FILE_NAME?>"> tabela atual</a></span>
                        </div>
                    </div>


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