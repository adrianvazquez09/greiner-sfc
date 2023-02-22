<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    GAM Molde <b><?php echo $mold['name'] ?></b><br>
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
                        ID del Molde: <b><?php echo $mold['id'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Ultima actualización: <b><?php echo date("Y-m-d") ?></b>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Nombre: <b><?php echo $mold['name'] ?></b>
                    </div>
                    <div class="col-sm-6">
                        Descripción: <b><?php echo $mold['description'] ?></b>
                    </div>

                </div>



                <div class="row">
                    <div class="col-sm-12">
                        Número de parte: <b><?php echo $mold['part_number'] ?></b>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Contador de shots</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        Shots Totales: <b><?php echo $mold['shots']; ?></b>
                    </div>
                    <div class="col-sm-6">
                        Shots actuales: <b><?php echo $shots; ?></b>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <h4>Ordenes</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php if (!empty($orders)) { ?>
                            <?php for ($i = 0; $i < count($orders); $i++) { ?>
                                <a href="<?php echo base_url(); ?>/order/view/<?php echo $orders[$i]['id'] ?>" target="_blank   "> <i class="material-icons">description</i> Orden de trabajo #<?php echo $orders[$i]['id'] ?></a> (<?php echo $orders[$i]['date_added'] ?>) <br>
                            <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Agregar Shots a este molde</h4>
                            </div>
                            <div class="col-sm-6">
                                Shots:
                                <input type="number" id="shots" name="shots">
                            </div>
                            <div class="col-sm-6"><br>
                                <div class="js-sweetalert">
                                    <button class="btn btn-primary" data-type="addshots-confirm">Agregar</button>
                                    <button class="btn btn-warning" data-type="resetshots-confirm">Resetear</button>
                                </div>
                                <!-- <div class="row clearfix jsdemo-notification-button">
                                    <button type="button" class="btn btn-danger btn-block waves-effect" data-placement-from="bottom" data-placement-align="left" data-animate-enter="" data-animate-exit="" data-color-name="alert-danger">
                                        DANGER
                                    </button>
                                </div> -->
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="col-sm-12">
                                <h4>Agregar un comentario</h4>
                            </div>
                            <div class="col-sm-12">
                                <form method="POST" action="<?php echo base_url(); ?>/mold/addComment/<?php echo $mold['id'] ?>">
                                    <div class="form-group" id="comments">
                                        <input id="order_id" name="order_id" type="hidden" value="<?php echo $mold['id'] ?>">
                                        <div class="row clearfix">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <textarea rows="3" name="comments" id="comments" class="form-control no-resize" placeholder="Escribe tu comentario aqui..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="enviar" class="btn bg-blue btn-block btn-lg waves-effect">Agregar comentario</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>Historial de comentarios del molde</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="body table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Comentario</th>
                                                <th>Usuario</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php for ($i = 0; $i < count($comments); $i++) { ?>
                                                <tr>
                                                    <td><?php echo $comments[$i]['comment'] ?></td>
                                                    <td><?php echo $comments[$i]['user'] ?></td>
                                                    <td><?php echo $comments[$i]['date_added'] ?></td>
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

<script type="text/javascript">
    console.log("Starting application");

    function resetearShots() {
        myvar = "<?php echo base_url(); ?>";
        mold_id =  "<?php echo $mold['id'] ?>";
        var url = myvar + '/Mold/resetShots/' +mold_id;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
            }
        });
    }

    function agregarShots() {
        var shots = document.getElementById('shots').value;
        myvar = "<?php echo base_url(); ?>";
        mold_id =  "<?php echo $mold['id'] ?>";
        var url = myvar + '/Mold/addShots/' +mold_id+'/'+shots;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
            }
        });
    }
</script>