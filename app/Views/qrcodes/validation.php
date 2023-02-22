<form method="POST">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Validar si existe un codigo QR
                    </h2>
                </div>
                <div id="alert" >
                
                </div>
                <div class="body">
                    <div class="row clearfix">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h2 class="card-inside-title">Codigo QR</h2>
                                <div class="form-line">
                                    <input type="text" class="form-control" placeholder="Introducir QR" name="qr_code" id="qr_code" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="event.preventDefault(); dataValidation()" >Enviar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    console.log("Starting application");

    window.onload = function() {
        document.getElementById('qr_code').value='';
        document.getElementById("qr_code").focus();
    }

    function dataValidation() {
        console.log("check qr");
        myvar = "<?php echo base_url(); ?>";
        var qr_code = document.getElementById('qr_code').value;
        var url = myvar + '/QRCodes/checkDataAjax/' + qr_code;
        $.ajax({
            type: "POST",
            async: true,
            url: url,
            success: function(data) {
                if(data=='not found'){
                    document.getElementById('qr_code').value = '';
                    document.getElementById("qr_code").focus();
                    document.getElementById("alert").innerHTML = "No result found";
                    document.getElementById("alert").className = "alert alert-danger";
                } else {
                    document.getElementById('qr_code').value = '';
                    document.getElementById("qr_code").focus();
                    document.getElementById("alert").innerHTML = "Result: "+data;
                    document.getElementById("alert").className = "alert alert-success";
                }
            }
        });
    }
</script>