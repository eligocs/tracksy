<!doctype html/>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Track Iitinerary Pvt. Lmt.</title>
      <!-- Bootstrap -->
      <!-- Latest compiled and minified CSS -->
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Nixie+One" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
      <!--link href="<?php //echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" /-->	
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <!--link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" / -->
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!--link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/components.min.css" -->
      <link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" />
   </head>
   <body>
      <?php 
         if( !empty($itinerary[0] ) ){
         
         	//dump($itinerary[0]); die;
         	
         	$iti = $itinerary[0];
         	$terms = get_terms_condition();
         	$online_payment_terms	 	= isset($terms[0]) && !empty($terms[0]->bank_payment_terms_content) ? unserialize($terms[0]->bank_payment_terms_content) : "";
         	$advance_payment_terms		= isset($terms[0]) && !empty($terms[0]->advance_payment_terms) ? unserialize($terms[0]->advance_payment_terms	) : "";
         	$cancel_tour_by_client 		= isset($terms[0]) && !empty($terms[0]->cancel_content) ? unserialize( $terms[0]->cancel_content) : "";
         	$terms_condition			= isset($terms[0]) && !empty($terms[0]->terms_content) ? unserialize($terms[0]->terms_content) : "";
         	$disclaimer 				= isset($terms[0]) && !empty($terms[0]->disclaimer_content) ? htmlspecialchars_decode($terms[0]->disclaimer_content) : "";
         	$greeting 					= isset($terms[0]) && !empty($terms[0]->greeting_message) ? $terms[0]->greeting_message : "";
         	$amendment_policy			= isset($terms[0]) && !empty($terms[0]->amendment_policy) ? unserialize( $terms[0]->amendment_policy) : "";
         	$book_package_terms			= isset($terms[0]) && !empty($terms[0]->book_package) ? unserialize( $terms[0]->book_package) : "";
         	$signature					= isset($terms[0]) && !empty($terms[0]->promotion_signature) ?  htmlspecialchars_decode($terms[0]->promotion_signature) : "";
         	$payment_policy				= isset($terms[0]) && !empty($terms[0]->payment_policy) ? unserialize($terms[0]->payment_policy) : "";
         	
         	//Get customer info
         	$get_customer_info = get_customer( $iti->customer_id ); 
         	$cust = $get_customer_info[0];
         	if( !empty( $get_customer_info ) ){  
         		$customer_name = $cust->customer_name;
         		$customer_contact = $cust->customer_contact;
         		$customer_email = $cust->customer_email;
         	}else{
         		$customer_name = "";
         		$customer_contact = "";
         		$customer_email = "";
         	}
         	
                $agent_id = $iti->agent_id;
         	$user_info = get_user_info($agent_id);
         	$agent = !empty( $user_info[0] ) ? $user_info[0] : "" ;
         	//	echo "<strong>Regards</strong><br>";
         		//echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
         	//	echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
         	//	echo "<strong>Email : </strong> " . $agent->email . "<br>";
         	//	echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
         	//	echo "<strong>Website : </strong> " . $agent->website;
         	
         	
         	?>
      <div class="container-fluid bothwrapper">
         <div class="row">
            <div class="col-md-5 left-wrapper">
               <div class="event-banner-wrapper">
                  <div class="col-lg-4">
                     <div class="logo">
                        <img src="<?php echo base_url();?>site/images/trackv2-logo.png" class="template_logo img-responsive">
                     </div>
                  </div>
                  <div class="col-lg-8">
                     <div class="address_bar">
                        <ul>
                           <li>Phone No: <?php echo company_contact(); ?></li>
                           <li>Email:<?php echo company_email(); ?></li>
                           <li>Website:www.trackitinerary.com</li>
                        </ul>
                     </div>
                  </div>
                  <!----slider---->
                  <?php if( !empty( $slider_data ) ){	?>
                  <div id="carousel-images" class="carousel slide" data-ride="carousel">
                     <!-- Wrapper for slides -->
                     <div class="carousel-inner" role="listbox">
                        <?php 
                           $i=1;
                           foreach( $slider_data as $slider ){ ?>		
                        <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>" >
                           <?php $slide_img_path = site_url() . 'site/images/sliders/' . $slider->image_url; ?>
                           <img src="<?php echo $slide_img_path ?>" alt="">
                           <div class="carousel-caption">
                           </div>
                        </div>
                        <?php 
                           $i++;
                           } ?>	
                     </div>
                     <!-- Controls -->
                     <a class="left carousel-control" href="#carousel-images" role="button" data-slide="prev">
                     <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="right carousel-control" href="#carousel-images" role="button" data-slide="next">
                     <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
                  <?php } ?>
                  <!----slider end---->
                  <!---- video slider ---->
                  <?php if( !empty( $youtube_data ) ){ ?>
                  <div class="videoCarousel">
                     <div class="carousel slide row" id="myCarousel">
                        <div class="carousel-inner">
                           <?php 
                              $i=1;
                              foreach( $youtube_data as $youtube ){ ?>		
                           <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>" >
                              <div class="col-xs-4">
                                 <?php 
                                    $poster_img = site_url() . 'site/images/youtube_poster/' . $youtube->poster_url;
                                    $url = $youtube->youtube_vid_url; 
                                    $ytarray = explode("/", $url);
                                    $ytendstring=end($ytarray);
                                    $ytendarray=explode("?v=", $ytendstring);
                                    $ytendstring=end($ytendarray);
                                    $ytendarray=explode("&", $ytendstring);
                                    $ytVid_id = $ytendarray[0];								
                                    ?> 
                                 <a href="#" class="vid_modal_link" data-backdrop="static" data-youtube-link="https://www.youtube.com/embed/<?php echo $ytVid_id; ?>" >
                                 <img src="<?php echo $poster_img; ?>" class="img-responsive">
                                 </a>
                              </div>
                           </div>
                           <?php 
                              $i++;
                              } ?>
                        </div>
                        <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
                        <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a>
                     </div>
                  </div>
                  <?php } ?>	
                  <!---- video slider end ---->
                  <!--<div class="embed-responsive embed-responsive-16by9 video_play">
                     <h1>video</h1>
                     	  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                     </div> -->
                  <!--Section: Testimonials-->
                  <?php if( !empty( $reviews_data ) ){  ?>
                  <div id="carousel-testimonials" class="carousel slide" data-ride="carousel">
                     <!-- Indicators -->
                     <!-- Wrapper for slides -->
                     <div class="carousel-inner" role="listbox">
                        <?php 
                           $i=1;
                           foreach( $reviews_data as $review ){ ?>		
                        <div class="item <?php echo ($i == 1) ? 'active' : ''; ?>" >
                           <div class="carousel-caption">
                              <h6 class="pull-left">New</h6>
                              <?php 
                                 $feedBack = strip_tags( $review->feedback );
                                 if(strlen($feedBack) >= 120) {
                                 	$cmt =  substr($feedBack,0,119)."...";
                                 } else {
                                 	$cmt =  $feedBack;
                                 }
                                 ?>
                              <p><?php echo $cmt; ?></p>
                              <?php 
                                 //rating
                                 $total_review = $review->rating;	
                                 $check1 ="";
                                 $check2 ="";
                                 $check3 ="";
                                 $check4 ="";
                                 $check5 ="";
                                 //Checked Rating
                                 switch( $total_review ){
                                 	case 4:
                                 		$check5 = "no-rating";
                                 	break;
                                 	case 3:
                                 		$check4 = "no-rating";
                                 		$check5 = "no-rating";
                                 	break;
                                 	case 2:
                                 		$check3 = "no-rating";
                                 		$check4 = "no-rating";
                                 		$check5 = "no-rating";
                                 	break;
                                 	case 1:
                                 		$check2 = "no-rating";
                                 		$check3 = "no-rating";
                                 		$check4 = "no-rating";
                                 		$check5 = "no-rating";
                                 	break;
                                 	default:
                                 		$check1 ="";
                                 		$check2 ="";
                                 		$check3 ="";
                                 		$check4 ="";
                                 		$check5 ="";
                                 	break;	
                                 } ?>
                              <div class="star-rating">
                                 <span class="fa fa-star <?php echo $check1; ?>" data-rating="1"></span>
                                 <span class="fa fa-star <?php echo $check2; ?>" data-rating="2"></span>
                                 <span class="fa fa-star <?php echo $check3; ?>" data-rating="3"></span>
                                 <span class="fa fa-star <?php echo $check4; ?>" data-rating="4"></span>
                                 <span class="fa fa-star <?php echo $check5; ?>" data-rating="5"></span>
                              </div>
                              <div class="client"><span class="customer-name"><?php echo $review->client_name; ?></span> | <span class="mobile-no"><?php echo $review->client_contact; ?></span></div>
                              <p class="text-center"><a href="<?php echo site_url("promotion/testimonials"); ?>" class="btn-testimonial">Read More</a></p>
                           </div>
                        </div>
                        <?php 
                           $i++;
                           } ?>	
                     </div>
                     <!-- Controls -->
                     <a class="left carousel-control" href="#carousel-testimonials" role="button" data-slide="prev">
                     <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="right carousel-control" href="#carousel-testimonials" role="button" data-slide="next">
                     <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
                  <?php } ?>	
                  <!--Section: Testimonials end-->
                  <!----end video player---->
                  <p class="comp-link">Sent by <a href="http://trackitinerary.com" target="_blank">Track Itinerary.com</a></p>
               </div>
            </div>
            <?php 
               //check benefits 
               $benefits_m = unserialize($iti->booking_benefits_meta); 
               $count_bn_inc = count( $benefits_m );
               ?>
            <div class="col-md-7 right-wrapper">
               <div class="event-ticket-wrapper">
                  <div class="event-tab">
                     <!-- Nav tabs -->
                     <ul class="nav nav-tabs" id="tab_lising" role="tablist">
                        <li role="presentation" class="active"><a href="#pack_overview" aria-controls="pack_overview" role="tab" data-toggle="tab" aria-expanded="false">Introduction</a></li>
                        <li role="presentation" class=""><a href="#itinerary_tab" aria-controls="itinerary_tab" role="tab" data-toggle="tab" aria-expanded="false">ITINERARY</a></li>
                        <li role="presentation" class=""><a href="#incExcSection" aria-controls="incExcSection" role="tab" data-toggle="tab" aria-expanded="false">INCLUSION</a></li>
                        <?php if( !empty($benefits_m) ){  ?>
                        <li role="presentation" class="blink_li">
                           <a href="#benefits_tab" aria-controls="benefits_tab" role="tab" data-toggle="tab" aria-expanded="true">
                              <blink>Benefits</blink>
                           </a>
                        </li>
                        <?php } ?>
                        <li role="presentation" class=""><a href="#hotel_details_tab" aria-controls="hotel_details_tab" role="tab" data-toggle="tab" aria-expanded="false">Hotel Details</a></li>
                        <li role="presentation" class=""><a href="#how_to_book_tab" aria-controls="how_to_book_tab" role="tab" data-toggle="tab" aria-expanded="false">How to Book</a></li>
                        <li role="presentation" class=""><a href="#termCondition" aria-controls="termCondition" role="tab" data-toggle="tab" aria-expanded="true">T&C </a></li>
                     </ul>
                     <!-- Tab panes -->
                     <div class="tab-content client-view">
                        <!-- PACKAGE Overview Section -->
                        <div role="tabpanel" class="tab-pane fade active in" id="pack_overview">
                           <p><strong>Hi, <?php echo $customer_name; ?></strong> </p>
                           <p><strong class="clrblue">GREETINGS FROM  Track Itinerary </strong></p>
                           <?php echo company_info(); ?>
                           <!--get company info -->
                           <?php $company_info = get_company_details();
                              /*
                              if( !empty( $company_info ) ){ 
                              echo "<div class='well'>";
                              echo "<h3>Who we are</h3>";
                              echo html_entity_decode($company_info[0]->who_we_are);
                              echo "</div>";
                              
                              echo "<div class='well'>";
                              echo "<h3>What we do</h3>";
                              echo html_entity_decode($company_info[0]->what_we_do);
                              echo "</div>";
                              
                              echo "<div class='well'>";
                              echo "<h3>Why choose us</h3>";
                              echo html_entity_decode($company_info[0]->why_choose_us);
                              echo "</div>";
                              }
                              */
                              ?>
                           <!--Itinaray tab section -->
                           <div id="itinerary_tab">
                              <h2> <span id="Label1">Package Overview</span></h2>
                              <!--p><?php //echo $greeting; ?></p-->
                              <div class="table-responsive">
                                 <table class="table package-details-table table-striped table-bordered table-hover" >
                                    <tr>
                                       <th width="30%" class="thead-inverse"><i class="fa fa-gift" aria-hidden="true"></i> Name of Package	</th>
                                       <td><?php echo $iti->package_name; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-road" aria-hidden="true"></i> Routing</th>
                                       <td><?php echo $iti->package_routing; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-clock-o" aria-hidden="true"></i> Duration</th>
                                       <td><?php echo $iti->duration; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-users" aria-hidden="true"></i>  No of Travellers</th>
                                       <td><?php
                                          echo "<strong> Adults: </strong> " . $iti->adults; 
                                          if( !empty( $iti->child ) ){
                                          	echo "<strong> No. of Child: </strong> " . $iti->child; 
                                          	echo "<strong> Child age: </strong> " . $iti->child_age; 
                                          }
                                          ?>
                                       </td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-taxi" aria-hidden="true"></i> Cab Category</th>
                                       <td><?php echo get_car_name( $iti->cab_category); ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-calendar" aria-hidden="true"></i> Quotation Date</th>
                                       <td><?php echo display_date_month_name($iti->quatation_date); ?></td>
                                    </tr>
                                    <?php
                                       $room_category = $total_rooms = $with_extra_bed  = $without_extra_bed = "-";
                                       if( isset( $iti->rooms_meta) && !empty( $iti->rooms_meta ) ){
                                       	$rooms_meta 	= unserialize( $iti->rooms_meta );
                                       	$room_category 	= isset($rooms_meta["room_category"]) && !empty( $rooms_meta["room_category"] ) ? get_roomcat_name($rooms_meta["room_category"]) : "-";
                                       	$total_rooms 		= isset($rooms_meta["total_rooms"]) && !empty( $rooms_meta["total_rooms"] ) ? $rooms_meta["total_rooms"] : "-";
                                       	$with_extra_bed 	= isset($rooms_meta["with_extra_bed"]) && !empty( $rooms_meta["with_extra_bed"] ) ? $rooms_meta["with_extra_bed"] : "No";
                                       	$without_extra_bed 	= isset($rooms_meta["without_extra_bed"]) && !empty( $rooms_meta["without_extra_bed"] )  ? $rooms_meta["without_extra_bed"] : "No";
                                       }  
                                       
                                       
                                       ?>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-building" aria-hidden="true"></i> Room Category</th>
                                       <td><?php echo $room_category; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-home" aria-hidden="true"></i> Total Rooms</th>
                                       <td><?php echo $total_rooms; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-bed" aria-hidden="true"></i> With extra bed</th>
                                       <td><?php echo $with_extra_bed; ?></td>
                                    </tr>
                                    <tr>
                                       <th class="thead-inverse"><i class="fa fa-bed" aria-hidden="true"></i>Without extra bed</th>
                                       <td><?php echo $without_extra_bed; ?></td>
                                    </tr>
                                 </table>
                              </div>
                              <div class="day-wise-itneray">
                                 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <h2>DETAILED ITINERARY:</h2>
                                    <?php $day_wise = $iti->daywise_meta; 
                                       $tourData = unserialize($day_wise);
                                       $count_day = count( $tourData );
                                       if( $count_day > 0 ){
                                       	//print_r( $tourData );
                                       	$count = 1;
                                       	for ( $i = 0; $i < $count_day; $i++ ) {
                                       		//echo ""; ?>
                                    <span class="simple-day">Day</span>
                                    <div class="panel panel-default">
                                       <div class="panel-heading" role="tab" id="iti_<?php echo $count; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $count; ?>" aria-expanded="true" aria-controls="collapseOne">
                                          <h4><span class="day1 <?php echo strtolower($tourData[$i]['tour_day']); ?>"><?php echo $tourData[$i]['tour_day']; ?> </span> <?php echo $tourData[$i]['tour_name'] . '( ' . $tourData[$i]['tour_distance'] . ' KMS )'; ?>  </h4>
                                          <span class="date"><i class="fa fa-calendar-check-o" aria-hidden="true"></i><?php echo display_date_month($tourData[$i]['tour_date']) ; ?></span>
                                       </div>
                                       <div id="collapse_<?php echo $count; ?>" class="panel-collapse collapse in <?php //if( $count ==1 ){ echo "in"; } ?>" role="tabpanel" aria-labelledby="iti_<?php echo $count; ?>">
                                          <div class="panel-body">
                                             <p><?php echo $tourData[$i]['tour_des'] ; ?></p>
                                             <span class="meal"><i class="fa fa-cutlery" aria-hidden="true"></i> <?php echo $tourData[$i]['meal_plan']; ?> </span>
                                          </div>
                                          <?php if( isset($tourData[$i]['hot_des'] ) && !empty( $tourData[$i]['hot_des'] ) ){
                                             $hot_dest = '';
                                             $htd = explode(",", $tourData[$i]['hot_des']);
                                             foreach($htd as $t) {
                                             	$t = trim($t);
                                             	$hot_dest .= "<span>" . $t . "</span>";
                                             }	?>
                                          <div class="hot_destination_view">
                                             <div class="day_yellow"><i class="fa fa-map-marker" aria-hidden="true"></i>Attraction :</div>
                                             <?php echo $hot_dest; ?>
                                          </div>
                                          <?php }	?>
                                       </div>
                                    </div>
                                    <?php 
                                       $count++;
                                       }
                                       }
                                       
                                       ?>
                                 </div>
                              </div>
                           </div>
                           <!--End Itinaray tab section -->
                           <!--Inclusion exclusion section -->
                           <div id="incExcSection">
                              <h2> INCLUSION & EXCLUSION</h2>
                              <div class="table-responsive inclusion">
                                 <h5> Inclusion  </h5>
                                 <?php 
                                    $inclusion = unserialize($iti->inc_meta); 
                                    $count_inc = count( $inclusion );
                                    $exclusion = unserialize($iti->exc_meta); 
                                    $count_exc = count( $exclusion );
                                    echo "   <ul class='inclusion'>";
                                    if( $count_inc > 0 ){
                                    	for ( $i = 0; $i < $count_inc; $i++ ) {
                                    		echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i>" . $inclusion[$i]["tour_inc"] . "</li>";
                                    	}	
                                    }
                                    echo "</ul>"; 
                                    //check if special inclusion exists
                                    $sp_inc = unserialize($iti->special_inc_meta); 
                                    $count_sp_inc = count( $sp_inc );
                                    if( !empty($sp_inc) ){  ?>
                                 <h5> Special Inclusions  </h5>
                                 <?php
                                    echo "   <ul class='inclusion'>";
                                    if( $count_sp_inc > 0 ){
                                    	for ( $i = 0; $i < $count_sp_inc; $i++ ) {	
                                    		echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i>" . $sp_inc[$i]["tour_special_inc"] . "</li>";
                                    	}	
                                    }
                                    echo "</ul>";
                                    }
                                    echo "<h5>Exclusion</h5> <ul class='exclusion'>";
                                    if( $count_exc > 0 ){
                                    for ( $i = 0; $i < $count_exc; $i++ ) {
                                    	echo "<li> <i class='fa fa-times-circle-o' aria-hidden='true'></i>" . $exclusion[$i]["tour_exc"] . "</li>";
                                    }	
                                    }
                                    echo "</ul>";
                                    ?>
                              </div>
                           </div>
                           <!--End Inclusion exclusion section -->
                           <!--Benefits-->
                           <?php if( !empty($benefits_m) ){  ?>
                           <div id="benefits_tab">
                              <h2 style="background: red; color: #fff;">Benefits of Booking With Us:</h2>
                              <?php
                                 echo "   <ul class='inclusion'>";
                                 if( $count_bn_inc > 0 ){
                                 	for ( $i = 0; $i < $count_bn_inc; $i++ ) {
                                 		$si = isset($benefits_m[$i]['benefit_inc']) ? $benefits_m[$i]['benefit_inc']: "";
                                 		echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i> " . $si . "</li>";
                                 	}	
                                 }
                                 echo "</ul>"; ?>
                           </div>
                           <?php } ?><!--END Benefits-->
                           <!--Start Hotel Details section -->
                           <div id="hotel_details_tab">
                              <h2>Hotel Details 
                                 <?php 
                                    $f_cost =  !empty( $iti->final_amount ) && get_iti_booking_status( $iti->iti_id ) == 0 ? "<strong class='green'> " . number_format($iti->final_amount) . " /-</strong> " : "";
                                    //echo $f_cost;
                                    //if final price exists strike all price
                                    $strike_class_final = !empty( $iti->final_amount ) && get_iti_booking_status($iti->iti_id) == 0 ? "strikeLine" : "";
                                    ?> 
                              </h2>
                              <div class="table-2">
                                 <?php $hotel_meta = unserialize($iti->hotel_meta); 
                                    if( !empty( $hotel_meta ) ){
                                    	$count_hotel = count( $hotel_meta ); ?>
                                 <div class="table-responsive">
                                    <table class="table table-bordered">
                                       <thead class="thead-default">
                                          <tr>
                                             <th class="thead-inverse"> <strong>Hotel <span>Category</span></strong></th>
                                             <th class="thead-inverse"> <strong>Deluxe</strong></th>
                                             <th class="thead-inverse"> <strong>Super Deluxe</strong></th>
                                             <th class="thead-inverse"> <strong>Luxury</strong></th>
                                             <th class="thead-inverse"> <strong>Super Luxury</strong></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php 
                                             /* print_r( $hotel_meta );  final_amount */
                                             if( $count_hotel > 0 ){
                                             	//get percentage added by agent
                                             	$agent_price_percentage = !empty($iti->agent_price) ? $iti->agent_price : 0;
                                             	
                                             	for ( $i = 0; $i < $count_hotel; $i++ ) {
                                             		echo "<tr><td><strong>" .$hotel_meta[$i]["hotel_location"] . "</strong></td><td>";
                                             			$hotel_standard =  $hotel_meta[$i]["hotel_standard"];
                                             			echo $hotel_standard;
                                             		echo "</td><td >";
                                             			$hotel_deluxe =  $hotel_meta[$i]["hotel_deluxe"];
                                             			echo $hotel_deluxe;
                                             		echo "</td><td>";
                                             			$hotel_super_deluxe =  $hotel_meta[$i]["hotel_super_deluxe"];
                                             			echo $hotel_super_deluxe;
                                             		echo "</td><td>";
                                             			$hotel_luxury =  $hotel_meta[$i]["hotel_luxury"];
                                             			echo $hotel_luxury;
                                             		echo "</td></tr>";
                                             	} 	
                                             	//Rate meta
                                             	$rate_meta = unserialize($iti->rates_meta);
                                             	$strike_class = !empty( $discountPriceData ) ? "strikeLine" : " ";
                                             	//print_r( $rate_meta );
                                             	if( !empty( $rate_meta ) && $iti->pending_price == 2 ){
                                             		//get per person price
                                             		$per_person_ratemeta 	= unserialize($iti->per_person_ratemeta);
                                             		$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                                             		
                                             		$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"]) ? " Rs." . $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                                             		$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? " Rs." . $per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                                             		$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? " Rs." . $per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100 . " Per/Person" : "";
                                             		$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? " Rs." . $per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100  . " Per/Person" : "";
                                             
                                             		//child rates
                                             		$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " .  number_format( $per_person_ratemeta["child_standard_rates"]  + $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100  ) . "/- Per Child" : "";
                                             		
                                             		$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                             		
                                             		$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format( $per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                             		
                                             		$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " .   number_format( $per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";													
                                             		
                                             		$standard_rates = !empty( $rate_meta["standard_rates"]) ? number_format($rate_meta["standard_rates"] + $rate_meta["standard_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                                             		
                                             		$deluxe_rates = !empty( $rate_meta["deluxe_rates"]) ? number_format($rate_meta["deluxe_rates"] + $rate_meta["deluxe_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                                             		
                                             		$super_deluxe_rates = !empty( $rate_meta["super_deluxe_rates"]) ? number_format($rate_meta["super_deluxe_rates"] + $rate_meta["super_deluxe_rates"] * $agent_price_percentage / 100  ) . "/-" : "<strong class='red'>On Request</strong>";
                                             		$rate_luxry = !empty( $rate_meta["luxury_rates"]) ? number_format($rate_meta["luxury_rates"] + $rate_meta["luxury_rates"] * $agent_price_percentage / 100 ) . "/-" : "<strong class='red'>On Request</strong>";
                                             	    
                                             	    
                                             		echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td>
                                             				<td>
                                             					Rs. <strong>" . $standard_rates. "</strong> {$inc_gst} <br> {$s_pp} <br> {$child_s_pp} 
                                             				</td>
                                             				<td>
                                             					Rs. <strong>" .$deluxe_rates. "</strong> {$inc_gst} <br> {$d_pp}<br> {$child_d_pp} 
                                             				</td>
                                             				<td>
                                             					Rs. <strong>" . $super_deluxe_rates. "</strong> {$inc_gst} <br> {$sd_pp}<br> {$child_sd_pp} 
                                             				</td>
                                             				<td>
                                             					Rs. <strong>" . $rate_luxry . "</strong> {$inc_gst} <br> {$l_pp}<br> {$child_l_pp} 
                                             				</td></tr>";
                                             	}else{
                                             		echo "<tr><td><strong class='red'>Price</strong></td>
                                             				<td>
                                             					<strong class='red'> Coming Soon </strong>
                                             				</td>
                                             				<td>
                                             					<strong class='red'> Coming Soon</strong>
                                             				</td>
                                             				<td>
                                             					<strong class='red'> Coming Soon </strong>
                                             				</td>
                                             				<td>
                                             					<strong class='red'> Coming Soon </strong>
                                             				</td></tr>";
                                             	}
                                             	
                                             	//discount data
                                             	if( !empty( $discountPriceData ) ){
                                             		foreach( $discountPriceData as $price ){
                                             			$agent_price_percentage = !empty($price->agent_price) ? $price->agent_price : 0;
                                             			$sent_status = $price->sent_status;
                                             			if( $sent_status ){
                                             				//get per person price
                                             				$per_person_ratemeta 	= unserialize($price->per_person_ratemeta);
                                             				$inc_gst = isset( $per_person_ratemeta["inc_gst"] ) && $per_person_ratemeta["inc_gst"] == 1 ? "(GST Inc.)" : "(GST Extra)";
                                             				$s_pp = isset( $per_person_ratemeta["standard_rates"] ) && !empty($per_person_ratemeta["standard_rates"] ) ? "RS. " . number_format( $per_person_ratemeta["standard_rates"] +  $per_person_ratemeta["standard_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                             				$d_pp = isset( $per_person_ratemeta["deluxe_rates"] ) && !empty($per_person_ratemeta["deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["deluxe_rates"] +  $per_person_ratemeta["deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                             				$sd_pp = isset( $per_person_ratemeta["super_deluxe_rates"] ) && !empty($per_person_ratemeta["super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["super_deluxe_rates"] +  $per_person_ratemeta["super_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Person" : "";
                                             				$l_pp = isset( $per_person_ratemeta["luxury_rates"] ) && !empty($per_person_ratemeta["luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["luxury_rates"] +  $per_person_ratemeta["luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Person" : "";
                                             				
                                             				//child rates
                                             				$child_s_pp = isset( $per_person_ratemeta["child_standard_rates"] ) && !empty($per_person_ratemeta["child_standard_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_standard_rates"] +  $per_person_ratemeta["child_standard_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                             				$child_d_pp = isset( $per_person_ratemeta["child_deluxe_rates"] ) && !empty($per_person_ratemeta["child_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_deluxe_rates"] +  $per_person_ratemeta["child_deluxe_rates"] * $agent_price_percentage/100) . "/- Per Child" : "";
                                             				$child_sd_pp = isset( $per_person_ratemeta["child_super_deluxe_rates"] ) && !empty($per_person_ratemeta["child_super_deluxe_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_super_deluxe_rates"] +  $per_person_ratemeta["child_super_deluxe_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";
                                             				$child_l_pp = isset( $per_person_ratemeta["child_luxury_rates"] ) && !empty($per_person_ratemeta["child_luxury_rates"]) ? "RS. " . number_format($per_person_ratemeta["child_luxury_rates"] +  $per_person_ratemeta["child_luxury_rates"] * $agent_price_percentage/100 ) . "/- Per Child" : "";			
                                             				
                                             				//get rates
                                             				$s_price = !empty( $price->standard_rates) ? number_format($price->standard_rates + $price->standard_rates * $agent_price_percentage/100 ) . "/- {$inc_gst} <br> {$s_pp} <br> {$child_s_pp}" : "<strong class='red'>On Request</strong>";
                                             				
                                             				$d_price = !empty( $price->deluxe_rates) ? number_format($price->deluxe_rates + $price->deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$d_pp} <br> {$child_d_pp}" : "<strong class='red'>On Request</strong>";
                                             				
                                             				$sd_price = !empty( $price->super_deluxe_rates) ? number_format($price->super_deluxe_rates + $price->super_deluxe_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$sd_pp} <br> {$child_sd_pp}"  : "<strong class='red'>On Request</strong>";
                                             				
                                             				$l_price = !empty( $price->luxury_rates) ? number_format($price->luxury_rates + $price->luxury_rates * $agent_price_percentage/100) . "/- {$inc_gst} <br> {$l_pp} <br> {$child_l_pp}"  : "<strong class='red'>On Request</strong>";
                                             				
                                             				$count_price = count( $discountPriceData );
                                             				$strike_class = ($price !== end($discountPriceData) && $count_price > 1 ) ? "strikeLine" : "";
                                             		
                                             				echo "<tr class='{$strike_class} {$strike_class_final}'><td>Price</td><td>" . $s_price . "</td>";
                                             				echo "<td>" . $d_price . "</td>";
                                             				echo "<td>" . $sd_price . "</td>";
                                             				echo "<td>" . $l_price . "</td></tr>";
                                             			}	
                                             		}
                                             	}
                                             	
                                             	$rate_comment = isset( $iti->rate_comment ) && $iti->pending_price == 2 && $iti->discount_rate_request == 0 ? $iti->rate_comment : "";
                                             	echo "<tr><td colspan=5><p class='red'><strong>Note: </strong>{$rate_comment} </td></tr>";
                                             	echo "<tr><td colspan=5><p class='red'><strong>Final Package Cost: </strong>{$f_cost} </td></tr>";
                                             } ?>							
                                       </tbody>
                                    </table>
                                 </div>
                                 <!--If Flight Exists-->
                                 <?php if( isset( $flight_details ) && !empty( $flight_details ) && $iti->is_flight == 1 ){ ?>
                                 <?php $flight = $flight_details[0]; ?>
                                 <h2>Flight Details</h2>
                                 <div class="table-responsive">
                                    <table class="table table-bordered white-table-th">
                                       <tbody>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Trip Type</strong></td>
                                             <td width="33%"><strong>Flight Name</strong></td>
                                             <td width="33%"><strong>Class</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo ucfirst($flight->trip_type); ?></td>
                                             <td><?php echo $flight->flight_name; ?></td>
                                             <td><?php echo $flight->flight_class; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Departure City</strong></td>
                                             <td width="33%"><strong>Arrival city</strong></td>
                                             <td width="33%"><strong>No. of Passengers</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $flight->dep_city; ?></td>
                                             <td><?php echo $flight->arr_city; ?></td>
                                             <td><?php echo $flight->total_passengers; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Arrival Date/Time</strong></td>
                                             <td width="33%"><strong>Departure Date/Time</strong></td>
                                             <td width="33%"><strong>Return Date/Time</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $flight->arr_time; ?></td>
                                             <td><?php echo $flight->dep_date; ?></td>
                                             <td><?php echo $flight->return_date; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                                             <td width="33%"><strong>Price</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $flight->return_arr_date; ?></td>
                                             <td><?php echo $flight->flight_price; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                                 <hr>
                                 <?php } ?>
                                 <!--End Flight Section-->
                                 <!--If Train Exists-->
                                 <?php if( isset( $train_details ) && !empty( $train_details ) && $iti->is_train == 1 ){ ?>
                                 <?php $train = $train_details[0]; ?>
                                 <h2>Train Details</h2>
                                 <div class="table-responsive">
                                    <table class="table table-bordered white-table-th">
                                       <tbody>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Trip Type</strong></td>
                                             <td width="33%"><strong>Train Name</strong></td>
                                             <td width="33%"><strong>Train Number</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo ucfirst($train->t_trip_type); ?></td>
                                             <td><?php echo $train->train_name; ?></td>
                                             <td><?php echo $train->train_number; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Departure City</strong></td>
                                             <td width="33%"><strong>Arrival city</strong></td>
                                             <td width="33%"><strong>No. of Passengers</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $train->t_dep_city; ?></td>
                                             <td><?php echo $train->t_arr_city; ?></td>
                                             <td><?php echo $train->t_passengers; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Arrival Date/Time</strong></td>
                                             <td width="33%"><strong>Departure Date/Time</strong></td>
                                             <td width="33%"><strong>Return Date/Time</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $train->t_arr_time; ?></td>
                                             <td><?php echo $train->t_dep_date; ?></td>
                                             <td><?php echo $train->t_return_date; ?></td>
                                          </tr>
                                          <tr class="thead-inverse" >
                                             <td width="33%"><strong>Return Arrival Date/Time</strong></td>
                                             <td width="33%"><strong>Price</strong></td>
                                             <td width="33%"><strong>Class</strong></td>
                                          </tr>
                                          <tr>
                                             <td><?php echo $train->t_return_arr_date; ?></td>
                                             <td><?php echo $train->t_cost; ?></td>
                                             <td><?php echo $train->train_class; ?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                                 <hr>
                                 <?php } ?>
                                 <!--End Flight Section-->
                                 <h5>Notes:</h5>
                                 <ul class="client_listing">
                                    <?php $hotel_note_meta = unserialize($iti->hotel_note_meta); 
                                       $count_hotel_meta = count( $hotel_note_meta );
                                       
                                       if( $count_hotel_meta > 0 ){
                                       	for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
                                       		echo "<li> <i class='fa fa-angle-double-right' aria-hidden='true'></i>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
                                       	}	
                                       } ?>
                                 </ul>
                                 <?php } ?> 	
                              </div>
                           </div>
                           <!--End Hotel Details section -->
                           <!--End Hotel Details section -->
                           <!--How to book section-->
                           <div id="how_to_book_tab" class="clearfix">
                              <div class="col-md-12">
                                 <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                       <?php 
                                          //how to book section
                                          $count_book_package	= count( $book_package_terms );
                                          if(isset($book_package_terms["heading"]) ) { 
                                          	echo " <div class='panel-heading' role='tab' id='hwheadingOne' data-toggle='collapse' data-parent='#accordion' href='#hwcollapseOne' aria-expanded='true' aria-controls='hwcollapseOne'><span> ". $book_package_terms["heading"]  ." ? </span></div>";
                                          }
                                          echo "<div id='hwcollapseOne' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='hwheadingOne'>";
                                          if(isset($book_package_terms["sub_heading"]) ) { 
                                          	echo "<span class='booking_sub_heading'>". $book_package_terms["sub_heading"]  ."</span>";
                                          }  ?>
                                       <div class="table-responsive">
                                          <table class="table table-bordered">
                                             <tbody>
                                                <?php if( $count_book_package > 0 ){
                                                   $counter = 1;
                                                   for ( $i = 0; $i < $count_book_package-2; $i++ ) { 
                                                   	echo "<tr>";
                                                   	$book_title = isset($book_package_terms[$i]["hotel_book_terms"]) ? $book_package_terms[$i]["hotel_book_terms"] : "";
                                                   	$book_val = isset($book_package_terms[$i]["hotel_book_terms_right"]) ? $book_package_terms[$i]["hotel_book_terms_right"] : "";
                                                   	
                                                   	echo "<td>{$counter}</td><td>{$book_title}</td><td>{$book_val}</td>";
                                                   	echo "</tr>";
                                                   	$counter++;
                                                   }
                                                   }	
                                                   
                                                   ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="panel panel-default">
                                    <?php 
                                       // advance payment section 
                                       $count_ad_pay	= count( $advance_payment_terms );
                                       if(isset($advance_payment_terms["heading"]) ) { 
                                       	echo "<div class='panel-heading collapsed' role='tab' id='hwheadingTwo' data-toggle='collapse' data-parent='#accordion' href='#hwcollapseTwo' aria-expanded='false' aria-controls='hwcollapseTwo'><span>". $advance_payment_terms["heading"]  ."</span></div>";
                                       }	
                                       echo "<div id='hwcollapseTwo' class='panel-collapse collapse' role='tabpanel' aria-labelledby='hwheadingTwo'>";
                                       if( $count_book_package > 0 ){
                                       	echo "<div class='panel-body'><ul class='client_listing'>";
                                       		for ( $i = 0; $i < $count_ad_pay-1; $i++ ) { 
                                       			echo "<li><i class='fa fa-angle-double-right' aria-hidden='true'></i> " . $advance_payment_terms[$i]["terms"] . "</li>";
                                       		}
                                       	echo "</ul></div>";
                                       }
                                       ?>
                                 </div>
                              </div>
                              <!--payement policy-->
                              <div class="panel panel-default">
                                 <?php 
                                    // advance payment section 
                                    $count_pay_policy	= count( $payment_policy );
                                    if(isset($payment_policy["heading"]) ) { 
                                    	echo "<div class='panel-heading collapsed' role='tab' id='hwcollapseTen1' data-toggle='collapse' data-parent='#accordion' href='#hwcollapseTen' aria-expanded='false' aria-controls='hwcollapseTen'><span>". $payment_policy["heading"]  ."</span></div>";
                                    }	
                                    echo "<div id='hwcollapseTen' class='panel-collapse collapse' role='tabpanel' aria-labelledby='hwcollapseTen1'>";
                                    ?>
                                 <div class="table-responsive">
                                    <table class="table table-bordered">
                                       <tbody>
                                          <?php if( $count_pay_policy > 0 ){
                                             $counter = 1;
                                             for ( $i = 0; $i < $count_pay_policy-1; $i++ ) { 
                                             	echo "<tr>";
                                             	$book_title = isset($payment_policy[$i]["pay_policy"]) ? $payment_policy[$i]["pay_policy"] : "";
                                             	$book_val = isset($payment_policy[$i]["pay_policy_right"]) ? $payment_policy[$i]["pay_policy_right"] : "";
                                             	
                                             	echo "<td>{$counter}</td><td>{$book_title}</td><td>{$book_val}</td>";
                                             	echo "</tr>";
                                             	$counter++;
                                             }
                                             }	
                                             ?>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <!--end payement policy-->
                           <div class="panel panel-default">
                              <div class="panel-heading collapsed" role="tab" id="hwheadingThree"  data-toggle="collapse" data-parent="#accordion" href="#hwcollapseThree" aria-expanded="false" aria-controls="hwcollapseThree">
                                 <span>Bank Details: Cash/Cheque at Bank or Net Transfer</span>
                              </div>
                              <div id="hwcollapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="hwheadingThree">
                                 <div class="panel-body">
                                    <div class="table-responsive">
                                       <table class="table table-bordered">
                                          <thead class="thead-default">
                                             <tr>
                                                <th> Bank</th>
                                                <th> Payee Name</th>
                                                <th> A/c Type</th>
                                                <th> A/c No.</th>
                                                <th> Branch Address</th>
                                                <th> IFSC Code</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php $banks = get_all_banks(); 
                                                if( $banks ){
                                                	foreach( $banks as $bank ){ 
                                                		echo "<tr>";
                                                			echo "<td>" . $bank->bank_name . "</td>";
                                                			echo "<td>" . $bank->payee_name . "</td>";
                                                			echo "<td>" . $bank->account_type . "</td>";
                                                			echo "<td>" . $bank->account_number . "</td>";
                                                			echo "<td>" . $bank->branch_address . "</td>";
                                                			echo "<td>" . $bank->ifsc_code . "</td>";
                                                		echo "</tr>";
                                                	 }
                                                }
                                                ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="panel panel-default">
                              <?php
                                 //bank payment terms
                                 $count_bank_payment_terms	= count( $online_payment_terms ); 
                                 $count_bankTerms			= $count_bank_payment_terms-1; 
                                 if(isset($online_payment_terms["heading"]) ) { 
                                 	echo "<div class='panel-heading collapsed' role='tab' id='headingFour'  data-toggle='collapse' data-parent='#accordion' href='#collapseFour' aria-expanded='false' aria-controls='collapseFour'><span>" . $online_payment_terms["heading"] . "</span></div>"; 
                                 }
                                 echo "<div id='collapseFour' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingFour'>";
                                 if( $count_bankTerms > 0 ){
                                 	echo "<div class='panel-body'><ul class='client_listing'>";
                                 		for ( $i = 0; $i < $count_bankTerms; $i++ ) { 
                                 			echo "<li> <i class='fa fa-angle-double-right' aria-hidden='true'></i>" . $online_payment_terms[$i]["terms"] . "</li>";
                                 		}
                                 	echo "</ul></div>";
                                 } ?>
                           </div>
                        </div>
                        <div class="panel panel-default">
                           <?php //refund policy && cancel tour terms
                              if(isset($cancel_tour_by_client["heading"]) ) { 
                              	echo "<div class='panel-heading collapsed' role='tab' id='headingFive'  data-toggle='collapse' data-parent='#accordion' href='#collapseFive' aria-expanded='false' aria-controls='collapseFive'><span>". $cancel_tour_by_client["heading"]  ."</span></div>";
                              }
                              $count_cancel_content	= count( $cancel_tour_by_client );
                              echo "<div id='collapseFive' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingFive'>";
                              /*if( $count_cancel_content > 0 ){
                              	echo "<div class='panel-body'><ul class='client_listing'>";
                              		for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                              			echo "<li><i class='fa fa-angle-double-right' aria-hidden='true'></i> " . $cancel_tour_by_client[$i]["cancel_terms"] . "</li>";
                              		}
                              	echo "</ul></div>";
                              	
                              } */ ?>
                           <div class="table-responsive">
                              <table class="table table-bordered">
                                 <tbody>
                                    <?php if( $count_cancel_content > 0 ){
                                       $counter = 1;
                                       for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                                       	echo "<tr>";
                                       	$book_title = isset($cancel_tour_by_client[$i]["cancel_terms"]) ? $cancel_tour_by_client[$i]["cancel_terms"] : "";
                                       	$book_val = isset($cancel_tour_by_client[$i]["cancel_terms_right"]) ? $cancel_tour_by_client[$i]["cancel_terms_right"] : "";
                                       	
                                       	echo "<td>{$counter}</td><td>{$book_title}</td><td>{$book_val}</td>";
                                       	echo "</tr>";
                                       	$counter++;
                                       }
                                       }	
                                       ?>
                                 </tbody>
                              </table>
                           </div>
                           <?php 
                              echo "</div></div>";
                              ?>
                           <div class="panel panel-default">
                              <?php 
                                 //AMENDMENT POLICY section	
                                 if(isset($amendment_policy["heading"]) ) { 
                                 	echo "<div class='panel-heading collapsed' role='tab' id='headingSix'  data-toggle='collapse' data-parent='#accordion' href='#collapseSix' aria-expanded='false' aria-controls='collapseSix'><span>". $amendment_policy["heading"]  ."</span></div>";
                                 }	
                                 $count_amendment_policy	= count( $amendment_policy );
                                 echo "<div id='collapseSix' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingSix'>";
                                 /*if( $count_amendment_policy > 0 ){
                                 	echo "<div class='panel-body'><ul class='client_listing'>";
                                 		for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) { 
                                 			echo "<li><i class='fa fa-angle-double-right' aria-hidden='true'></i>" . $amendment_policy[$i]["amend_policy"] . "</li>";
                                 		}
                                 	echo "</ul></div>";
                                 } */ ?>
                              <div class="table-responsive">
                                 <table class="table table-bordered">
                                    <tbody>
                                       <?php if( $count_amendment_policy > 0 ){
                                          $counter = 1;
                                          for ( $i = 0; $i < $count_amendment_policy-1; $i++ ) { 
                                          	echo "<tr>";
                                          	$book_title = isset($amendment_policy[$i]["amend_policy"]) ? $amendment_policy[$i]["amend_policy"] : "";
                                          	$book_val = isset($amendment_policy[$i]["amend_policy_right"]) ? $amendment_policy[$i]["amend_policy_right"] : "";
                                          	
                                          	echo "<td>{$counter}<td>{$book_title}</td><td>{$book_val}</td>";
                                          	echo "</tr>";
                                          	$counter++;
                                          }
                                          }	
                                          ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!--End How to book section-->
               <!--Terms and condition-->
               <div id="termCondition">
                  <?php 
                     //terms and condition
                     if(isset($terms_condition["heading"]) ) { 
                     	echo "<div class=''><h2>". $terms_condition["heading"]  ."</h2></div>";
                     }
                     $count_cancel_content	= count( $terms_condition );
                     if( $count_cancel_content > 0 ){
                     	echo "<ul class='client_listing'>";
                     		for ( $i = 0; $i < $count_cancel_content-1; $i++ ) { 
                     			echo "<li><i class='fa fa-angle-double-right' aria-hidden='true'></i>" . $terms_condition[$i]["terms"] . "</li>";
                     		}
                     	echo "</ul>";
                     } ?>
                  <hr>
                  <?php //echo $signature; ?>
                  <div class="signature-section">
                     <?php 
                        echo "<strong>Regards</strong><br>";
                        echo "<strong> " . $agent->first_name . " " . $agent->last_name . "</strong><br>";
                        echo "<strong>Call Us : </strong> " . $agent->mobile . "<br>";
                        echo "<strong>Email : </strong> " . $agent->email . "," . "sales@trackitinerary.com" . "<br>";
                        echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
                        echo "<strong>Website : </strong> " . $agent->website . "<br>";
                        echo "<strong>Other Contacts : </strong> " .   "9218020636,9218004636,8091007636,9218016636,9218025636,9805744636,9805236000";
                        ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--Marquee tagline section -->
      <div class="tagline">
         <?php $tagline = get_tagline(); ?>
         <marquee><?php echo $tagline; ?></marquee>
      </div>
      <div class="cart">
         <div class="row">
            <div class="text-right">
               <a class="btn hide-mobile"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<?php echo $agent->mobile; ?></a>
               <a class="btn hide-desktop" href="tel:<?php echo $agent->mobile; ?>" title="Call Me">Call Me</a>
               <a class="btn" href="<?php echo site_url("promotion/pdf/{$iti->iti_id}/{$iti->temp_key}"); ?>" title="Download Pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
               <a class="btn" href="<?php echo site_url("promotion/contact_us"); ?>" title="Contact Us"> <i class="fa fa-address-card-o" aria-hidden="true"></i></a>
               <a class="btn" data-toggle="modal" data-target="#ticket-details"><i class="fa fa-commenting-o" aria-hidden="true"></i></a>
               <?php if( empty( $iti->final_amount ) && $iti->iti_status == 0 && is_online_payments_status() ){  ?>
               <?php 
                  //$enc_key 	 = base64_url_encode(md5( $this->config->item("encryption_key") ));
                  $iti_en 	 = base64_url_encode( $iti->iti_id );
                  $temp_key_en = base64_url_encode( $iti->temp_key );
                  ?>
               <a class="btn" href="<?php echo base_url("checkout?i={$iti_en}&k={$temp_key_en}"); ?>" target="_blank" title="Pay Now">Pay Now</a>
               <?php }else{ ?>
               <a class="btn" href="https://www.trackitinerary.com/welcome/hdfc" target="_blank" title="Book Now">Book Now</a>
               <?php }  ?>	
               <!--a class="btn" href="https://www.trackitinerary.com/welcome/hdfc" target="_blank" title="Book Now">Book Now</a-->
            </div>
         </div>
      </div>
      </div>
      </div>
      </div>
      <!-- Modal -->
      <div class="modal right fade" id="ticket-details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <img src="<?php echo base_url();?>site/assets/images/cancel.png">
                  </button>
                  <h4 class="modal-title">Your Comments</h4>
               </div>
               <div id="UpdatePanel1">
                  <div class="modal-body">
                     <?php if( $iti->iti_status == 0 ){ ?>
                     <div class="contactForm">
                        <form id="confirmForm">
                           <h3>Enter Your Comments</h3>
                           <div class="form-group feedback">
                              <textarea required placeholder="Please Enter comment here...." rows="4" cols="20" name="client_comment" class="form-control client_textarea"/></textarea> 
                           </div>
                           <input type="hidden" name="iti_id" value="<?php echo $iti->iti_id; ?>">
                           <input type="hidden" value="<?php echo $iti->temp_key?>" name="temp_key" id="temp_key">
                           <input type="hidden" name="sec_key" id="sec_key" value="<?php echo $sec_key; ?>">
                           <input type="hidden" name="agent_id" id="agent_id" value="<?php echo $iti->agent_id; ?>">
                           <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $iti->customer_id;; ?>">
                           <div class="form-group col-md-12 row">
                              <button id="LinkButton1" type="submit" class="btn green uppercase app_iti">contact-us</button>
                           </div>
                           <div class="clearfix"></div>
                           <div class="response"></div>
                        </form>
                     </div>
                     <?php } ?>
                     <!--comments section-->
                     <?php if( !empty( $comments ) ){ ?>
                     <div class="old-comments">
                        <?php foreach( $comments as $comment ){ ?>
                        <div class="well">
                           <?php $comment_by = empty( $comment->agent_id ) || $comment->agent_id == 0  ? "<span class='cc_cmt'>Comment by you:</span>" : "<span class='r_cmt'>Comment by agent:</span>"; ?>
                           <strong><?php echo $comment_by; ?></strong>
                           <p><?php echo $comment->comment_content; ?></p>
                           <p>Date: <?php echo $comment->created; ?></p>
                        </div>
                        <?php } ?>
                     </div>
                     <?php } ?>
                     <!--End comments section-->
                  </div>
               </div>
            </div>
         </div>
      </div>
      </div>
      <div id="myModal" class="video-model modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="btn btn-default closeYoutube" data-dismiss="modal">&times;</button>
                  <div class="modal-body">
                     <div class="embed-responsive embed-responsive-16by9 video_play">
                        <iframe class="embed-responsive-item" id="iFrameModal" src="#" allowfullscreen></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-----------------Pop after 5 second ----------------------->
      <div id="revPopup" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="closeModal" data-dismiss="modal">&times;</button>
                  <div class="modal-body">
                     <p>Msg Goes Here</p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--------------------Popup end------------>
      <!--OFFER MODAL------->
      <!-- Modal -->
      <style>
         .offer_section {
         width: 132px;
         position: fixed;
         z-index: 9999999999;
         top: 40%;
         right: -39px;
         overflow-x: hidden;
         padding: 8px 0;
         transform: rotate(-90deg);
         }
         .offer_section .btn{box-shadow: none;}
         .promo {
         background: #ccc;
         padding: 3px;
         }
         .expire {
         color: red;
         }
      </style>
      <!--div class="offer_section">
         <a class="btn " data-toggle="modal" data-target="#offer_modal"><i class="fa fa-gift"></i> Offers</a>
         </div-->
      <div id="offer_modal" class="modal fade" style="" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">  <i class="fa fa-gift"></i>  Offers</h4>
               </div>
               <div class="modal-body">
                  <div class="container-fluid">
                     <div class="row">
                        <!-- offers section -->
                        <?php
                           $get_offers = get_active_offers( $limit = 3 ); 
                           if( $get_offers ){ 
                           	$count_total_offers = count($get_offers); ?>
                        <div class="portlet box green">
                           <div class="portlet-body">
                              <div class="panel-group accordion" id="accordion12">
                                 <div class="panel panel-default">
                                    <?php $count = 1000;
                                       $count_offer = 1;
                                       $count_ids = array();
                                       foreach( $get_offers as $offer ){ ?>
                                    <!------------ 2nd row of coupons   --------->			
                                    <?php if( $count_offer % 2 !== 0 ){ echo '<div class="row coupon-bg">'; } ?>
                                    <div class="col-md-6">
                                       <div class="panel-heading promo-stats">
                                          <h4 class="panel-title">
                                             <div class="accordion-toggle" data-toggle="collapse"  href="#collapse_<?php echo $count; ?>" aria-expanded="true">
                                                <div class="coupon">
                                                   <h4><?php echo $offer->title; ?></h4>
                                                   <div class="description_section">
                                                      <strong>Description</strong>
                                                      <span><?php echo substr( $offer->description, 0,20 ); ?>....</span>
                                                   </div>
                                                   <div class="promo-container">
                                                      <strong>Promo Code: </strong><span class="promo"><?php echo $offer->coupon_code; ?></span>
                                                   </div>
                                                   <div class="terms"> Read Terms and Conditions Before using this <strong>COUPON CODE</strong>
                                                      <span class="btn btn-more">Click Here </span>
                                                   </div>
                                                </div>
                                             </div>
                                          </h4>
                                       </div>
                                    </div>
                                    <?php if( $count_offer % 2 == 0  || ( $count_total_offers == $count_offer) ){ echo '</div>'; } ?>
                                    <!--collapsed section-->
                                    <?php if( $count_offer % 2 == 0 || ( $count_total_offers == $count_offer) ){
                                       $inner_count = 1;
                                       $inner_collapse_counter = ( $count_total_offers == $count_offer ) && $count_offer % 2 != 0 ? $count : $count-1;
                                       
                                       foreach( $get_offers as $coll_offer ){
                                       	if( in_array( $coll_offer->id, $count_ids ) ) continue;
                                       	$count_ids[] = $coll_offer->id;
                                       	?>
                                    <div id="collapse_<?php echo $inner_collapse_counter; ?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                       <div class="panel-body">
                                          <div class='col-md-12'>
                                             <div><strong>Coupon Code:</strong>
                                                <span class='promo' id="coupon_code"><?php echo $coll_offer->coupon_code; ?></span>
                                                <button class="" data-coupon_code="<?php echo $coll_offer->coupon_code; ?>" onclick="copy_coupon_code(this)">Copy</button>
                                             </div>
                                             <div class='coupon'>
                                                <div class=''>
                                                   <strong>Description</strong>
                                                   <span class='inline-block'><?php echo $coll_offer->description ?> </span>
                                                </div>
                                             </div>
                                             <div class='term_cond'>
                                                <strong>Terms & Conditions</strong>
                                                <span class='inline-block'><?php echo $coll_offer->term_and_conditions; ?></span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <?php 
                                       $inner_count++;	
                                       $inner_collapse_counter++;
                                       //break loop after two entries
                                       if( $inner_count == 3 ) break;
                                       } 	
                                       }
                                       
                                       $count++;
                                       $count_offer++;
                                       } ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <?php //dump(  $get_offers );
                           }else{
                           	echo "<div class='text-center'>No offers available now.</div>";
                           }
                           ?> 
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--END OFFER MODAL------->
      <!-- Include all compiled plugins (below), or include individual files as needed -->
      <script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/jquery.cookie.js" type="text/javascript"></script>
      <script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
      <!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script-->
      <script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
      <script>
         jQuery(document).ready(function ($) {
             $(document).on("scroll", onScroll);
             
             //smoothscroll
             $('a[href^="#"]').on('click', function (e) {
                 e.preventDefault();
                 $(document).off("scroll");
                 
                 $('a').each(function () {
                     $(this).removeClass('active');
                 })
                 $(this).addClass('active');
               
                 var target = this.hash,
                     menu = target;
                 $target = $(target);
                 $('html, body').stop().animate({
                     'scrollTop': $target.offset().top+2
                 }, 500, 'swing', function () {
                     window.location.hash = target;
                     $(document).on("scroll", onScroll);
                 });
             });
         });
         
         function onScroll(event){
             var scrollPos = $(document).scrollTop();
             $('#tab_lising li a').each(function () {
                 var currLink = $(this);
                 var refElement = $(currLink.attr("href"));
                 if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
                     $('#tab_lising li').removeClass("active");
                     $(this).parent().addClass("active");
                 }
                 else{
                     currLink.removeClass("active");
                 }
             });
         }
      </script>
      <script type="text/javascript">
         jQuery(document).ready(function($){
             //top slider
         	$('#carousel-images').carousel({
         		interval: 3000
         	});
         	//testimonials slider
         	$('#carousel-testimonials').carousel({
         		interval: 5000
         	});
         	
         	$('#myCarousel').carousel({
         	  interval: 40000
         	});
         	
         	//Video popup slider
         	$('.videoCarousel .carousel .item').each(function(){
         		var next = $(this).next();
         		if (!next.length) {
         			next = $(this).siblings(':first');
         		}
         		next.children(':first-child').clone().appendTo($(this));
         		if (next.next().length>0) {
         			next.next().children(':first-child').clone().appendTo($(this)).addClass('rightest');
         		}else {
         			$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
         		}
         	});
         	
         	//set modal iframe src
         	var firstLink = $(".vid_modal_link:first-child").attr("data-youtube-link");
         	$("#iFrameModal").attr("src",firstLink );
         	/* Popup Video Modal */
         	$(".vid_modal_link").each(function(){
         		$(this).click(function(e){
         			e.preventDefault();
         			var VidLink = $(this).attr("data-youtube-link");
         			$("#iFrameModal").attr("src",VidLink );
         			$("#myModal").modal({
         				show: 'true',
         				backdrop: 'static'
         			});
         		});
         	});
         	
         	//Close yoututbe video
         	$(document).on("click", ".closeYoutube", function(e){
         		e.preventDefault();
         		//console.log("click");
         		$("#iFrameModal").attr("src","" );
         	});
         	
         	//Set Cookie
         	if (!!$.cookie('openPopup')) {
         		// have cookie
         		//console.log("have cookies");
         	} else {
         		//console.log("Not have cookies");
         		// no cookie
         		//set cookie for 1 minute
         		setInterval(function(){ showPopup(); }, 5000);
         	}
         	
         	function showPopup(){
         		$("#revPopup").addClass("in");
         		var date = new Date();
         		//set cookie time in minutes
         		var minutes = 1440;
         		date.setTime(date.getTime() + (minutes * 60 * 1000));
         		$.cookie("openPopup", true , { path: '/', expires: date });
         	}
         	
         	$(".closeModal").click(function(){
         		$("#revPopup").fadeOut();
         	});
         });
      </script>
      <script type="text/javascript">
         /* submit comment */
         jQuery(document).ready(function($){
         	var ajaxReq;
         	/* Itinerary comment */
         	$("#confirmForm").validate({
         		submitHandler: function(form) {
         			var resp = $(".response");
         			var sec_key = $("#sec_key").val();
         			var formData = $("#confirmForm").serializeArray();
         			//console.log(formData);
         			if (ajaxReq) {
         				ajaxReq.abort();
         			}
         			ajaxReq = $.ajax({
         				type: "POST",
         				url: "<?php echo base_url('promotion/ajax_add_comment'); ?>" ,
         				dataType: 'json',
         				data: formData,
         				beforeSend: function(){
         					resp.html('<p><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
         				},
         				success: function(res) {
         					if (res.status == true){
         						resp.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
         						/*console.log("done");*/
         						location.reload();
         						//window.location.href = "<?php echo site_url('confirm/thankyou'); ?>?key=" + sec_key ; 
         					}else{
         						resp.html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
         						//console.log("error");
         					}
         				},
         				error: function(e){
         						//console.log(e);
         					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
         				}
         			});
         			return false;
         		}
         	});
         
         	//read more btn click
         	$(document).on("click", ".read-more-link", function(e){
         		e.preventDefault();
         		$(this).parent().find("span").attr("style" , "height: auto");
         		$(this).addClass("show_less").text("<< Show Less ");
         	});
         	
         	$(document).on("click", ".show_less", function(e){
         		e.preventDefault();
         		$(this).parent().find("span").attr("style" , "height: 60px");
         		$(this).removeClass( "show_less" ).text("Read More >>");
         	});
         	
         	/*************** OFFER MODAL SECTION **********************/
         	//set cookie for offer modal
         	//Set Cookie
         	/* if (!!$.cookie('offerpopup')) {
         		// have cookie
         		console.log("have cookies");
         	} else {
         		console.log("Not have cookies");
         		// no cookie
         		//set cookie for 1 minute
         		setTimeout(function(){ showPopupOffer(); }, 5000);
         	} */
         	
         //	setTimeout(function(){ showPopupOffer(); }, 5000);
         //	function showPopupOffer(){
         //		$("#offer_modal").modal("show");
         		//var date = new Date();
         		//set cookie time in minutes
         		//var minutes = 1460;
         		//date.setTime(date.getTime() + (minutes * 60 * 1000));
         		//$.cookie("offerpopup", true , { path: '/', expires: date });
         //	}
         	
         });
         
         function copy_coupon_code( ele ) {
         	var coupon_code = $(ele).attr("data-coupon_code");
         	/* Alert the copied text */
         	var $temp = $("<input>");
         	  $("body").append($temp);
         	  $temp.val(coupon_code).select();
         	  var copyText = document.execCommand("copy");
         	  alert("Coupon Code Copied: " + coupon_code );
         	$temp.remove();
         }
         
      </script>
      <?php }else{
         echo "404 page not found!";
         die;
         } ?>
   </body>
</html>