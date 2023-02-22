       <!-- JQuery DataTable Css -->
       <link href="<?php echo base_url(); ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
       <!-- Basic Examples -->
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           GAM Moldes / Mantenimiento Ordenes de trabajo
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
                                       <th>Tipo de servicio</th>
                                       <th>No Maquina</th>
                                       <th>Status</th>
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tfoot>
                                   <tr>
                                       <th>ID</th>
                                       <th>Tipo de Servicio</th>
                                       <th>No. Maquina</th>
                                       <th>Status</th>
                                       <th>Action</th>

                                   </tr>
                               </tfoot>
                               <tbody>
                                   <?php for ($i = 0; $i < count($orders); $i++) { ?>
                                       <tr>
                                           <td><?php echo $orders[$i]["id"]; ?></td>
                                           <td><?php echo $orders[$i]["service_type"]; ?></td>
                                           <td><?php echo $orders[$i]["machine_no"]; ?></td>
                                           <td><?php echo $orders[$i]["status"]; ?></td>
                                           <td><a href="<?php echo base_url();?>/order/view/<?php echo $orders[$i]['id'] ?>">View</a></td>
                                       </tr>
                                   <?php } ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>