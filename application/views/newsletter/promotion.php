<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Track Itinerary</title>
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/plugins.min.css" rel="stylesheet" type="text/css" />
      <link href="<?php echo base_url();?>site/assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
      <link rel="shortcut icon" href="favicon.ico" />
      <style>
         .page-content {width: 800px;
         padding: 20px;
         border: 1px dashed #b7b7b7;
         margin: 20px auto 0;
         box-shadow: 0 8px 107px 0 rgba(0,0,0,.2), 0 6px 155px 0 rgba(0, 0, 0, 0);}
         .logo{margin-bottom: 30px; background: #3598dc; padding:10px;}
         .feedback{margin:20px 0;}
         .error {color: red; font-size: 13px;}
         .copyright.text-center {margin: 20px 0;}
         td.disabled.day {
         color: #ccc;
         }
         .datepicker .day {font-weight: 500!important;}
         th.datepicker-switch {
         color: #fff !important;
         text-align: center;
         }
         .datepicker-days thead tr:nth-child(1),
         .datepicker-days thead tr:nth-child(2) {
         background: #364150;
         color: #fff !important;
         }
         .datepicker-days thead tr:nth-child(2) i{color:#fff;}
         .datepicker.dropdown-menu {
         box-shadow: 0px 0px 100px rgba(0, 0, 0, 0.34);
         }
         .postpone-label {margin-top: 30px;}
      </style>
   </head>
   <body class="status">
      <?php $news = $newsletter[0];  ?>
      <?php if($news){ ?>
      <div class="content">
         <div class="container">
            <div class="page-content">
               <div class="logo text-center"><a href="https://www.trackitineray.com/"><img src="<?php echo site_url() ?>site/images/trackv2-logo.png" alt="Track Itinerary"></a></div>
               <div class="newsletter_section">
                  <h2 class='text-center'><?php echo $news->subject; ?></h2>
                  <?php echo htmlspecialchars_decode($news->body); ?>
               </div>
               <?php
                  $url = $news->youtube_link;
                  $regex_pattern = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
                  $match;
                  if( !empty($url) ){
                  	if( preg_match($regex_pattern, $url, $match)){ ?>
               <?php if( isset( $match[4] ) ){ ?>
               <div class="youtube_section text-center">
                  <h3 class='text-center'>Check out video. </h3>
                  <iframe width="420" height="315" src="https://www.youtube.com/embed/<?php echo $match[4]; ?>"> </iframe> 
               </div>
               <?php } ?>	
               <?php }else{
                  echo "Sorry, not a youtube URL";
                  } 
                  }
                  ?>
               <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="copyright text-center"> <?php echo date("Y"); ?> © Track Itinerary.</div>
         </div>
      </div>
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
      <?php }else{ ?>
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="error-template">
                  <h1>
                     Oops!
                  </h1>
                  <h2>
                     404 Not Found
                  </h2>
                  <div class="error-details">
                     Sorry, an error has occured, Requested page not found!
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php die();
         } ?>	
   </body>
</html>