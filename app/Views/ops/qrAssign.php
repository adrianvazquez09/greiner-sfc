<form method="POST" action="assignQR">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Captura de Codigos QR
                    </h2>
                </div>
                <div id="alert">

                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h2 class="card-inside-title">Codigo QR</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR del Molde" name="mold_qr" id="mold_qr" onchange="dataMolds();" />
                                </div>
                            </div>
                            <div class="form-group" id="technician">
                                <h2 class="card-inside-title">Molde</h2>
                                <div class="form-line">
                                <select class="form-control show-tick" name="mold_id" required>
                                        <option value="">-- Please select --</option>
                                    <?php for($i=0;$i<count($molds);$i++){ ?>
                                        <option value="<?php echo $molds[$i]['id']; ?>"><?php echo $molds[$i]['name']." - ".$molds[$i]['description'] ?></option>
                                    <?php } ?>
                                    </select>

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
    }

    function dataMolds() {
        myvar = "<?php echo base_url(); ?>";
        var mold_qr = document.getElementById('mold_qr').value;
        var url = myvar + '/operations/moldValidation/' + mold_qr;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if (data == 1) {
                    document.getElementById("alert").innerHTML  = ""; 
                    document.getElementById("alert").className = "";
                    docuemnt.getElementByName("mold_id").focus();
                } else if(data == 0) {
                    document.getElementById('mold_qr').value='';
                    document.getElementById("mold_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Codigo, Favor de Escanear de nuevo"; 
                    document.getElementById("alert").className = "alert alert-danger"; 
                } else if(data == 2){
                    
                    document.getElementById('mold_qr').value='';
                    document.getElementById("mold_qr").focus();
                    document.getElementById("alert").innerHTML  = "Error con el Codigo, Ya ha sido asignado"; 
                    document.getElementById("alert").className = "alert alert-danger";

                }
            }
        });
    }

</script>