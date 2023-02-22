<!DOCTYPE html>
<html>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <img width="350px" src="<?php echo base_url(); ?>/plugins/logo/logo.svg" \>
            <p>Mould Shopfloor Control</p>
        </div>
        <div class="card">
            <div class="body">
                <form id="sign_in" method="POST" action="<?php echo base_url(); ?>/login/login">
                    <div class="msg">Sign in to start your session</div>
                    <?php
                    $session = session();
                    if ($session->getflashdata('msg')) {
                        echo '<div class="alert bg-red alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                ' . $session->getflashdata("msg") . '
                            </div>';
                    }
                    ?>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">developer_board</i>
                        </span>
                        <div class="form-line">
                            <input type="text" class="form-control" name="qrcode" placeholder="QR Code" autofocus>
                        </div>
                    </div>
                    <button class="btn bg-cyan waves-effect m-b-15" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Regular Login
                    </button>
                    <div class="collapse" id="collapseExample">
                        <div class="well">



                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-line">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-8 p-t-5">
                            <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                            <label for="rememberme">Remember Me</label>
                        </div>
                        <div class="col-xs-4">
                            <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                        </div>
                    </div>
                    <div class="row m-t-15 m-b--20">
                        <div class="col-xs-6">
                            <a href="<?php echo base_url(); ?>/login/requestAccess">Request Access</a>
                        </div>
                        <div class="col-xs-6 align-right">
                            <a href="<?php echo base_url(); ?>/login/resetPassword">Forgot Password?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    console.log("Starting the application");

    
    window.onload = function() {
        document.getElementsByName("qrcode").value ='';
    }
    </script>