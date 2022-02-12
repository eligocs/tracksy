<?php
 if($offer){ 	$offers = $offer[0]; 
?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Offer View</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters/offers"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
			<h3 class="text-center">Offer sDetails</h3>
				
				<div class="table-responsive">	
					<table class="table table-condensed table-hover">	
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 1: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title1); ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 1: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content1); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 2: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title2); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 2: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content2); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Title 3: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo strip_tags($offers->title3); ?></div></td>
						</tr><tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Content 3: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($offers->content3); ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Image Preview: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><img width='30%' src="<?php echo base_url('site/images/offer/'.$offers->offer_image); ?>" alt='image' ></div></td>
						</tr>
						<?php $slug	= $offers->offerslug;
							$link 	= base_url() . "promotion/offer/{$slug}"; ?>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Offer Link: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><a href="<?= $link; ?>" >Click to view offer</a></div></td>
						</tr>
					
						
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>
<?php }else{
	redirect('newsletters/imagetemplateList');
} ?>	

