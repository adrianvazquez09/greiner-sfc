       <!-- JQuery DataTable Css -->
       <link href="<?php echo base_url(); ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

       <!-- Basic Examples -->
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           User List
                       </h2>
                       <ul class="header-dropdown m-r--5">
                           <li class="dropdown">
                               <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                   <i class="material-icons">more_vert</i>
                               </a>
                               <ul class="dropdown-menu pull-right">
                                   <li><a href="javascript:void(0);">Add User</a></li>
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
                                       <th>Username</th>
                                       <th>Email</th>
                                       <th>Employee No</th>
                                       <th>Role</th>
                                       <th>Status</th>
                                       <th>Date Added</th>
                                       <th>Action</th>
                                   </tr>
                               </thead>
                               <tfoot>
                                   <tr>
                                       <th>ID</th>
                                       <th>Username</th>
                                       <th>Email</th>
                                       <th>Employee No</th>
                                       <th>Role</th>
                                       <th>Status</th>
                                       <th>Date Added</th>
                                       <th>Action</th>

                                   </tr>
                               </tfoot>
                               <tbody>
                                   <?php for ($i = 0; $i < count($users); $i++) { ?>
                                       <tr>
                                       <td><?php echo $users[$i]["id"]; ?></td>
                                           <td><?php echo $users[$i]["username"]; ?></td>
                                           <td><?php echo $users[$i]["email"]; ?></td>
                                           <td><?php echo $users[$i]["employee_no"]; ?></td>
                                           <td><?php echo $users[$i]["role_id"]; ?></td>
                                           <td><?php if ($users[$i]["enabled"] == '1') {
                                                    echo "Enabled";
                                                } else {
                                                    echo "Disabled";
                                                } ?></td>
                                           <td><?php echo $users[$i]["date_added"]; ?></td>
                                           <td><a href="<?php echo base_url(); ?>/admin/userView/<?php echo $users[$i]['id'] ?>" ><span class="material-icons"> remove_red_eye </span> </a>  <a href="#"><span class="material-icons"> mode_edit </span></a> <a href="#"><span class="material-icons"> delete</span></a></td>
                                       </tr>
                                   <?php } ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>