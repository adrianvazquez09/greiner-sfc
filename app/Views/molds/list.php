       <!-- JQuery DataTable Css -->
       <link href="<?php echo base_url(); ?>/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

       <!-- Basic Examples -->
       <div class="row clearfix">
           <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
               <div class="card">
                   <div class="header">
                       <h2>
                           Moldes de GAM
                       </h2>
                       <ul class="header-dropdown m-r--5">
                           <li class="dropdown">
                               <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                   <i class="material-icons">more_vert</i>
                               </a>
                               <ul class="dropdown-menu pull-right">
                                   <li><a href="javascript:void(0);" data-toggle="modal" data-target="#defaultModal">Agregar Molde</a></li>
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
                                       <th>Description</th>
                                       <th>Partner</th>
                                       <th>Part Number</th>
                                       <th>Date Added</th>
                                       <th>Actions</th>
                                   </tr>
                               </thead>
                               <tfoot>
                                   <tr>
                                       <th>Name</th>
                                       <th>Description</th>
                                       <th>Partner</th>
                                       <th>Part Number</th>
                                       <th>Date Added</th>
                                       <th>Actions</th>
                                   </tr>
                               </tfoot>
                               <tbody>
                                   <?php for ($i = 0; $i < count($mold); $i++) { ?>
                                       <tr>
                                           <td><?php echo $mold[$i]["name"]; ?></td>
                                           <td><?php echo $mold[$i]["description"]; ?></td>
                                           <td><?php echo $mold[$i]["partner"]; ?></td>
                                           <td><?php echo $mold[$i]["part_number"]; ?></td>
                                           <td><?php echo $mold[$i]["date_added"]; ?></td>
                                           <td width="80px"><a href="<?php echo base_url()."/mold/view/".$mold[$i]['id']; ?>"><span class="material-icons"> remove_red_eye </span></a> <a href="<?php echo base_url()."/mold/edit/".$mold[$i]['id']; ?>"><span class="material-icons"> mode_edit </span></a> <a href="#"><span class="material-icons"> delete</span></a></td>
                                       </tr>
                                   <?php } ?>
                               </tbody>
                           </table>
                       </div>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="defaultModalLabel">Agregar Molde</h4>
                   </div>
                   <div class="modal-body">
                       <div class="row clearfix">
                           <div class="col-sm-12">
                               <form method="post" action="addMold">
                                   <div class="form-group">
                                       <h3>Nombre</h3>
                                       <div class="form-line">
                                           <input type="text" class="form-control" placeholder="Introducir Nombre del molde" name="name" required />
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Número de parte</h3>
                                       <div class="form-line">
                                           <input type="text" class="form-control" placeholder="Introducir Descripción del molde" name="part_number" required />
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Cliente</h3>
                                       <div class="form-line">
                                           <select name="partner_id">
                                               <?php for ($i = 0; $i < count($partners); $i++) { ?>
                                                   <option value="<?php echo $partners[$i]['id'] ?>"><?php echo $partners[$i]['name'] ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Descripción del producto</h3>
                                       <div class="row clearfix">
                                           <div class="col-sm-12">
                                               <div class="form-group">
                                                   <div class="form-line">
                                                       <textarea rows="3" name="description" class="form-control no-resize" placeholder="Description del producto"></textarea>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" class="btn bg-green btn-link waves-effect">Agregar Molde</button>
                       <button type="button" class="btn bg-red btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                   </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
           <div class="modal-dialog" role="document">
               <div class="modal-content">
                   <div class="modal-header">
                       <h4 class="modal-title" id="defaultModalLabel">Editar el Molde</h4>
                   </div>
                   <div class="modal-body">
                       <div class="row clearfix">
                           <div class="col-sm-12">
                               <form method="post" action="addMold">
                                   <div class="form-group">
                                       <h3>Nombre</h3>
                                       <div class="form-line">
                                           <input type="text" class="form-control" placeholder="Introducir Nombre del molde" name="name" required />
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Número de parte</h3>
                                       <div class="form-line">
                                           <input type="text" class="form-control" placeholder="Introducir Descripción del molde" name="part_number" required />
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Cliente</h3>
                                       <div class="form-line">
                                           <select name="partner_id">
                                               <?php for ($i = 0; $i < count($partners); $i++) { ?>
                                                   <option value="<?php echo $partners[$i]['id'] ?>"><?php echo $partners[$i]['name'] ?></option>
                                               <?php } ?>
                                           </select>
                                       </div>
                                   </div>
                                   <div class="form-group">
                                       <h3>Descripción del producto</h3>
                                       <div class="row clearfix">
                                           <div class="col-sm-12">
                                               <div class="form-group">
                                                   <div class="form-line">
                                                       <textarea rows="3" name="description" class="form-control no-resize" placeholder="Description del producto"></textarea>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" class="btn bg-green btn-link waves-effect">Agregar Molde</button>
                       <button type="button" class="btn bg-red btn-link waves-effect" data-dismiss="modal">Cancelar</button>
                   </div>
                   </form>
               </div>
           </div>
       </div>