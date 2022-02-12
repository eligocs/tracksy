<?php if($newsletter){ 	$news = $newsletter[0]; ?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>View Message</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("msg_center"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
			<h3 class="text-center">Newsletter Details</h3>
				<div class="text-center"><a href="<?php echo base_url("msg_center/resend_message/{$news->id}") ?>" class="btn btn-success">Click here to sent message</a></div>
				<div class="table-responsive">	
					<table class="table table-condensed table-hover">	
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Message Id: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $news->id; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Sent Contacts: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $news->sent_to; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Message Body: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo htmlspecialchars_decode($news->message); ?></div></td>
						</tr>
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>
<?php } ?>	

