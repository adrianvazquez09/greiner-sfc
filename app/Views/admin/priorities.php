       <!-- JQuery DataTable Css -->
       <link href="<?php echo base_url(); ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

       <!-- Basic Examples -->
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           GAM Priorities
                       </h2>
                       <ul class="header-dropdown m-r--5">
                           <li class="dropdown">
                               <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                   <i class="material-icons">more_vert</i>
                               </a>
                               <ul class="dropdown-menu pull-right">
                                   <li><a href="javascript:void(0);">Add Priority</a></li>
                               </ul>
                           </li>
                       </ul>
                   </div>
                   <div class="body">
                       <div class="table-responsive">
                           <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                               <thead>
                                   <tr>
                                       <th>Name</th>
                                       <th>Hours</th>
                                       <th>Description</th>
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tfoot>
                                   <tr>
                                       <th>Name</th>
                                       <th>Hours</th>
                                       <th>Description</th>
                                       <th>Action</th>
                                   </tr>
                               </tfoot>
                               <tbody>
                                   <?php for ($i = 0; $i < count($priorities); $i++) { ?>
                                       <tr>
                                           <td><?php echo $priorities[$i]["name"]; ?></td>
                                           <td><?php echo $priorities[$i]["hours"]; ?></td>
                                           <td><?php echo $priorities[$i]["description"]; ?></td>
                                           <td><a href="#"><span class="material-icons"> mode_edit </span></a> <a href="#"><span class="material-icons"> delete</span></a></td>
                                       </tr>
                                   <?php } ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>