<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo get_site_name(); ?> | Login</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
         type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet"
         type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"
         type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components"
         type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/login.min.css" rel="stylesheet" type="text/css" />
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" />
      <style>
         div .alert-danger {
         background-color: #fbe1e3;
         border-color: #fbe1e3;
         color: #e73d4a;
         text-align: center;
         }
         .error {
         color: red;
         }
         body {
         background: url(<?php echo base_url();
            ?>site/assets/img/login-bg3.jpg);
         background-size: cover;
         }
         .logo img {
         max-width: 400px;
         }
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
         background: rgba(2, 2, 2, 0.47);
         transition: all ease 0.3s;
         border-radius: 0 20px !important;
         }
         .login .content .form-control {
         background: transparent;
         border: none;
         color: #fff !important;
         border-bottom: 2px solid #ffffff;
         }
         .login .content:hover {
         transform: scale(1.02);
         }
         .login a:hover {
         color: blue;
         text-decoration: none;
         }
         form#verify_otp p {
         color: #edff00;
         }
         body:before {
         content: " ";
         background: rgba(0, 0, 0, 0.35);
         width: 100%;
         position: absolute;
         top: 0;
         bottom: 0;
         right: 0;
         left: 0;
         height: 100% !important;
         z-index: -1;
         }
         .login .copyright {
         color: #ffffff;
         }
      </style>
   </head>
   <body class="login">
      <!--div class="overlay"></div-->
      <div class="logo text-center"><img src="<?php echo site_url() ?>site/images/trackv2-logo.png" alt="Track Itinerary Software"></div>
      <div class="content">
         <!-- BEGIN LOGIN FORM -->
         <div>
            <span class="alert-danger">
               <?php echo $this->session->flashdata('error_msg'); ?>
               <?php $error  = $this->session->flashdata('error_inactive_msg');
                  if($error !=''): ?>
               <p><?php echo $error;?></p>
               <?php endif; ?>
               <?php echo validation_errors(); ?>
            </span>
         </div>
         <form class="login-form" id="mobLogin">
            <input type="hidden" name="sec_key" value="<?php echo $sec_key; ?>">
            <input type="hidden" name="reffere_url"
               value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ""; ?>">
            <h3 class="form-title font-green">Sign In</h3>
            <div class="alert alert-danger display-hide">
               <button class="close" data-close="alert"></button>
               <!--span> Please Enter username and password. </span-->
               <span> Please Enter username. </span>
            </div>
            <p style="color: #fff;"> Enter your valid user name to get login OTP. </p>
            <div class="form-group">
               <label class="control-label visible-ie8 visible-ie9">Username*</label>
               <input class="form-control form-control-solid placeholder-no-fix" type="text" id="usernametemp"
                  autocomplete="off" placeholder="Username*" name="username" />
            </div>
            <div class="form-actions ">
               <button type="submit" class="btn green uppercase">Login</button>
               <!--a href="javascript:void(0);" id="forget-password" class="forget-password">Forgot Password?</a-->
            </div>
            <div class="response"></div>
         </form>
         <!-- END LOGIN FORM -->
         <!-- Verify NUMBER FORM -->
         <form class="verify_otp" id="verify_otp">
            <input type="hidden" name="reffere_url"
               value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ""; ?>">
            <input type="hidden" name="sec_key" value="<?php echo $sec_key; ?>">
            <!--input type="hidden" id="mCode" name="hiddenCode" value="91"/-->
            <input type="hidden" id="mNumber" name="mobileNumber" />
            <input type="hidden" id="user_name" name="user_name" />
            <p> Verification code send to your mobile number. Please wait for 2 minute for <strong>OTP</strong>.</p>
            <p><strong>Enter your verification code here</strong></p>
            <div class="form-group">
               <input required class="form-control placeholder-no-fix" type="text" maxlength=4 autocomplete="off"
                  placeholder="Enter your verification code." name="verifyOtp" id="verifyOtp" />
            </div>
            <div class="form-actions">
               <button type="button" id="resendOtp" class="btn green btn-outline">Get OTP Via Voice Call</button>
               <button type="submit" class="btn btn-success uppercase pull-right">Verify</button>
            </div>
            <div class="response_ver"></div>
         </form>
         <!-- BEGIN FORGOT PASSWORD FORM -->
         <!--form class="forget-form" id="forgotPass">
            <input type="hidden" name="sec_key" value="<?php echo $sec_key; ?>">
                        <h3 class="font-green">Forget Password ?</h3>
                        <p style="color: red;"> Enter your e-mail address below to reset your password. </p>
                        <div class="form-group">
                            <input required class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Enter your registered email." name="email" /> 
            </div>
                        <div class="form-actions">
                            <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                            <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                        </div>
            <div class="response"></div>
                    </form-->
      </div>
      <div class="copyright"> 2017-<?php echo date('Y'); ?> © Track Itinerary. Develop By
         <a target="_blank" href="http://eligocs.com">Eligocs</a>
      </div>
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
      <!-- forgot password -->
      <script type="text/javascript">
         jQuery(document).ready(function($) {
         
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
                         url: "<?php echo base_url('login/ajax_forgot_password'); ?>",
                         dataType: 'json',
                         data: formData,
                         beforeSend: function() {
                             resp.html(
                                 '<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>'
                                 );
                         },
                         success: function(res) {
                             if (res.status == true) {
                                 resp.html(
                                     '<div class="alert alert-success"><strong>Success! </strong>' +
                                     res.msg + '</div>');
                                 console.log("done");
                                 $("#forgotPass")[0].reset();
                                 //location.reload();
                             } else {
                                 resp.html(
                                     '<div class="alert alert-danger"><strong>Error! </strong>' +
                                     res.msg + '</div>');
                             }
                         },
                         error: function(e) {
                             console.log(e);
                             resp.html(
                                 '<div class="alert alert-danger"><strong>Error!</strong>Please Try again later. </div>'
                                 );
                         }
                     });
                     return false;
                 }
             });
         });
      </script>
      <!--Login with Mobile NUMBER-->
      <script type="text/javascript">
         jQuery(document).ready(function($) {
             $("#verify_otp").hide();
             //Back Button show login form
             /* mobile number verification form request */
             $("#mobLogin").validate({
                 rules: {
                     username: {
                         required: true,
                     },
                 },
                 submitHandler: function(e) {
                     var resp = $("#mobLogin .response");
                     var ajaxReq;
                     var formData = $("#mobLogin").serializeArray();
                     //console.log(formData);
                     if (ajaxReq) {
                         ajaxReq.abort();
                     }
                     ajaxReq = $.ajax({
                         type: "POST",
                         url: "<?php echo base_url('login/ajax_login_with_mob'); ?>",
                         dataType: 'json',
                         data: formData,
                         beforeSend: function() {
                             resp.html(
                                 '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                                 );
                         },
                         success: function(res) {
                             //console.log(res);
                             if (res.status == true) {
                                 resp.html("");
                                 $("#mobLogin").hide();
                                 $("#verify_otp").show();
                                 var mob_n = res.mobile_number;
                                 $("#mNumber").val(mob_n);
                                 $("#user_name").val($("#usernametemp").val());
                                 /* resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
                                 console.log("done");
                                 $("#mobLogin")[0].reset(); */
                                 //location.reload();
                             } else {
                                 resp.html(
                                     '<div class="alert alert-danger"><strong>Error! </strong>' +
                                     res.msg + '</div>');
                             }
                         },
                         error: function(e) {
                             //console.log(e);
                             resp.html(
                                 '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later. </div>'
                                 );
                         }
                     });
                     return false;
                 }
             });
         
         
             /* Resend OTP */
             $(document).on("click", "#resendOtp", function(e) {
                 e.preventDefault();
                 var resp = $("#verify_otp .response_ver");
                 var ajaxReq;
                 var formData = $("#verify_otp").serializeArray();
                 //console.log(formData);
                 if (ajaxReq) {
                     ajaxReq.abort();
                 }
                 ajaxReq = $.ajax({
                     type: "POST",
                     url: "<?php echo base_url('login/ajax_resend_otp'); ?>",
                     dataType: 'json',
                     data: formData,
                     beforeSend: function() {
                         $("#resendOtp").attr("disabled", "disabled");
                         resp.html(
                             '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                             );
                     },
                     success: function(res) {
                         $("#resendOtp").removeAttr("disabled");
                         //console.log(res);
                         if (res.status == true) {
                             resp.html(
                                 '<div class="alert alert-success"><strong>Success ! </strong>' +
                                 res.msg + '</div>');
                             //window.location.href = res.redirect_url;
                         } else {
                             resp.html(
                                 '<div class="alert alert-danger"><strong>Error! </strong>' +
                                 res.msg + '</div>');
                         }
                     },
                     error: function(e) {
                         resp.html(
                             '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later. </div>'
                             );
                     }
                 });
         
             });
         
             /* Verify OTP */
             $("#verify_otp").validate({
                 rules: {
                     verifyOtp: {
                         required: true,
                         maxlength: 12
                     },
                 },
                 submitHandler: function(e) {
                     var resp = $("#verify_otp .response_ver");
                     var ajaxReq;
                     var formData = $("#verify_otp").serializeArray();
                     //console.log(formData);
                     if (ajaxReq) {
                         ajaxReq.abort();
                     }
                     ajaxReq = $.ajax({
                         type: "POST",
                         url: "<?php echo base_url('login/ajax_verify_otp'); ?>",
                         dataType: 'json',
                         data: formData,
                         beforeSend: function() {
                             resp.html(
                                 '<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</div>'
                                 );
                         },
                         success: function(res) {
                             //console.log(res);
                             if (res.status == true) {
                                 resp.html(
                                     '<div class="alert alert-success"><strong>Success ! </strong>' +
                                     res.msg + '</div>');
                                 window.location.href = res.redirect_url;
                             } else {
                                 resp.html(
                                     '<div class="alert alert-danger"><strong>Error! </strong>' +
                                     res.msg + '</div>');
                             }
                         },
                         error: function(e) {
                             resp.html(
                                 '<div class="alert alert-danger"><strong>Error!</strong> Please Try again later. </div>'
                                 );
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