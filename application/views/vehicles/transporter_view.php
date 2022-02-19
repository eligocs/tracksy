<?php if($vehicles){ 	$vehicle = $vehicles[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-cars"></i>Transporter Name: <strong><?php  echo $vehicle->trans_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("vehicles/transporters"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body custom_card">
				<h3>Transporter Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover table-bordered table-striped">	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Transporter Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $vehicle->trans_name; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Email: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $vehicle->trans_email; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Contact: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $vehicle->trans_contact; ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Address: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $vehicle->trans_address; ?></div></td>
					</tr>
					<?php 
					$car_list = $vehicle->trans_cars_list;
					$c = "";
					if( !empty($car_list) ){
						$clist = explode(",",$car_list);
						foreach( $clist as $cc ){
							$c .= get_car_name($cc) . ", ";
						}
						
					} ?>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl border_right_none"><strong>Vehicles Available: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php  echo $c; ?></div></td>
					</tr>
				</table>	
				<!--Edit Button-->
				<?php if( !is_salesteam() ){ ?>
				<div class="text-center">
					<a title='Edit Transporter' href="<?php echo site_url("vehicles/transporteredit/{$vehicle->id}"); ?>" class="" ><i class="fa fa-pencil"></i> Edit Transporter</a> OR 
					<a class="" href="<?php echo site_url("vehicles/transporteradd"); ?>" title="Add Transporter"><i class="fa fa-plus"></i> Add Transporter</a>
				</div>	
				<?php } ?>
			</div>	
		</div>	
	</div>
</div>
<?php } ?>	

