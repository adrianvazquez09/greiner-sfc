<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    GAM Moldes / Mantenimiento Orden de trabajo <b><?php echo $order['id'] ?></b><br>
                </h2>
                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);">Add a comment</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row">
                    <div class="col-sm-6">
                        No. de Orden: <b><?php echo $order['id'] ?></b>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Tipo de servicio: <b><?php echo $order['service_type'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Departamento Solicitante: <b><?php echo $order['department_req'] ?></b>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Nombre del solicitante: <b><?php echo $order['name_req'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Fecha y hora de solicitud: <b><?php echo $order['date_req']." ".$order['hour_req'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Area de solicitante: <b><?php echo $order['area_req'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Turno de solicitante: <b><?php echo $order['shift_req'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Número de Maquina: <b><?php echo $order['machine_no'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Molde: <b><?php echo $owner['name'].", ".$mold['name'].", ".$mold['description'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Tipo de maquina: <b><?php echo $order['machine_type_id'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Sintomas: <b><?php echo $order['symptom'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Estatus: <b><?php echo $order['status'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Usuario que reporto: <b><?php echo $order['username'] ?></b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Fecha de registro: <b><?php echo $order['date_added'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        &nbsp;
                    </div>
                </div>
                <hr>
                <div class="row"> <?php if($order['status']!='Closed'){ ?>
                    <div class="col-sm-3">
                   
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Agregar un comentario</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <form method="POST" action="../addComment">
                                    <div class="form-group" id="comments">
                                    <input id="order_id" name="order_id" type="hidden" value="<?php echo $order['id']?>">
                                        <h2 class="card-inside-title">Comentarios</h2>
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="3" name="comments" id="comments" class="form-control no-resize" placeholder="Escribe los comentarios del servicio..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="enviar" class="btn bg-blue btn-block btn-lg waves-effect">Agregar comentario</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div><?php }?>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Historial de la orden</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                            <div class="body table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Información</th>
                                        <th>Usuario</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php for($i = 0; $i<count($comment_order) ;$i++) {?>
                                    <tr>
                                        <td><?php echo $comment_order[$i]['comment'] ?></td>
                                        <td><?php echo ucfirst($comment_order[$i]['user']) ?></td>
                                        <td><?php echo $comment_order[$i]['date_added'] ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>