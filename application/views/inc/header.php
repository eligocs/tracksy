<!DOCTYPE html/>
<!--[if !IE]><!-->
<html lang="en">
   <!--<![endif]-->
   <!-- BEGIN HEAD -->
   <head>
      <meta charset="utf-8" />
      <title><?php echo get_site_name(); ?></title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="width=device-width, initial-scale=1" name="viewport" />
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
      <link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <!-- <link href="<?php // echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" /> -->
      <link href="<?php echo base_url();?>site/assets/css/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/daterangepicker.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/layout.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/sweetalert.min.css" rel="stylesheet" type="text/css" />
      <!--link href="<?php //echo base_url();?>site/assets/css/jquery.multiselect.css" rel="stylesheet" type="text/css" /-->
      <link href="<?php echo base_url();?>site/assets/css/fullcalendar.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
      <!--User Theme Style -->
      <?php $theme_style =  get_user_theme_style(); 
         $theme_css = !empty( $theme_style ) ? trim( $theme_style ) : "default";
         ?>
      <link href="<?php echo base_url();?>site/assets/css/<?php echo $theme_css ?>.css" data-style_colour = "<?php echo $theme_css ?>" rel="stylesheet" type="text/css" id="style_color" />
      <!--End User Theme Style -->
      <!-- END THEME LAYOUT STYLES -->
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url()  . 'site/images/' . favicon() ?>" />
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
      <link href="<?php echo base_url();?>site/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/custom.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/custom-new.css" rel="stylesheet" type="text/css" />
   </head>
   <!-- END HEAD -->
   <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white <?php echo $theme_css; ?>">
      <?php $user_data = get_user_info(); 
         $h_user_role = isset( $user_data[0]->user_type ) ? $user_data[0]->user_type : "";
         $h_user_id = isset( $user_data[0]->user_id ) ? $user_data[0]->user_id : "";
         ?>
      <div class="page-wrapper">
         <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
         <!-- BEGIN HEADER -->
         <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
               <!-- BEGIN LOGO -->
               <div class="page-logo">
                  <a href="<?php echo site_url();?>">
                  <img src="<?php echo site_url(); ?>site/images/trackv2-logo.png" alt="Trackitineray software" class="img-responsive logo-top">
                  </a>
                  <div class="menu-toggler sidebar-toggler">
                     <!-- <span></span> -->
                     <i class="fa fa-bars" aria-hidden="true"></i>
                  </div>
               </div>
               <!-- END LOGO -->
               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
               <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
               <span></span>
               </a>
            </div>
            <strong class="red"> <?php //echo get_last_login() ?></strong>
            <!--clock section
            <div id="MyClockDisplay" class="clock"></div>
         -->
            <!--new year-->
            <!--div class="marq_h">
               Welcome to 2019
               </div-->
            <!--end new year-->
            <?php 
               //if saleteam user show monthly target
               if( $h_user_role == 99 || $h_user_role == 98   ){
               	$mtarget = (int)get_total_target_by_month(); 
               	$mbooked = (int)get_agents_booked_packages();
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage =  !empty( $mtarget ) ?  floor(($mbooked / $mtarget) * 100) : 0; ?>
            <div class='header_target_section'>
               <a href="<?php echo base_url("incentive"); ?>" title="Go to incentive page">
                  <div class="progress" style="max-width:100%; min-width:250px;">
                     <span class="target"><span style="color:#6200ff;">Booked: <?php echo $mbooked; ?></span> / <span style="color:red;">Target: <?php echo $mtarget; ?> </span></span>
                     <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                        aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage; ?>%">
                     </div>
                  </div>
               </a>
            </div>
            <?php }else if( $h_user_role == 96 ){ ?>
            <!--check teamleader-->
            <?php if( !empty( get_teamleader() ) ){
               $team_leader = get_teamleader();
               echo "<div class='header_team-leader-name'>TEAM : <span title='Team Name ( Leader )'>{$team_leader}</span></div>";
               } ?>
            <!--end check teamleader-->
            <?php
               if( is_teamleader() ){ 
               	$agent_in = is_teamleader();
               	$mtarget = (int)get_total_target_by_month( $agent_in ); 
               	$mbooked = (int)get_agents_booked_packages( NULL, NULL, $agent_in );
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage = !empty( $mtarget ) ? floor( ( $mbooked / $mtarget ) * 100) : 0;
               }else{ 
               	$mtarget = (int)get_agent_monthly_target(); 
               	$mbooked = (int)get_agents_booked_packages();
               	//$mtarget = 10; 
               	//$mbooked = 10;
               	$percentage =  !empty( $mtarget ) ?  floor(($mbooked / $mtarget) * 100) : 0;
               } ?>
            <div class='header_target_section'>
               <a href="<?php echo base_url("incentive"); ?>" title="Go to incentive page">
                  <div class="progress" style="max-width:100%; min-width:250px;">
                     <span class="target"><span style="color:#6200ff;">Booked: <?php echo $mbooked; ?></span> / <span style="color:red;">Target: <?php echo $mtarget; ?> </span></span>
                     <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                        aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $percentage; ?>%">
                     </div>
                  </div>
               </a>
            </div>
            <?php }	?>
            <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
            <style>
               .header_target_section .progress {
               line-height: 20px;
               color: #000;
               font-size: 12px;
               font-weight: 700;
               font-family: "Open Sans",sans-serif !important;
               height: 20px;    background: #fff8dc;}	
               span.target {
               position: absolute;
               left: 0;
               right: 0;
               margin: auto;
               text-align: center;
               }
               .header_target_section .progress-bar-success {background-color: #25b759;     background-size: 20px 20px !important;}					
               .marq_h{
               font-size: 18px;
               top: 20%;
               right: 10%;
               position: absolute;
               animation:blinkingText 3s infinite;
               font-family: Orbitron;
               }
               @keyframes blinkingText{
               0%{     color: #fde100;    }
               49%{    color: #fde100; }
               50%{    color: transparent; }
               99%{    color:transparent;  }
               100%{   color: #fde100;    }
               }
               .header_target_section{
               font-size: 18px;
               top: 30%;
               right: 10%;
               position: absolute;
               font-family: Orbitron;
               color: #fde100;
               }
               .clock {
               position: absolute;
               top: 50%;
               left: 50%;
               transform: translateX(-50%) translateY(-50%);
               /* color: #17D4FE; */
			   color: white;
               font-size: 30px;
               font-family: Orbitron;
               letter-spacing: 7px;
               }
               .header_team-leader-name {
               position: absolute;
               left: 240px;
               top: 10px;
               color: #fff;
               font-family: "Open Sans",sans-serif !important;
               }
               .header_team-leader-name span {color: yellow;}
               @media(max-width:1400px){
               .clock {font-size: 20px;}
               }
               .swal-overlay {
               background-color: rgba(43, 165, 137, 0.45);
               }
               .swal-button {
               padding: 7px 19px;
               border-radius: 2px;
               background-color: #4962B3;
               font-size: 12px;
               border: 1px solid #3e549a;
               text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.3);
               }

               .swal-modal {
               background-color: rgba(63,255,106,0.69);
               border: 3px solid white;
               }
            </style>
            <script>
               function showTime(){
               	var date = new Date();
               	var h = date.getHours(); // 0 - 23
               	var m = date.getMinutes(); // 0 - 59
               	var s = date.getSeconds(); // 0 - 59
               	var day = date.getDay(); // 0 - 6
               	var session = "AM";
               	
               	var weekday = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][day];
               
               	
               	if(h >= 12) session = "PM";
               	
               	if(h == 0){
               		h = 12;
               	}
               	
               	if(h > 12){
               		h = h - 12;
               	}
               	
               	h = (h < 10) ? "0" + h : h;
               	m = (m < 10) ? "0" + m : m;
               	s = (s < 10) ? "0" + s : s;
               	
               	var time = weekday + "  " + h + ":" + m + ":" + s + " " + session;
               	document.getElementById("MyClockDisplay").innerText = time;
               	document.getElementById("MyClockDisplay").textContent = time;
               	
               	setTimeout(showTime, 1000);
               	
               }
               showTime();
            </script>
            <!--End Clock Section-->
            <div class="top-menu">
               <ul class="nav navbar-nav pull-right">
                  <!--NOTIFICATION SECTION-->
                  <!-- END NOTIFICATION DROPDOWN -->
                  <?php if( !empty( $user_data ) ){ ?>
                  <li class="dropdown dropdown-user">
                     <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                     <?php //$defalut_logo = 'yatra_logo.png'; ?>
                     <?php $defalut_logo = $user_data[0]->gender == "female" ? "profile_f.png" : "profile_m.png"; ?>
                     <?php $usr_pic = $user_data[0]->user_pic ? $user_data[0]->user_pic : $defalut_logo; ?>
                     <img alt="" class="img-circle" src="<?php echo site_url() . 'site/images/userprofile/' . $usr_pic;?>" />
                     <span class="username username-hide-on-mobile"> <?php echo ucfirst($user_data[0]->first_name) ? ucfirst($user_data[0]->first_name): ucfirst($user_data[0]->user_name); ?> </span>
                     <i class="fa fa-angle-down"></i>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                           <a href="<?php echo site_url("dashboard/profile"); ?>">
                           <i class="icon-user"></i> My Profile </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                           <a href="<?php echo site_url("dashboard/logout");?>">
                           <i class="icon-key"></i> Log Out </a>
                        </li>
                     </ul>
                  </li>
                  <!-- END USER LOGIN DROPDOWN -->
                  <!-- END QUICK SIDEBAR TOGGLER -->
                  <?php }else{ ?>
                  <li class="">
                     <a href="<?php echo site_url("login");?>" >
                     <i class="icon-login"></i>Login
                     </a>
                  </li>
                  <?php } ?>
               </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
         </div>
         <!-- END HEADER INNER -->
      </div>
      <!-- END HEADER -->
      <!-- BEGIN HEADER & CONTENT DIVIDER -->
      <div class="clearfix"> </div>
      <!-- END HEADER & CONTENT DIVIDER -->
      <!-- BEGIN CONTAINER -->
      <div class="page-container">
      <!--update user login status-->
      <?php update_user_online_status(); ?>
      <!--FULL PAGE LOADER-->
      <div class="fullpage_loader"></div>
      <script>
         var LOADER = jQuery('.fullpage_loader'); 
         var BASE_URL = "<?php echo base_url(); ?>"; 
      </script>