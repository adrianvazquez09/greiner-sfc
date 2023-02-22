<form method="POST" action="capture/insertData">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Captura de Refacciones
                    </h2>
                </div>
                <div id="alert" >
                
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <input id="order_id" name="order_id" type="hidden" value="">
                                <h2 class="card-inside-title">Molde</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Molde" name="mold_qr" id="mold_qr" onchange="dataMolds();" />
                                </div>
                            </div>
                            <div class="form-group" id="technician">
                                <h2 class="card-inside-title">Técnico</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Tecnico" name="technician_qr" id="technician_qr" onchange="dataTechnician();" />
                                </div>
                            </div>
                            <div class="form-group" id="type_work">
                                <h2 class="card-inside-title">Tipo de trabajo</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Tipo de trabajo" name="type_work_qr" id="type_work_qr" onchange="dataTypeWork();" />
                                </div>
                            </div>
                            <div class="form-group" id="priority">
                                <h2 class="card-inside-title">Prioridad</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR de la prioridad" name="priority_qr" id="priority_qr" onchange="dataPriority();" />
                                </div>
                            </div>
                            <div class="form-group" id="comments">
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
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="enviar" class="btn bg-blue btn-block btn-lg waves-effect">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</form>


<script type="text/javascript">
    console.log("Starting application");

    window.onload = function() {
        document.getElementById("mold_qr").readOnly = false;
        document.getElementById("technician_qr").readOnly = true;
        document.getElementById("type_work_qr").readOnly = true;
        document.getElementById("priority_qr").readOnly = true;
        document.getElementById("comments").readOnly = true;
        document.getElementById("enviar").disabled = true;
        document.getElementById("mold_qr").focus();
    }

    function dataMolds() {
        myvar = "<?php echo base_url(); ?>";
        var mold_qr = document.getElementById('mold_qr').value;
        var url = myvar + '/capture/moldValidation/' + mold_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = false;
                    document.getElementById("type_work_qr").readOnly = true;
                    document.getElementById("priority_qr").readOnly = true;
                    document.getElementById("comments").readOnly = true;
                    document.getElementById("technician_qr").focus();
                    hasActiveOrder();
                } else {
                    document.getElementById('mold_qr').value='';
                    document.getElementById("mold_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Molde, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                }
            }
        });
    }

    function dataTechnician() {
        myvar = "<?php echo base_url(); ?>";
        var mold_qr = document.getElementById('mold_qr').value;
        var technician_qr = document.getElementById('technician_qr').value;
        var url = myvar + '/capture/technicianValidation/' + mold_qr+'/'+technician_qr;
        var order = document.getElementById("order_id").value;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                console.log(data);
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = true;
                    document.getElementById("type_work_qr").readOnly = false;
                    document.getElementById("priority_qr").readOnly = true;
                    document.getElementById("comments").readOnly = true;
                    document.getElementById("type_work_qr").focus();
                } else if (data==0){
                    document.getElementById('technician_qr').value='';
                    document.getElementById("technician_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Técnico, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                } else if(data==2){
                    document.getElementById('technician_qr').value='';
                    document.getElementById("technician_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Técnico, no esta ligado a ese proyecto"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                } if(order != ''){
                    document.getElementById("enviar").disabled = false;
                    document.getElementById("enviar").focus();
                }
            }
        });
    }

    function dataTypeWork() {
        myvar = "<?php echo base_url(); ?>";
        var type_work_qr = document.getElementById('type_work_qr').value;
        var url = myvar + '/capture/typeWorkValidation/' + type_work_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = true;
                    document.getElementById("type_work_qr").readOnly = true;
                    document.getElementById("priority_qr").readOnly = false;
                    document.getElementById("comments").readOnly = true;
                    document.getElementById("priority_qr").focus();
                } else {
                    document.getElementById('type_work_qr').value='';
                    document.getElementById("type_work_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Tipo de trabajo, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                }
            }
        });
    }

    function dataPriority() {
        myvar = "<?php echo base_url(); ?>";
        var type_work_qr = document.getElementById('priority_qr').value;
        var url = myvar + '/capture/priorityValidation/' + type_work_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = true;
                    document.getElementById("type_work_qr").readOnly = true;
                    document.getElementById("priority_qr").readOnly = true;
                    document.getElementById("comments").readOnly = false;
                    document.getElementById("enviar").disabled = false;
                    document.getElementById("enviar").focus();
                } else {
                    document.getElementById('type_work_qr').value='';
                    document.getElementById("type_work_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con la prioridad, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                }
            }
        });
    }

    function hasActiveOrder() {
        myvar = "<?php echo base_url(); ?>";
        var mold_qr = document.getElementById('mold_qr').value;
        var url = myvar + '/capture/hasActiveOrder/' + mold_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data != 0) {
                    document.getElementById("order_id").value  = data;
                    document.getElementById("type_work_qr").style.visibility = 'hidden';;
                    document.getElementById("priority_qr").style.visibility = 'hidden';
                } 
            }
        });
    }

</script>