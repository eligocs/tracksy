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
<link href="<?php echo base_url();?>site/assets/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />	
<link href="<?php echo base_url();?>site/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url();?>site/assets/css/style_client_view_new.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="content_area">
	<div class="logo">
	<div class="container ">
		<img src="<?php echo base_url();?>site/images/trackv2-logo.png" class="template_logo">
	</div>
	</div>
<?php if( !empty($testimonials ) ){   ?>
<?php //print_r($testimonials); ?><br>
	<div class="container bothwrapper">
		<div class="row">
			<div id="testimonials">
			

	<div class="clearfix review_destination_total">
        <div class="col-sm-4 positive_reviews text-center">
            <h2 class="review-title"><?php echo $positive_rev_percentage; ?> %<span class="center-block"> Positive Reviews</span></h2>
            <p class="">Based on <span class="votes"><?php echo $t_rows; ?> ratings</span></p>
         
        </div>  <!-- positive_reviews-->
      <!--calculate percentage review -->
		<?php 
		$f_per =  !empty($excellent) ? round( $excellent * 100 / $t_rows , 2) . "%": "0%"; 
		$vg_per =  !empty($v_good) ? round( $v_good * 100 / $t_rows , 2) . "%": "0%"; 
		$good_p =  !empty($good) ? round( $good * 100 / $t_rows , 2) . "%": "0%"; 
		$p_per =  !empty($poor) ? round( $poor * 100 / $t_rows , 2) . "%": "0%"; 
		$bad_per =  !empty($bad) ? round( $bad * 100 / $t_rows , 2) . "%": "0%" ; 
		?>
	 
	 <div class="col-sm-8">
      <div class="reviews_chart">
        <div class="review_con">
          <h3>Excellent</h3>
        <div class="rating-bars">
				<div class="progress-bar" role="progressbar" aria-valuenow="100"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $f_per; ?>">  </div>
		</div>
          &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo !empty($excellent) ? $excellent : 0; ?></h3>
          <div class="clear"></div>
        </div>  <!--review_con-->
        
		
		<div class="review_con">
          <h3>Very Good</h3>
          <div class="rating-bars">
				<div class="progress-bar" role="progressbar" aria-valuenow="70"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $vg_per; ?>">  </div>
		</div>
          &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo !empty($v_good) ? $v_good : 0; ?></h3>
          <div class="clear"></div>
        </div>  <!--review_con-->
        <div class="review_con">
          <h3>Good</h3>
          <div class="rating-bars">
				<div class="progress-bar" role="progressbar" aria-valuenow="50"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $good_p; ?>">  </div>
		</div>
          &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo !empty($good) ? $good : 0; ?></h3>
          <div class="clear"></div>
        </div>  <!--review_con-->
        <div class="review_con">
          <h3>Poor</h3>
         <div class="rating-bars">
				<div class="progress-bar" role="progressbar" aria-valuenow="1"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $p_per; ?>">  </div>
		</div>
          &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo !empty($poor) ? $poor : 0; ?></h3>
          <div class="clear"></div>
        </div>  <!--review_con-->
        <div class="review_con">
          <h3>Bad</h3>
          <div class="rating-bars">
				<div class="progress-bar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $bad_per; ?>">  </div>
		</div>
          &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo !empty($bad) ? $bad : 0; ?></h3>
          <div class="clear"></div>
        </div>  <!--review_con-->


                <div class="clear"></div>
                </div>  <!--reviews_chart-->
      </div>
		<div class="clear"></div>
    </div>	
<div class="clearfix generic_pagination margin-b-20 padding-0" >
	  <div class="col-sm-6 padding-0 page_info">
		<h3><?php echo $pagination_des; ?></h3>
	  </div>
		
		<div class="col-sm-6">
		<ul class="pagination pull-right">
		  <?php echo $links; ?>
		</ul>
		</div>

</div>

			<div class="col-md-3"> 
					<!--form class="navbar-form-search" role="search" _lpchecked="1">
						<div class="input-group add-on">
						  <input class="form-control" placeholder="Search" name="srch-term" id="srch-term" type="text">
						  <div class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
						  </div>
						</div>
					</form>
					  <hr-->
					   <div class="reviews_chart_filter">
							<div class="review_con">
							<a href="<?php echo site_url("promotion/testimonials?filter_review=5")?>">
							  <h3>5 stars</h3>
								<div class="rating-bars">
										<div class="progress-bar" role="progressbar" aria-valuenow="100"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $f_per; ?>">  </div>
								</div>
								  &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo $f_per; ?></h3>
								  <div class="clear"></div>
							</a>
							</div>  <!--review_con-->
							
							
							<div class="review_con">
							<a href="<?php echo site_url("promotion/testimonials?filter_review=4")?>">
							  <h3>4 stars</h3>
							   
							  <div class="rating-bars">
									<div class="progress-bar" role="progressbar" aria-valuenow="70"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $vg_per; ?>">  </div>
							</div>
							  &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo $vg_per; ?></h3>
							  <div class="clear"></div>
							  </a>
							</div>  <!--review_con-->
							<div class="review_con">
							<a href="<?php echo site_url("promotion/testimonials?filter_review=3")?>">
							  <h3>3 stars</h3>
							  
							  <div class="rating-bars">
									<div class="progress-bar" role="progressbar" aria-valuenow="50"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $good_p; ?>">  </div>
							</div>
							  &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo $good_p; ?></h3>
							  <div class="clear"></div>
							  </a>
							</div>  <!--review_con-->
							<div class="review_con">
							<a href="<?php echo site_url("promotion/testimonials?filter_review=2")?>">
							  <h3>2 stars</h3>
							 <div class="rating-bars">
									<div class="progress-bar" role="progressbar" aria-valuenow="1"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $p_per; ?>">  </div>
							</div>
							  &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo $p_per; ?></h3>
							  <div class="clear"></div>
							  </a>
							</div>  <!--review_con-->
							<div class="review_con">
							<a href="<?php echo site_url("promotion/testimonials?filter_review=1")?>">
							  <h3>1 star</h3>
							 
							  <div class="rating-bars">
									<div class="progress-bar" role="progressbar" aria-valuenow="10"  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $bad_per; ?>">  </div>
							</div>
							  &nbsp;&nbsp;&nbsp;<h3 style="padding-left: 10px" class="text-left"><?php echo $bad_per; ?></h3>
							  <div class="clear"></div>
							  </a>
							</div>  <!--review_con-->


                <div class="clear"></div>
                </div>  <!--reviews_chart-->

			</div>
<div class="col-md-9">
			
				<?php 
				foreach( $testimonials as $testimonial ){ 
				?>
					<div id="tes_id_<?php echo $testimonial->id ?>" class="review_destination_testimonial">
						<?php 
						$client_name =  strip_tags( $testimonial->client_name ) ; 
						$client_contact =  strip_tags( $testimonial->client_contact ) ; 
						$feedback =  strip_tags( $testimonial->feedback ); 
						$created =  $testimonial->created; 
						$image = '';
					
						//rating
						$total_review = $testimonial->rating;	
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
						
						 <div class="col-xs-3 review-person-details">
								<div class="user-initial-letter">
								<a href="#" class="thumbnail">
								<?php if(!empty($image)):?>
								  <img src="http://placehold.it/150x150" class="img-responsive img-circle">
								  <?php else : ?>
								  <span class="text-word"><strong><?php echo substr(trim( $client_name) ,0 ,1);?></strong></span>
								  <?php endif ; ?>
								  </a>
								  
								</div>
							   
								<div class="person-name-etc padding-t-10 text-center">
									<p class="person_name  text-capitalize"><?php echo $client_name;?></p>
									<p class="visit_place"><a href="tel:<?php echo $client_contact;?>"><?php echo $client_contact;?></a></p>
								</div>
						  </div>  <!--review-person-details-->
						  <div class="col-xs-9">
							<div class="row review-text">
									<div class="clearfix">
									  <p class="pull-left testimonial-title-client"><a href="#" class="">Trip to Himachal</a></p>
									  <span class="testimonial-date margin-t-5 font-600 inline-block pull-right">about <?php echo calculate_time_span($created); ?>
									  </span>
									</div>

									<ul class="list-inline star-rating">
										<li><span class="fa fa-star <?php echo $check1; ?>" data-rating="1"></span></li>
										<li><span class="fa fa-star <?php echo $check2; ?>" data-rating="2"></span></li>
										<li><span class="fa fa-star <?php echo $check3; ?>" data-rating="3"></span></li>
										<li><span class="fa fa-star <?php echo $check4; ?>" data-rating="4"></span></li>
										<li><span class="fa fa-star <?php echo $check5; ?>" data-rating="5"></span></li>
									</ul>

									<p class="testimonial_text">
										<span class="inline-block" style="height: 60px;"><?php echo $feedback; ?></span>
										<a href="#" class="center-block read-more-link">Read more&nbsp; &gt;&gt;</a>
									</p>
						   
							</div>
						  </div> 
						<div class="clear"></div>
					</div>
					
				<?php } ?>
				</div>
				<div class="clearfix generic_pagination ">
					<div class="col-sm-6 padding-0 page_info">
						<h3><?php echo $pagination_des; ?></h3>
					</div>
					
					<div class="col-sm-6">
						<ul class="pagination pull-right">
						  <?php echo $links; ?>
						</ul>
					</div>

				</div>					
			</div>
		</div>
	</div>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="<?php echo base_url();?>site/assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	jQuery(document).ready(function($){
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
	});
	</script>
	<?php }else{
		echo "No testimonials found.!";
	} ?>
