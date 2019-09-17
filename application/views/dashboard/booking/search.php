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

    <script src="<?php echo assets_url()?>/js/plugins/notifications/bootbox.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/notifications/sweet_alert.min.js"></script>
    <script src="<?php echo assets_url()?>/js/plugins/cookies/jquery.cookie.js"></script>


    <script src="<?php echo assets_url()?>/js/custom/bookingSearch.js"></script>

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



                <table class="table datatable-button-html5-basic table-striped" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>OR ID</th>
                        <th>Estado</th>
                        <th>Cliente</th>
                        <th>Dispositivo</th>
                        <th>Contactos</th>
                        <th>Ultima Alteracao (estado)</th>
                        <th class="text-center">Opcoes</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($query_search->result() as $row)
                    {
                       echo "<tr>";
                        echo "<td>".$row->OR_ID."</td>";
                        echo "<td id=\"".$row->OR_ID."_state\">".$row->Estado."</td>";
                        echo "<td>".$row->Cliente."</td>";
                        echo "<td>".$row->Dispositivo."</td>";
                        echo "<td>".$row->Contactos."</td>";
                        echo "<td id=\"".$row->OR_ID."_alteration\">".$row->UltimaAlteracao."</td>";


                        $url = site_url('v1/booking/details/' . $row->OR_ID.'');

                        echo '<td class="text-center">
                        <div class="list-icons">
                            <div class="dropdown">
                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                    <i class="icon-menu9"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="'.$url.'" class="dropdown-item"><i class="icon-search4"></i> Consultar</a>
                                    ';
                        $url = site_url('v1/booking/edit/' . $row->OR_ID.'');
                        echo ' <a href="'. $url .'" class="dropdown-item" class="dropdown-item"><i class="icon-pencil"></i>Editar</a>
                                   <div class="dropdown-divider"></div>
                                    <a href="#" id="'.$row->OR_ID.'" class="dropdown-item stateUpdate"><i class="icon-pencil"></i> Editar Estado</a>
                                </div>
                            </div>
                        </div>
                    </td>';

                    }
                    ?>



                    </tbody>
                </table>
                &nbsp;
            </div>
            <!-- /striped rows -->

        </div>
        <!-- /content area------------------------------------------------------------------------------------------ -->
        <?php $this->view('dashboard/layouts/footer'); ?>

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

</body>
</html>