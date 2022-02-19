<?php if($hotels){ 	$hotel = $hotels[0]; ?>
<div class="page-container">
		
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-hotel"></i>Hotel Name: <strong><?php  echo $hotel->hotel_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("hotels"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if hotel edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body custom_card">
				<h3>Hotel Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover">	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl "><strong>Hotel Id: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $hotel->id; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $hotel->hotel_name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Country: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_country_name($hotel->country_id); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>State: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_state_name($hotel->state_id); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>City: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_city_name($hotel->city_id); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Category: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_hotel_cat_name($hotel->hotel_category); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Email: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $hotel->hotel_email; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Address: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $hotel->hotel_address; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Contact Number: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $hotel->hotel_contact; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Website: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr">
							<?php if( !empty($hotel->hotel_website) ){
								echo "<a href='{$hotel->hotel_website}' target='_blank' title='click to visit'>{$hotel->hotel_website}</a>"; 
							} ?>
							</div></td>
					</tr>
					
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Hotel Image: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr">
						<?php $h_image = site_url() . 'site/images/hotels/' . $hotel->hotel_image;
							echo !empty( $hotel->hotel_image ) ? "<img height='250' width='250' src='{$h_image}' />" : "No Image"; ?> 
						</div></td>
					</tr>
				</table>	
				<!--Edit Button-->
				<?php if( !is_salesteam() ){ ?>
				<div class="text-center">
					<a title='Edit Hotel' href="<?php echo site_url("hotels/edit/{$hotel->id}"); ?>" class="" ><i class="fa fa-pencil"></i> Edit Hotel</a>
				</div>	
				<?php } ?>
			</div>	
		</div>	
	</div>
</div>
<?php } ?>