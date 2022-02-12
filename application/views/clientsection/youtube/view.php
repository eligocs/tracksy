<?php $slider = $you_data[0];  ?>
<div class="page-container customer_view_section view_call_info">
<?php  if($slider){ ?>
	<div class="page-content-wrapper">
		<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Youtube Video</div>
						<a class="btn btn-success" href="<?php echo site_url("clientsection/youtube"); ?>" title="Back">Back</a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="customer-details">	
					<div class=" ">
					<div class="col-md-12">
						<div class="col-md-2"><strong>Name:</strong></div>	
						<div class="col-md-10"><?php echo $slider->name; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>In Slider:</strong></div>	
						<div class="col-md-10"><?php echo $slider->in_slider == 1 ? "YES" : "NO"; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>Youtube Poster Image:</strong></div>	
						<div class="col-md-10">
							<?php $slide_img_path = site_url() . 'site/images/youtube_poster/' .$slider->poster_url;
							echo "<img class='img-responsive' src='{$slide_img_path}' />"; ?> 
						</div>
					</div>
					
					<div class="col-md-12">
						<div class="col-md-2"><strong>Youtube Video:</strong></div>	
						<div class="col-md-10">
							<?php $url = $slider->youtube_vid_url; 
							$ytarray=explode("/", $url);
							$ytendstring=end($ytarray);
							$ytendarray=explode("?v=", $ytendstring);
							$ytendstring=end($ytendarray);
							$ytendarray=explode("&", $ytendstring);
							$ytcode=$ytendarray[0];
							echo "<iframe width=\"250\" height=\"160\" src=\"https://www.youtube.com/embed/$ytcode\" frameborder=\"0\" allowfullscreen></iframe>"; ?>							
						</div>
					</div>
					<div class="col-md-12">	
						<div class="col-md-2"><strong>Video Added By:</strong></div>	
						<div class="col-md-10"><?php echo get_user_name($slider->agent_id); ?></div>
					</div>
					</div> <!-- row -->
					</div>		
				</div>		
			</div>
		</div>
	</div>	
 <?php }else{
	redirect(404);
 } ?> 