</div>	

<div class="bg-blue">
<div class="container">


<div class="row">
	<div class="row iata">
     <div class="col-md-6 iatacol ">
     <div class="grabber fff ptb">
       <h5 class="wa text-capitalize">Approved by</h5>
   <div>
 	   <img src="<?php echo site_url('/');?>site/assets/images/approve.png" alt="Approve">
   </div>
   </div>
    </div>
    <div class="col-md-6 iatacol">
     <div class="grabber grabberwa fff ptb">
        <h5 class="wa text-capitalize">we accept all major credit and debit cards</h5>
	<div class="mitem">
	  <img src="<?php echo site_url('/');?>site/assets/images/payment-type.png" alt="Payment Modes">
	
    </div>
  </div>
</div>
</div>
</div>			
	<div class="row">
		<nav class="col-md-12">
			<ul class="footer-menu">
				<li><a href="<?php echo site_url('/');?>promotion/testimonials">Clients Feedback</a></li>
				<li><a href="<?php echo site_url('/');?>promotion/contact_us">Contact Us</a></li>
													
			</ul>
		</nav>
		
		<div class="foot-boxs">
			<div class="foot-box col-md-4 text-right">
				<span>Stay Connected</span>
				<ul class="social-media footer-social">
					<li><a class="fa fa-google" href="https://plus.google.com/u/0/108839684823653144097"><span>Google</span></a></li>
					<li><a class="fa fa-facebook" href="https://www.facebook.com/trackitineraryaa/"><span>Facebook</span></a></li>
					<li><a class="fa fa-rss" href="https://www.rss.com/"><span>RSS</span></a></li>
					<li><a class="fa fa-pinterest-p" href="https://www.pinterest.com/trackitinerary/"><span>Pinterest</span></a></li>
					<li><a class="fa fa-twitter" href="https://twitter.com/Trakitinerary"><span>Twitter</span></a></li>
					<li><a class="linkdin_link" href="https://www.linkedin.com/"><span>Linkdin</span></a></li>
				</ul>
			</div>
			<div class="foot-box foot-box-md col-md-4">
				<span class="contact-email"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp; <a href="mailto:info@trackitinerary.com"> info@trackitinerary.com</a></span>
				<span class="contact-phone"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp; <a href="tel:+9816155636">9816155636</a></span>
			</div>
			<div class="foot-box col-md-4">
	<span class="">© <?php echo date('Y');?> trackitinerary. All Rights Reserved.</span>
			</div>
		</div>
	</div>
</div>
</div>					
</body>
</html>