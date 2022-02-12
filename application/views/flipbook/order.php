<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
<section>
	<h2>Order pages</h2>
	<p class="alert alert-info">Drag to order pages and then click 'Save'</p>
	<div id="orderResult" width="20%"></div>
	<input type="button" id="save" value="Save" class="btn btn-primary" />
</section>
</div>
</div>
</div>
<script>
jQuery(function() {
	$.post('<?php echo site_url('flipbook/orderajax'); ?>', {}, function(data){
		$('#orderResult').html(data);
	});

	$('#save').click(function(){
		cSortable = $('.sortable').sortable('toArray');
						console.log(cSortable);

$('#orderResult').slideUp(function(){
			$.post('<?php echo site_url('flipbook/orderajax'); ?>', { sortable: cSortable }, function(data){
				$('#orderResult').html(data);
				$('#orderResult').slideDown();
			});
		});
		
	});
});
</script>