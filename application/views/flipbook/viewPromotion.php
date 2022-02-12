<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
				<?php $message = $this->session->flashdata('success'); 
		if($message){ echo '<span class="help-block help-block-success">'.$message.'</span>'; }
		?>
		<!--error message-->
		<?php $err = $this->session->flashdata('error'); 
		if($err){ echo '<span class="help-block help-block-error2 red">'.$err.'</span>';}
		?>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption"><i class="fa fa-users"></i>Promotion Name: <strong><?php echo $promotion[0]->promotion_name; ?></strong></div>
					<a class="btn btn-success" href="<?php echo site_url("flipbook/promotion"); ?>" title="Back">Back</a>
				</div>
			</div>
			
			<div class="portlet-body">
				<h3>Promotion Details</h3>
				<div class="table-responsive">	
				<table class="table table-condensed table-hover">	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Promotion Name: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $promotion[0]->promotion_name; ?></div></td>
						<input type="hidden" id='prmoId' value="<?php echo $promotion[0]->id; ?>" />
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>State: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_state_name($promotion[0]->state); ?></div></td>
					</tr>
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>City: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo get_city_name($promotion[0]->city); ?></div></td>
					</tr>	
					<tr>
						<td width="20%"><div class="col-mdd-2 form_vl"><strong>Place: </strong></div></td>	
						<td><div class="col-mdd-10 form_vr"><?php echo $promotion[0]->area; ?></div></td>

					</tr>	
				
				</table>	
				
				<div class="text-center">
					<a title='Edit User' class="btn btn-success pull-left" href="<?php echo site_url("flipbook/addpages/{$promotion[0]->id}"); ?>" class="" ><i class="fa fa-pencil"></i>Add Pages</a>
					<br>	
				</div>	
			</div>	
			<?php if(isset($pages) && !empty($pages) ){ ?>
			<a class="btn btn-success"   target = '_blank'  href="<?php echo site_url("flipbook/viewpromotion/").$promotion[0]->id.'/'.$promotion[0]->tmp_key;?>" title="Back">View Promotion </a>
			<a class="btn btn-success"   target = '_blank'  href="<?php echo site_url("flipbook/managePages/").$promotion[0]->id;?>" title="Back">Manage Pages </a>
		<section>
		<h2>Order pages</h2>
			<p class="alert alert-info">Drag to order pages and then click 'Save'</p>
			<div id="orderResult" width="20%"></div>
		<input type="button" id="save" value="Save" class="btn btn-primary" />
		</section>
		<?php }else{ echo 'No pages Available'; }?>
	</div>
</div>
<div class="loader"></div>

<script>
jQuery(function() {
	var id = $('#prmoId').val();
	$.post('<?php echo site_url('flipbook/orderajax'); ?>', {'id':id}, function(data){
		$('#orderResult').html(data);
	});

	$('#save').click(function(){
		cSortable = $('.sortable').sortable('toArray');
						console.log(cSortable);

$('#orderResult').slideUp(function(){
			$.post('<?php echo site_url('flipbook/orderajax'); ?>', { sortable: cSortable ,'id':id }, function(data){
				$('#orderResult').html(data);
				$('#orderResult').slideDown();
			});
		});
		
	});
});
</script>	