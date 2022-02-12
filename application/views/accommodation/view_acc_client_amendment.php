<!doctype html/>
<html lang="en">
  <head>
	<meta charset="utf-8" />
	<title>trackitinerary Pvt. Lmt.</title>
    <!-- Bootstrap -->
   <!-- Latest compiled and minified CSS -->

<!-- fonts -->
<link href="https://fonts.googleapis.com/css?family=Nixie+One" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900" rel="stylesheet">
<!--link href="<?php //echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" /-->	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" / -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" /> 
</head>
<body>
	<?php if( !empty($itinerary[0] ) ){   
		$acc = $itinerary[0];
		$terms = get_hotel_terms_condition();
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
		$get_customer_info = get_customer( $acc->customer_id ); 
		$cust = $get_customer_info[0];
		
		$customer_name 		= !empty( $get_customer_info ) ? $cust->customer_name : "";
		$customer_contact 	= !empty( $get_customer_info ) ? $cust->customer_contact : "";
		$customer_email 	= !empty( $get_customer_info ) ? $cust->customer_email : "";
		
		$agent_id = $acc->agent_id;
		$user_info = get_user_info($agent_id);
		$agent = !empty( $user_info[0] ) ? $user_info[0] : "" ;
		
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
							<li>Phone No:<?php echo company_contact(); ?></li>
							<li>Email:<?php echo company_email(); ?></li>
							<li>Website:www.Trackitinerary.com</li>
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
								$ytarray=explode("/", $url);
								$ytendstring=end($ytarray);
								$ytendarray=explode("?v=", $ytendstring);
								$ytendstring=end($ytendarray);
								$ytendarray=explode("&", $ytendstring);
								$ytVid_id=$ytendarray[0];								
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
						}
						?>
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
                	    <p class="comp-link">Sent by <a href="https://Trackitinerary.com" target="_blank">Trackitinerary.com</a></p>
                </div>
            </div>
			
			<?php 
			//check benefits 
			$benefits_m = unserialize($acc->booking_benefits_meta); 
			$count_bn_inc = count( $benefits_m );
			?>
			
          <div class="col-md-7 right-wrapper">
            	<div class="event-ticket-wrapper">
                    
                    <div class="event-tab">
                
                  <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#pack_overview" aria-controls="pack_overview" role="tab" data-toggle="tab" aria-expanded="false">Introduction</a></li>
					
					<li role="presentation" class=""><a href="#hotel_details_tab" aria-controls="hotel_details_tab" role="tab" data-toggle="tab" aria-expanded="false">Hotel Details</a></li>

					<li role="presentation" class=""><a href="#incExcSection" aria-controls="incExcSection" role="tab" data-toggle="tab" aria-expanded="false">INCLUSION</a></li>
					
					<?php if( !empty($benefits_m) ){  ?>
						<li role="presentation" class="blink_li"><a href="#benefits_tab" aria-controls="benefits_tab" role="tab" data-toggle="tab" aria-expanded="true"> <blink>Benefits</blink> </a></li>
					<?php } ?>
					
					<li role="presentation" class=""><a href="#how_to_book_tab" aria-controls="how_to_book_tab" role="tab" data-toggle="tab" aria-expanded="false">How to Book</a></li>
					
                    <li role="presentation" class=""><a href="#termCondition" aria-controls="termCondition" role="tab" data-toggle="tab" aria-expanded="true">T&C </a></li>
					
                </ul>
                
                  <!-- Tab panes -->
                  <div class="tab-content client-view">
					<!-- PACKAGE Overview Section -->
                    <div role="tabpanel" class="tab-pane fade active in" id="pack_overview">
					<p><strong class="clrblue">Hi, <?php echo $customer_name; ?></strong> </p>
						<p><strong class="clrblue">GREETINGS FROM    Track Itinerary </strong></p>
                      <?php echo company_info(); ?>
					  <!--get company info -->
					  <?php $company_info = get_company_details(); 
						/* if( !empty( $company_info ) ){ 
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
					  } */ ?>
					
                      
                     
						
                    </div><!-- End PACKAGE Overview Section -->
					<!--Itinaray tab section -->
					<div role="tabpanel" class="tab-pane fade" id="hotel_details_tab">
					 <h2> <span id="Label1">Package Overview</span></h2>
					   	<!--p><?php //echo $greeting; ?></p-->
					<div class="table-responsive">
					<table class="table package-details-table table-striped table-bordered table-hover" >
						<tr>
							<th width="30%" class="thead-inverse"><i class="fa fa-gift" aria-hidden="true"></i> Name of Package	</th>
							<td><?php echo $acc->package_name; ?></td>
						</tr>

						<tr>
							<th class="thead-inverse"><i class="fa fa-road" aria-hidden="true"></i> Routing</th>
							<td><?php echo $acc->package_routing; ?></td>
						</tr>
						
						<tr>
							<th class="thead-inverse"><i class="fa fa-clock-o" aria-hidden="true"></i> Duration</th>
							<td><?php echo $acc->total_nights; ?> Nights</td>
						</tr>
						<tr>
							<th class="thead-inverse"><i class="fa fa-calendar" aria-hidden="true"></i> Start Date</th>
							<td><?php echo $acc->t_start_date; ?></td>
						</tr>
						<tr>
							<th class="thead-inverse"><i class="fa fa-calendar" aria-hidden="true"></i> End Date</th>
							<td><?php echo $acc->t_end_date; ?></td>
						</tr>
						
						<tr>
							<th class="thead-inverse"><i class="fa fa-users" aria-hidden="true"></i>  No of Travellers</th>
							<td><?php
								echo "<strong> Adults: </strong> " . $acc->adults; 
								if( !empty( $acc->child ) ){
									echo "<strong> No. of Child: </strong> " . $acc->child; 
									echo "<strong> Child age: </strong> " . $acc->child_age; 
								}
								?>
							</td>
						</tr>
					</table>
					</div>
					<hr>
					<div class="well well-sm"><h3>Hotel Details</h3></div>
					<?php $hotel_meta = !empty($acc->hotel_meta) ? unserialize($acc->hotel_meta) : ""; 
					$standard_html = "";
					$deluxe_html = "";
					$super_deluxe_html = "";
					$luxury_html = "";
					$s_price_dis = "";
					$d_price_dis = "";
					$sd_price_dis = "";
					$l_price_dis = "";
					$strike_class_dis = "";
					$strike_class = "";
					
					$check_hotel_cat = array();
					$check_hotel_cat = !empty($hotel_meta) ? array_column($hotel_meta, "hotel_inner_meta" ) : "";
					
					//Get all category
					$all_hotel_cats = [];
					foreach( $check_hotel_cat as $date => $array ) {
						$all_hotel_cats = array_merge($all_hotel_cats, array_column($array, "hotel_category"));
					}
				
					/* echo "<pre>";
						print_r( $all_hotel_cats );
					echo "</pre>"; */
					
					$is_standard	= !empty($all_hotel_cats) && in_array("Standard", $all_hotel_cats) ? TRUE : FALSE;
					$is_deluxe		= !empty($all_hotel_cats) && in_array("Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
					$is_s_deluxe 	= !empty($all_hotel_cats) && in_array("Super Deluxe",  $all_hotel_cats) ? TRUE : FALSE;
					$is_luxury 		= !empty($all_hotel_cats) && in_array("Luxury", $all_hotel_cats ) ? TRUE : FALSE;
					
					?>
					<!--End Calculate Rates Meta -->
					<?php if( !empty( $hotel_meta ) ){
						$count_hotel = count( $hotel_meta ); 
							/* print_r( $hotel_meta ); */
							if( $count_hotel > 0 ){
								for ( $i = 0; $i < $count_hotel; $i++ ) {
									$hotel_location = $hotel_meta[$i]["hotel_location"];
									$check_in 		= $hotel_meta[$i]["check_in"];
									$check_out 		= $hotel_meta[$i]["check_out"];
									$total_room 	= $hotel_meta[$i]["total_room"];
									$total_nights 	= $hotel_meta[$i]["total_nights"];
									$extra_bed 		= !empty( $hotel_meta[$i]['extra_bed'] ) ? " + <strong>" . $hotel_meta[$i]['extra_bed'] . " </strong> Extra Bed" : "";
									
									$hotel_inner_meta = $hotel_meta[$i]["hotel_inner_meta"];
									//Fetch hotel inner meta
									$count_innermeta = count( $hotel_inner_meta );
									//print_r($hotel_inner_meta);
									
									if( !empty( $count_innermeta ) ){
										for( $ii = 0 ; $ii < $count_innermeta ; $ii++ ){
											$hotel_category	= $hotel_inner_meta[$ii]["hotel_category"];
											$room_category 	= $hotel_inner_meta[$ii]["room_category"];
											$hotel_name 	= $hotel_inner_meta[$ii]["hotel_name"];
											$meal_plan 		= $hotel_inner_meta[$ii]["meal_plan"];
											
											//hotel details html category wise
											switch( $hotel_category ){
												case "Standard":
													$standard_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>{$hotel_category}</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Deluxe":
													$deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>{$hotel_category}</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Super Deluxe":
													$super_deluxe_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>{$hotel_category}</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												case "Luxury":
													$luxury_html .= "<tr>
														<td>{$hotel_location}</td>
														<td>{$hotel_category}</td>
														<td>{$check_in}</td>
														<td>{$check_out}</td>
														<td>{$hotel_name}</td>
														<td>{$room_category}</td>
														<td>{$meal_plan}</td>
														<td>{$total_room}{$extra_bed}</td>
														<td>{$total_nights}</td>
													</tr>";
												break;
												default:
													continue;
												break;
											}
										}
									}	
									
								} 	
							} ?>
						
						
						<?php if( $is_standard || $is_deluxe || $is_s_deluxe ||  $is_luxury ) { ?>
							<!--add dynamic active class -->
							<?php 
								$st_li_active = "";
								$d_li_active = "";
								$sd_li_active = "";
								$l_li_active = "";
								
								if( $is_standard )
									$st_li_active = "in active";
								else if( $is_deluxe )
									$d_li_active = "in active";
								else if( $is_s_deluxe )
									$sd_li_active = "in active";
								else
									$l_li_active = "in active";
							?>
							<div class="portlet-body">
								<div class="tabbable-line">
									<ul class="nav nav-tabs">
										<?php if( $is_standard ) { ?>
											<li class="<?php echo $st_li_active; ?>">
												<a href="#standard_tab" data-toggle="tab">Deluxe </a>
											</li>
										<?php } ?>
										<?php if( $is_deluxe ) { ?>
											<li class="<?php echo $d_li_active; ?>">
												<a href="#deluxe_tab" data-toggle="tab">Super Deluxe </a>
											</li>
										<?php } ?>
										<?php if( $is_s_deluxe ) { ?>
											<li class="<?php echo $sd_li_active; ?>">
												<a href="#super_deluxe_tab" data-toggle="tab">Luxury </a>
											</li>
										<?php } ?>
										<?php if( $is_luxury ) { ?>
											<li class="<?php echo $l_li_active; ?>">
												<a href="#luxury_tab" data-toggle="tab">Super Luxury </a>
											</li>
										<?php } ?>
									</ul>
									<div class="tab-content">
										<?php if( $is_standard ) { ?>
										<div class="tab-pane fade <?php echo $st_li_active; ?>" id="standard_tab">
												<?php // echo "<div class='well well-sm'><h3>Standard</h3></div>";
												echo "<table class='table table-bordered'>
														<tr>
															<th>City</th>
															<th>Hotel Category</th>
															<th>Check In</th>
															<th>Check Out</th>
															<th>Hotel</th>
															<th>Room Category</th>
															<th>Plan</th>
															<th>Room</th>
															<th>N/T</th>
														</tr>
														{$standard_html}
													</table>
													"; ?>
											</div>
										<?php }	?>
										<?php if( $is_deluxe ){ ?>
											<div class="tab-pane fade <?php echo $d_li_active; ?>" id="deluxe_tab">
												<?php 
												//echo "<div class='well well-sm'><h3>Deluxe</h3></div>";
												echo "<table class='table table-bordered'>
													<tr>
														<th>City</th>
														<th>Hotel Category</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Hotel</th>
														<th>Room Category</th>
														<th>Plan</th>
														<th>Room</th>
														<th>N/T</th>
													</tr>
													{$deluxe_html}
													</table>
													"; ?>
											</div>
										<?php } ?>
										
										
										<?php if( $is_s_deluxe ){ ?>
											<div class="tab-pane fade <?php echo $sd_li_active; ?>" id="super_deluxe_tab">
												<?php //echo "<div class='well well-sm'><h3>Super Deluxe</h3></div>";
												echo "<table class='table table-bordered'>
													<tr>
														<th>City</th>
														<th>Hotel Category</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Hotel</th>
														<th>Room Category</th>
														<th>Plan</th>
														<th>Room</th>
														<th>N/T</th>
													</tr>
													{$super_deluxe_html}
													</table>
													"; ?>
											</div>
										<?php } ?>

										<?php if( $is_luxury ){ ?>
											<div class="tab-pane fade <?php echo $l_li_active; ?>" id="luxury_tab">
												<?php // echo "<div class='well well-sm'><h3>Luxury</h3></div>";
												echo "<table class='table table-bordered'>
													<tr>
														<th>City</th>
														<th>Hotel Category</th>
														<th>Check In</th>
														<th>Check Out</th>
														<th>Hotel</th>
														<th>Room Category</th>
														<th>Plan</th>
														<th>Room</th>
														<th>N/T</th>
													</tr>
													{$luxury_html}
												</table>
												"; ?>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
						<?php } 
					} ?>	
					<hr>
					
							
							<hr>					
							<div class="well well-sm"><h3>Notes:</h3></div>
							<ul>
							<?php $hotel_note_meta = !empty( $acc->hotel_note_meta ) ? unserialize($acc->hotel_note_meta) : ""; 
							$count_hotel_meta = count( $hotel_note_meta );
							
							if( !empty($hotel_note_meta ) ){
								for ( $i = 0; $i < $count_hotel_meta; $i++ ) {
									echo "<li>" . $hotel_note_meta[$i]["hotel_note"] . "</li>";
								}	
							} ?>
							</ul>
							
					</div>
					
					<!--End Itinaray tab section -->
					<!--Inclusion exclusion section -->
                    <div role="tabpanel" class="tab-pane fade" id="incExcSection">
                        <h2> INCLUSION & EXCLUSION</h2>
						<div class="table-responsive inclusion">
						 <h5> Inclusion  </h5>
									<?php 
									$inclusion = !empty($acc->inc_meta) ? unserialize($acc->inc_meta) : ""; 
									$count_inc = count( $inclusion );
									$exclusion = !empty($acc->exc_meta) ? unserialize($acc->exc_meta) : ""; 
									$count_exc = count( $exclusion );
									echo "   <ul class='inclusion'>";
									if( !empty( $inclusion ) ){
										for ( $i = 0; $i < $count_inc; $i++ ) {
											echo "<li> <i class='fa fa-check-circle-o' aria-hidden='true'></i>" . $inclusion[$i]["tour_inc"] . "</li>";
										}	
									}
									echo "</ul>"; 
									//check if special inclusion exists
									$sp_inc = !empty($acc->special_inc_meta) ? unserialize($acc->special_inc_meta) : ""; 
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
									if( !empty( $exclusion )  ){
										for ( $i = 0; $i < $count_exc; $i++ ) {
											echo "<li> <i class='fa fa-times-circle-o' aria-hidden='true'></i>" . $exclusion[$i]["tour_exc"] . "</li>";
										}	
									}
									echo "</ul>";
									?>
							 
						</div>
                    </div><!--End Inclusion exclusion section -->
					
					
					<!--Benefits-->
					<?php if( !empty($benefits_m) ){  ?>
						<div id="benefits_tab">
							<h5 style="background: red; color: #fff;">Benefits of Booking With Us:</h5>
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
							</div><!--end payement policy-->

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
								echo "<div class='panel-heading collapsed' role='tab' id='headingFour'  data-toggle='collapse' data-parent='#accordion' href='#collapseFour' aria-expanded='false' aria-controls='collapseFour'><span class='clrblue'>" . $online_payment_terms["heading"] . "</span></div>"; 
							}
							echo "<div id='collapseFour' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingFour'>";
							if( !empty( $online_payment_terms ) ){
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
						</div>
					</div>
				</div>
					<!--End How to book section-->
					<!--Terms and condition-->
					<div role="tabpanel" class="tab-pane fade" id="termCondition">
           				<?php 
						//terms and condition
						if(isset($terms_condition["heading"]) ) { 
							echo "<div class=''><h2>". $terms_condition["heading"]  ."</h2></div>";
						}
						$count_cancel_content	= count( $terms_condition );
						if( !empty($terms_condition) ){
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
		                  echo "<strong>Email : </strong> " . $agent->email . "," . "sales@Trackitinerary.com" . "<br>";
		                  echo "<strong>Timing : </strong> " . $agent->in_time . " To " . $agent->out_time . "<br>";
                          echo "<strong>Website : </strong> " . $agent->website . "<br>";
                          echo "<strong>Other Contacts : </strong> " .   "9218020636,9218004636,8091007636,9218016636,9218025636,9805744636,9805236000";
                          ?>
                      </div>
                    </div>
                  </div>
				</div>
					<!--Marquee tagline section -->
					<div class="tagline"><?php $tagline = get_tagline(); ?>
						<marquee><?php echo $tagline; ?></marquee>
					</div>
					
					<div class="cart">
						<div class="row">
							<div class="text-right">
								<a class="btn hide-mobile"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp;<?php echo $agent->mobile; ?></a>
								<a class="btn hide-desktop" href="mailto:<?php echo $agent->mobile; ?>" title="Call Me">Call Me</a>
								<a class="btn" href="<?php echo site_url("promotion/accommodation_pdf/{$acc->iti_id}/{$acc->temp_key}"); ?>" title="Download Pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
								<a class="btn" href="<?php echo site_url("promotion/contact_us"); ?>" title="Contact Us"> <i class="fa fa-address-card-o" aria-hidden="true"></i></a>
								<a class="btn" data-toggle="modal" data-target="#ticket-details"><i class="fa fa-commenting-o" aria-hidden="true"></i></a>
								<a class="btn" href="https://www.Trackitinerary.com/welcome/hdfc" target="_blank" title="Book Now">Book Now</a>
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
	  <?php if( $acc->iti_status == 0 ){ ?>
		<div class="contactForm">
			<form id="confirmForm">
				<h3>Enter Your Comments</h3>
				<div class="form-group feedback">
					<textarea required placeholder="Please Enter comment here...." rows="4" cols="20" name="client_comment" class="form-control client_textarea"/></textarea> 
				</div>
				<input type="hidden" name="iti_id" value="<?php echo $acc->iti_id; ?>">
				<input type="hidden" value="<?php echo $acc->temp_key?>" name="temp_key" id="temp_key">
				<input type="hidden" name="sec_key" id="sec_key" value="<?php echo $sec_key; ?>">
				<input type="hidden" name="agent_id" id="agent_id" value="<?php echo $acc->agent_id; ?>">
				<input type="hidden" name="customer_id" id="customer_id" value="<?php echo $acc->customer_id;; ?>">
				<div class="form-group col-md-12 row">
					<button id="LinkButton1" type="submit" class="btn green uppercase app_iti">contact-us</button>
				</div>
				<div class="clearfix"></div>
				<div class="response"></div>
			</form>	
	  </div>	<?php } ?>
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
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script-->
<script src="<?php echo base_url();?>site/assets/js/jquery.validate.min.js" type="text/javascript"></script>
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
	
	//Close yoututbe video
	$(document).on("click", ".closeYoutube", function(e){
		e.preventDefault();
		console.log("click");
		$("#iFrameModal").attr("src","" );
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
	 		
	});
</script>
<?php }else{
	echo "404 page not found!";
	die;
} ?>
</body>
</html>