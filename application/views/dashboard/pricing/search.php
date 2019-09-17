<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo 'Coregeek.pt - ' . $controller_Name. ' '. $current_Method;?></title>

    <?php $this->view('dashboard/layouts/js-variables'); ?>

    <?php $this->view('dashboard/layouts/head'); ?>

    <script src="<?php echo assets_url()?>/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/forms/selects/select2.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/tables/datatables/extensions/buttons.min.js"></script>


    <script src="<?php echo assets_url()?>/js/custom/pricingSearch.js"></script>

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
                    <h5 class="card-title">Consulta</h5>
                </div>


        <?php
        echo '<table class="table datatable-basic table-striped" cellspacing="0" width="100%">';
            $isFirst = true;

            foreach( $schedules as $single_schedule ) {
                if($isFirst){
                    echo '<thead>
                    <tr>';
                    foreach( $single_schedule as $single_item )
                        echo '<th>' . $single_item . '</th>';

                    echo '</tr>
                    </thead>
                    <tbody>';
                    $isFirst = false;
                    continue;
                }
                echo '<tr>';
                foreach( $single_schedule as $single_item ) {
                    echo '<th>' . $single_item . '</th>';
                }
                echo '</tr>';
            }
            echo ' </tbody>
                </table>';
        ?>

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