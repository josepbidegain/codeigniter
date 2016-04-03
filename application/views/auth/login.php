<? if ( isset($error) && $error ) {echo $error;} ?>
<!DOCTYPE html>
<html>
<head>
	<title>Bienvenido a sistema de usuarios</title>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
</head>
<body>
	
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Ingrese a nuestro sistema</h1>
            <div class="account-wall">
                

                <?=validation_errors('<div class="errors">','</div>'); ?>
                <!-- <form class="form-signin" action='http://localhost/codeigniter/index.php/auth/login/' method="post">              -->
                <?php
                $form_attributes = array(
                "id"     => "reg_form",
                "name"   => "reg_form",
                "method" => "post",
                "class"  => "form-signin"
                );
                echo form_open(base_url()."index.php/auth/login/", $form_attributes);
                echo form_hidden('token',$token);
                ?>
				
                <input type="text" name="email" class="form-control" placeholder="Email" required autofocus <?= set_value('email'); ?> >
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Ingresar</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                <!-- <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>-->
                </form>
            </div>
            <!-- <a href="#" class="text-center new-account">Create an account </a> -->
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo base_url("assets/js/jQuery-1.11.3.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.js"); ?>"></script>

</body>
</html>