<!DOCTYPE html>
<html lang="en">
    
<head>
<base url="http://localhost/ecom-food/">
        <title>e-com</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" href="css/landing-styles/style.css"/>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">     
        <?PHP
		echo $this->session->flashdata('invaliduser');
		?>       
            <form id="loginform" class="form-vertical" action="" method="post">
				<!-- <div class="control-group normal_text"> <h3><img src="img/logo.png" alt="Logo" /></h3></div>-->
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span><input type="text" name="username" placeholder="Username" value="<?PHP echo set_value('username')?>"/>
                           
                        </div>
                         <span class="err_rmsg"><?PHP echo form_error('username');?></span>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input type="password" name="password" placeholder="Password" />
                        </div>
                        <span class="err_rmsg"><?PHP echo form_error('password');?></span>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="javascript:void(0)" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><input type="submit" href="" class="btn btn-success" value="Login" name="login_btn" /></span>
                </div>
            </form>
            <form id="recoverform" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span>
                            <input type="text" placeholder="E-mail address" id="forget_reg_email" />
                             <span style="color:red" class="forget_reg_email_err"></span>
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="javascript:void(0)" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info forget_pwd"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 

<script>
var baseurl = "<?PHP echo base_url(); ?>";
</script>
<script type="text/javascript" src="resources/js/scripts.js"></script>
    </body>

</html>
