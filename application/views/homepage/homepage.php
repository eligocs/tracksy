<!DOCTYPE html>
<html lang="en">
<head>
<title>Track Itinerary</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.rawgit.com/stevenmonson/googleReviews/master/google-places.css">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/stevenmonson/googleReviews/6e8f0d79/google-places.js"></script>

  
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="https://googlereviews.cws.net/google-reviews.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo site_url(); ?>site/images/favicon.ico" />
<style>
 .employees>* {position: relative;  z-index: 9;}

span.counter-count {
    position: relative;
    z-index: 3;
    overflow: hidden;
    color: #36317b;
}


span.counter-count:after {
     content: " ";
     position: absolute;
     width: 212%;
     height: 122%;
     background: #c0c7d4;
     top: 0;
     left: -57px;
     z-index: -1;
     transform: rotate(130deg);
     background: linear-gradient(#f9f5ff 50%, #f3fdff 50%);
}


 

body {
    background: #051626;
    color: #161531;
    background: linear-gradient(to top left, #5664b9, #2c8fa3);
    font-family: sans-serif;
}
.container{
    max-width: 800px;
    margin-bottom: 50px;
    background: #fafafa;
    border: 1px solid #e8f1f9;
    box-shadow: 0 0 20px 0px #0006;
}
.logo {
    text-align: center;
    margin: 54px 0 52px;
}

.logo>img {
    max-width: 300px;
}


.videoWrapper {
	position: relative;
	padding-bottom: 56.25%; /* 16:9 */
	padding-top: 25px;
	height: 0;
	
}
.videoWrapper iframe {
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

.video-container{ max-width:800px; margin:0 auto;}

footer ul.list-inline {
    background: #ef4f4f;
    color: #fff;
    padding: 20px 50px;
    text-align: center;
    display: flex;
    justify-content: space-around;
    border-radius: 15px 0;
    margin-bottom: 30px;
}

footer ul.list-inline li a span {
    display: none;
}

footer ul.list-inline li a {
    font-size: 20px;
    background: #fff;
    border-radius: 50%;
    color: #ef4f4f;
    width: 50px;
    height: 50px;
    display: table-cell;
    vertical-align: middle;transition: all ease-in-out 0.4s;
}
footer ul.list-inline li a:hover {
    text-decoration: none;
    transform: scale(1.3) rotate(360deg);
}

footer ul.list-inline li {
    margin: 0 20px;
}
footer h2 {
    text-align: center;
    color: #ef4f4f;
    margin-top: 30px;
    text-shadow: 3px 2px 2px #fff;
    margin-top: 0;
}
.list-group-item{background:transparent;}
.counter
{
    background-color: #2196f3;
    text-align: center;
    margin: 50px 0 15px;
    border-radius: 35px 0;
}
.employees,.customer,.design,.order
{
    margin-top: 50px;
    margin-bottom: 50px;
}
.counter-count
{
    font-size: 28px;
    background-color: #00b3e7;
    border-radius: 50%;
    position: relative;
    color: #ffffff;
    text-align: center;
    line-height: 92px;
    width: 92px;
    height: 92px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    display: inline-block;
}

.employee-p,.customer-p,.order-p,.design-p
{
    font-size: 18px;
    color: #ffffff;
    line-height: 34px;
}
#powered_by_cws{
	display:none !opacityimportant;
	opacity:0 !important;
}

</style>
</head>
<body>
<?php $data = $info[0]; ?>
	<div class="container">
		<div class="logo text-center"><img src="<?php if(isset($data->logo_url) && !empty($data->logo_url)){ echo base_url('site/images/').$data->logo_url; }else{ echo base_url('site/images/trackv2-logo.png');} ?>" alt="trackitinerary"></div>
		<div class="vid">
	</div>
		<?php
		/*
			$current_time = date("H:i a");
			$login_start_time = "09:30 am";
			$login_over_time = "10:00 am";
			$current_time_f = DateTime::createFromFormat('H:i a', $current_time);
			$login_start_time_f = DateTime::createFromFormat('H:i a', $login_start_time);
			$login_over_time_f = DateTime::createFromFormat('H:i a', $login_over_time);
			
			if( $current_time_f > $login_start_time_f && $current_time_f < $login_over_time_f ){
				echo 'Now you can login.';
			}else{
				echo 'You need to manager permission to login.';
			}
		*/	
		?>
		
		<div class="video-container">
			<div class="videoWrapper">
				<!-- Copy & Pasted from YouTube -->
				<iframe src="<?php if(isset($data->video_url) && !empty($data->video_url)){ echo $data->video_url; } ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>
		</div>
			<div >
	            <script>load_google_reviews("ChIJ5ZRoh05_BTkRfEy-WNT7kOc");</script>
</div>
		<div class="counter_section">
			<?php $counter= unserialize($data->counter); ?>
			<div class="counter">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="employees">
								<?php if(isset($counter['count1']) && !empty($counter['count1'])){echo "<span class='counter-count'>".$counter['count1']."</span>";} ?>              
								<p class="employee-p">Counter1</p>
							</div>
						</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="customer">
							<?php if(isset($counter['count2']) && !empty($counter['count2'])){echo "<span class='counter-count'>".$counter['count2']."</span>";} ?>	                 
							<p class="customer-p">Counter2</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="design">
							<?php if(isset($counter['count3']) && !empty($counter['count3'])){echo "<span class='counter-count'>".$counter['count3']."</span>";} ?>               
							<p class="design-p">Counter3</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
						<div class="order">
						<?php if(isset($counter['count4']) && !empty($counter['count4'])){echo "<span class='counter-count'>".$counter['count4']."</span>";} ?>        
						<p class="order-p">Counter4</p>
						</div>
					</div>
				</div>
			</div>			
		</div>
	<footer>
		<div class="row">
			<div class=" col-md">
				<h2>Stay Connected</h2>
				<ul class="list-inline">
					<li class="list-inline-item"><a class="fa fa-google" href="https://plus.google.com/u/0/108839684823653144097"><span>Google</span></a></li>
					<li class="list-inline-item"><a class="fa fa-facebook" href="https://www.facebook.com/trackitineraryofficial"><span>Facebook</span></a></li>
					<li class="list-inline-item"><a class="fa fa-rss" href="https://www.rss.com/"><span>RSS</span></a></li>
					<li class="list-inline-item"><a class="fa fa-pinterest-p" href="https://www.pinterest.com/trackitinerary/"><span>Pinterest</span></a></li>
					<li class="list-inline-item"><a class="fa fa-twitter" href="https://twitter.com/syatraofficial"><span>Twitter</span></a></li>
				</ul>
			</div>
								
		</div>	
		<div class="row">
				<div class="col-md">
				
				<ul class="list-group list-group-flush">
				  <li class="list-group-item"><i class="fa fa fa-envelope"></i> &nbsp; <?php if(isset($data->website) && !empty($data->website)){ echo $data->website; } ?></li>
				  <li class="list-group-item"><i class="fa fa-phone"></i> &nbsp; <?php if(isset($data->contact_no) && !empty($data->contact_no)){ echo $data->contact_no; } ?></li>
				</ul>
				</div>
					
				<div class="col-md">
					<span class="contact-email">
					<?php if(isset($data->address) && !empty($data->address)){ echo $data->address; } ?>
												</span>
					
				</div>
			</div>
	</footer>
							
							
							

</div>
<script>
jQuery(document).ready(function( $ ) {
	  $('#powered_by_cws').remove();


	});</script>
 <script>
$('.counter-count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 5000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>
<footer>
</footer>

</body>
</html>
