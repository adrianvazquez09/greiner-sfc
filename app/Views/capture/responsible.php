<form method="POST" action="<?php echo base_url() ?>/capture/changeOwner">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Cambio de responsable
                    </h2>
                </div>
                <div id="alert">

                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input id="order_id" name="order_id" type="hidden" value="">
                                <h2 class="card-inside-title">Maquina / Molde</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Molde" name="mold_qr" id="mold_qr" onchange="dataMolds();" required />
                                </div>
                            </div>
                            <div class="form-group" id="technician">
                                <h2 class="card-inside-title">Técnico</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Tecnico" name="technician_qr" id="technician_qr" onchange="dataTechnician();" required />
                                </div>
                            </div>
                            <div class="form-group" id="comments">
                                <h2 class="card-inside-title">Razón del cambio</h2>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <textarea rows="3" name="comments" id="comments" class="form-control no-resize" placeholder="Escribe la razon del cambio..."></textarea>
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

        document.getElementById("mold_qr").focus();
        document.getElementById("technician_qr").readOnly = true;
        document.getElementById("comments").readOnly = true;
        document.getElementById("enviar").disabled = true;
    }

    function dataMolds() {
        myvar = "<?php echo base_url(); ?>";
        var mold_qr = document.getElementById('mold_qr').value;
        var url = myvar + '/capture/moldValidationOwner/' + mold_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML = "";
                    document.getElementById("alert").className = "";
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = false;
                    document.getElementById("technician_qr").focus();
                } else {
                    document.getElementById('mold_qr').value = '';
                    document.getElementById("mold_qr").focus();
                    document.getElementById("alert").innerHTML = "Error con el Molde, Favor de Escanear de nuevo";
                    document.getElementById("alert").className = "alert alert-danger";
                }
            }
        });
    }

    function dataTechnician() {
        myvar = "<?php echo base_url(); ?>";
        var tech_qr = document.getElementById('technician_qr').value;
        var url = myvar + '/capture/validateTechnician/' + tech_qr;

        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML = "";
                    document.getElementById("alert").className = "";
                    document.getElementById("mold_qr").readOnly = true;
                    document.getElementById("technician_qr").readOnly = true;
                    document.getElementById("comments").readOnly = false;
                    document.getElementById("enviar").disabled = false;

                } else {
                    document.getElementById("technician_qr").readOnly = false;
                    document.getElementById('technician_qr').value = '';
                    document.getElementById("technician_qr").focus();
                    document.getElementById("alert").innerHTML = "Error con el Tecnico, Favor de Escanear de nuevo";
                    document.getElementById("alert").className = "alert alert-danger";
                }
            }
        });
    }
</script>