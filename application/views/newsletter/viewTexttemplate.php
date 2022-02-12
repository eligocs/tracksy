<?php
 if($Text_Template){ 	$news = $Text_Template[0]; 
?>
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-newspaper-o" aria-hidden="true"></i>View Text Template</div>
					<a class="btn btn-success pull-right" href="<?php echo site_url("newsletters"); ?>" title="Back">Back</a>
				</div>
			</div>
			<!--Show success message if Category edit/add -->
			<?php $message = $this->session->flashdata('success'); 
				if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
			?>
			<div class="portlet-body">
			<h3 class="text-center">Text Template Details</h3>
				<div class="table-responsive">	
					<table class="table table-condensed table-hover">	
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Text Template Id: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $news->id; ?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Template Type:</strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php if($news->template_type == 1){ $typ = "Holiday"; }else{ $typ =  "Accomodation";} echo $typ;?></div></td>
						</tr>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Text Template Greeting: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><?php echo $news->greeting; ?></div></td>
						</tr>
						<?php $slug	= $news->slug;
							$link 	= base_url() . "promotion/templateText/{$slug}"; ?>
						<tr>
							<td width="20%"><div class="col-mdd-2 form_vl"><strong>Text Template Link: </strong></div></td>	
							<td><div class="col-mdd-10 form_vr"><a href="<?php echo $link; ?>" title="click to visit" target="_blank"><?php echo $link; ?></div></td>
						</tr>
						
					</table>
				</div>
			</div>	
		</div>
	</div>
</div>
<?php }else{
	redirect('newsletters/templateList');	 
 } ?>