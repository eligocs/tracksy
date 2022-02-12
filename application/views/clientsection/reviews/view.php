<?php $review = $review_data[0];  ?>
<div class="page-container customer_view_section view_call_info">
<?php  if($review){ ?>
	<div class="page-content-wrapper">
		<div class="page-content">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption"><i class="fa fa-users"></i>Review</div>
						<a class="btn btn-success" href="<?php echo site_url("clientsection/reviews"); ?>" title="Back">Back</a>
					</div>
				</div>
				<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
				<div class="portlet-body">
					<div class="customer-details">	
					<div class=" ">
					<div class="col-md-12">
						<div class="col-md-2"><strong>Client Name:</strong></div>	
						<div class="col-md-10"><?php echo $review->client_name; ?></div>
					</div>

					<div class="col-md-12">
						<div class="col-md-2"><strong>Client Contact:</strong></div>	
						<div class="col-md-10"><?php echo $review->client_contact; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>Package Name:</strong></div>	
						<div class="col-md-10"><?php echo $review->package_name; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>Feedback:</strong></div>	
						<div class="col-md-10"><?php echo $review->feedback; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>In Slider:</strong></div>	
						<div class="col-md-10"><?php echo $review->in_slider == 1 ? "YES" : "NO"; ?></div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2"><strong>Rating:</strong></div>	
						<div class="star-rating">
						  <fieldset>
							<input type="radio" disabled id="star5" <?php if(isset( $review->rating ) && $review->rating == 5 ){ echo "checked"; } ?>  /><label for="star5" title="Outstanding">5 stars</label>
							<input id="star4" type="radio" disabled <?php if(isset( $review->rating ) && $review->rating == 4 ){ echo "checked"; } ?> name="inp[rating]" /><label for="star4" title="Very Good">4 stars</label>
							<input type="radio" disabled id="star3"  <?php if(isset( $review->rating ) && $review->rating == 3 ){ echo "checked"; } ?> /><label for="star3" title="Good">3 stars</label>
							<input type="radio" disabled id="star2"  <?php if(isset( $review->rating ) && $review->rating == 2 ){ echo "checked"; } ?>  /><label for="star2" title="Poor">2 stars</label>
							<input type="radio" disabled id="star1"  <?php if(isset( $review->rating ) && $review->rating == 1 ){ echo "checked"; } ?>  /><label for="star1" title="Very Poor">1 star</label>
						</fieldset>
						</div>
					</div>
					
					<div class="col-md-12">	
						<div class="col-md-2"><strong>Review Added By:</strong></div>	
						<div class="col-md-10"><?php echo get_user_name($review->agent_id); ?></div>
					</div>
					<div class="text-center">
						<a title='Edit Review' href="<?php echo site_url("clientsection/review_edit/{$review->id}"); ?>" class="" ><i class="fa fa-pencil"></i> Edit Review</a>
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