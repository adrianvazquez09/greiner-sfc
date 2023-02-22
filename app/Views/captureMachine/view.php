<!-- JQuery DataTable Css -->
<link href="<?php echo base_url(); ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<!-- Basic Examples -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    GAM Machines
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Add Customer</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Acción</th>

                            </tr>
                        </tfoot>
                        <tbody>
                        <?php if(count($machines)>0) {?>
                            <?php for ($i = 0; $i < count($machines); $i++) { ?>
                                <tr>
                                    <td><?php echo $machines[$i]["id"]; ?></td>
                                    <td><?php echo $machines[$i]["name"]; ?></td>
                                    <td><?php echo $machines[$i]["description"]; ?></td>
                                    <td><?php echo $machines[$i]["brand"]; ?></td>
                                    <td><?php echo $machines[$i]["model"]; ?></td>
                                    <td><?php echo $machines[$i]["sn"]; ?></td>
                                    <td><a href="<?php echo base_url(); ?>/machines/view/<?php echo $machines[$i]['id'] ?>">View</a></td>
                                </tr>
                            <?php } ?>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>