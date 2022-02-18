<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo get_site_name(); ?> | Login</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/login.min.css" rel="stylesheet" type="text/css" />
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url()  . 'site/images/' . favicon() ?>" />
      <style>
         div .alert-danger {
            background-color: white; 
            border-color: transparent;  
            color: #e73d4a;
            text-align: center;
         }

         .error {color: red;}
         html{background:url(<?php echo base_url();?>site/assets/img/login-bg3.jpg); 
         background-size: 110%;
         background-repeat: no-repeat;
         }
         .logo img {max-width: 300px;}
         .overlay {
         content: " ";
         background: rgba(0, 0, 0, 0.35);
         width: 100%;
         position: absolute;
         top: 0;
         bottom: 0;
         right: 0;
         left: 0;
         height: 100%;
         z-index: -1;
         }
         .login .content {
         box-shadow: 1px 2px 100px 0px rgba(0, 0, 0, 0.27);
         border: 1px solid #8c8c8ced;
         background: white;
         transition: all ease 0.3s;
         border-radius: 0 20px !important;
         }
         .login .content .form-control {
         background: transparent;
         border: none;
         color: #000 !important;
         border: 2px solid #545454;
         border-radius: 50px !important;
         font-weight: 600;
         }
         .login .content:hover {
         transform: scale(1.02);
         }
         .login a:hover {
         color: blue;
         text-decoration: none;
         }
      </style>
   </head>
   <body class="login">
      <div class="overlay"></div>
      <div class="logo text-center"><img src="<?php echo site_url()  . 'site/images/' . getLogo() ?>" alt="Itinerary Software"></div>
      <!-- <div class="logo text-center"><img src="<?php echo site_url() ?>site/images/trackv2-logo.png" alt="Itinerary Software"></div> -->
      <div class="content">
         <!-- BEGIN LOGIN FORM -->
         <form class="login-form" action="<?php echo base_url();?>login/validation" method="post">
            <input type="hidden" name="sec_key" value="<?php echo $sec_key; ?>">
            <input type="hidden" name="reffere_url" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ""; ?>">
            <h3 class="form-title font-green">Sign In</h3>
            <div class="alert alert-danger display-hide">
               <button class="close" data-close="alert"></button>
               <span> Please Enter username and password. </span>
            </div>
            <div class="form-group">
               <label class="control-label visible-ie8 visible-ie9">Username</label>
               <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" /> 
            </div>
            <div class="form-group">
               <label class="control-label visible-ie8 visible-ie9">Password</label>
               <input class="form-control form-control-solid placeholder-no-fix" type="password" id="passWord" autocomplete="off" placeholder="Password" name="password" /> 
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green uppercase">Login</button>
               <a href="javascript:void(0);" id="forget-password" class="forget-password">Forgot Password?</a>
            </div>
            <div class="text-center">
               <span class="alert-danger">
                  <?php echo $this->session->flashdata('error_msg'); ?>
                  <?php $error  = $this->session->flashdata('error_inactive_msg');
                     if($error !=''): ?> 
                  <p><?php echo $error;?></p>
                  <?php endif; ?>
                  <?php echo validation_errors(); ?>
               </span>
            </div>
         </form>
         <!-- END LOGIN FORM -->
         <!-- BEGIN FORGOT PASSWORD FORM -->
         <form class="forget-form" id="forgotPass">
            <input type="hidden" name="sec_key" value="<?php echo $sec_key; ?>">
            <h3 class="font-green">Forget Password ?</h3>
            <p style="color: #fff;"> Enter your e-mail address below to reset your password. </p>
            <div class="form-group">
               <input required class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Enter your registered email." name="email" /> 
            </div>
            <div class="form-actions">
               <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
               <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
            </div>
            <div class="response"></div>
         </form>
      </div>
      <div class="copyright"> 2017-<?php echo date('Y'); ?> © Track Itinerary. Develop By
         <a target="_blank" href="http://eligocs.com">EligoCS</a>
      </div>
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
      <!-- forgot password -->
      <script type="text/javascript">
         jQuery(document).ready(function($){
         	//remove space from password
         	$(document).on('keydown', '#passWord', function(e) {
         		if (e.keyCode == 32) return false;
         	}); 
         
         	var resp = $(".response");
         	var ajaxReq;
         	$("#forgotPass").validate({
         		rules: {
         			email: {
         				required: true,
         				email: true
         			}
         		},
         		submitHandler: function(e) {
         			var formData = $("#forgotPass").serializeArray();
         			//console.log(formData);
         			if (ajaxReq) {
         				ajaxReq.abort();
         			}
         			ajaxReq = $.ajax({
         				type: "POST",
         				url: "<?php echo base_url('login/ajax_forgot_password'); ?>" ,
         				dataType: 'json',
         				data: formData,
         				beforeSend: function(){
         					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
         				},
         				success: function(res) {
         					if (res.status == true){
         						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
         						console.log("done");
         						$("#forgotPass")[0].reset();
         						//location.reload();
         					}else{
         						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
         					}
         				},
         				error: function(e){
         					console.log(e);
         					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later. </div>');
         				}
         			});
         			return false;
         		}
         	});	
         }); 
      </script>
      <script src="<?php echo base_url();?>site/assets/js/login.min.js" type="text/javascript"></script>
   </body>
</html>