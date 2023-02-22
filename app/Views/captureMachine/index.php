<form method="POST" action="machine/insertData">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h1>
                        Captura de Movimiento de <font color="orange"><b>Mantenimiento</b></font>
                    </h1>
                </div>
                <div id="alert" >
                
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                            <input id="order_id" name="order_id" type="hidden" value="">
                                <h2 class="card-inside-title">Máquina</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Maquina" name="machine_qr" id="machine_qr" onchange="dataMachine();" />
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
    console.log("Starting machine application");

    window.onload = function() {
        document.getElementById("machine_qr").readOnly = false;
        document.getElementById("technician_qr").readOnly = true;
        document.getElementById("type_work_qr").readOnly = true;
        document.getElementById("priority_qr").readOnly = true;
        document.getElementById("comments").readOnly = true;
        document.getElementById("enviar").disabled = true;
        document.getElementById("machine_qr").focus();
    }

    function dataMachine() {
        console.log("Validating machine data");
        myvar = "<?php echo base_url(); ?>";
        var machine_qr = document.getElementById('machine_qr').value;
        var url = myvar + '/machine/machineValidation/' + machine_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("machine_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = false;
                    document.getElementById("type_work_qr").readOnly = true;
                    document.getElementById("priority_qr").readOnly = true;
                    document.getElementById("comments").readOnly = true;
                    document.getElementById("technician_qr").focus();
                    hasActiveOrder();
                } else {
                    document.getElementById('machine_qr').value='';
                    document.getElementById("machine_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con la Maquina, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                }
            }
        });
    }

    function dataTechnician() {
        console.log("Validating technician data");
        myvar = "<?php echo base_url(); ?>";
        var machine_qr = document.getElementById('machine_qr').value;
        var technician_qr = document.getElementById('technician_qr').value;
        var url = myvar + '/machine/technicianValidation/' + machine_qr+'/'+technician_qr;
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
                    document.getElementById("machine_qr").readOnly = true;
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
        console.log("Validating data type data");
        myvar = "<?php echo base_url(); ?>";
        var type_work_qr = document.getElementById('type_work_qr').value;
        var url = myvar + '/machine/typeWorkValidation/' + type_work_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("machine_qr").readOnly = true;
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
        console.log("Validating priority data");
        myvar = "<?php echo base_url(); ?>";
        var type_work_qr = document.getElementById('priority_qr').value;
        var url = myvar + '/machine/priorityValidation/' + type_work_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = ""; 
                    document.getElementById("machine_qr").readOnly = true;
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
        var machine_qr = document.getElementById('machine_qr').value;
        var url = myvar + '/machine/hasActiveOrder/' + machine_qr;
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