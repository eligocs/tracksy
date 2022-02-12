<style>.input-large {
    width: 400px !important;
}</style>
<div class="page-container customer_content">
	<div class="page-content-wrapper">
		<div class="page-content">
	
			<?php $message = $this->session->flashdata('error'); 
			if($message){ echo '<span class="help-block help-block-error1 red">'.$message.'</span>';} ?>
			
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-plus"></i>Add Season
						</div>
						<a class="btn btn-success" href="<?php echo site_url("hotels/seasons"); ?>" title="Back">Back</a>
					</div>
				</div>
			<form role="form" id="addSeason" method="post" action="<?php echo site_url("hotels/saveseason"); ?>">
				<div class="portlet-body">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label">Season Name*</label>
							<input type="text" required placeholder="Season Name. eg: Mid Season etc." name="inp[season_name]" class="form-control" value=""/> 
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="col-md-6">
						<label class="control-label">Season Dates*</label>
						<div class="mt-repeater">
							<div data-repeater-list="season_date_meta">
								<div data-repeater-item class="mt-repeater-item mt-overflow">
								<div class="mt-repeater-cell">
									<div class="input-group input-large input-daterange mmt-repeater-input-inline">
										<input readonly required type="text" class="form-control season_from" name="season_from" value="" >
										<span class="input-group-addon hotel_addon"> to </span>
										<input readonly required type="text" class="form-control season_to" name="season_to" value=""  > 
									</div>
									<a href="javascript:;" data-repeater-delete class="btn btn-danger mt-repeater-delete mt-repeater-del-left mt-repeater-btn-inline">
										<i class="fa fa-close"></i>
									</a>
								</div>
								</div>
							</div>
							<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add pull-right">
							<i class="fa fa-plus"></i> Add new</a>
							
						</div>
					</div>
				</div> <!-- row -->
				<div class="clearfix"></div>
				<hr>
				<div class="margiv-top-10">
					<button type="submit" class="btn green uppercase add_roomcategory">Add Season</button>
				</div>
			</form>
			</div><!-- portlet body -->
			</div> <!-- portlet -->
		</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->
 </div>
<script>
jQuery(document).ready(function($){
	//Get First and Last Date of year
	var firstDayYear = new Date(new Date().getFullYear(), 0, 1);
	var lastDayYear = new Date(new Date().getFullYear(), 11, 31);
	
	$('.input-daterange').datepicker({
		startDate: firstDayYear,
		endDate: lastDayYear,
		format: 'yyyy-mm-dd',
	});
	
	//Season From Date change
	$(document).on("click", ".season_from", function(){
		$(this).datepicker({	
			startDate: firstDayYear,
			endDate: lastDayYear,
			autoclose: true,
			format: 'yyyy-mm-dd',
		}).on('changeDate', function (selected) {
			var season_to = $(this).datepicker('getDate');
			var nextDayMin = moment(season_to).add(1, 'day').toDate();
			$(this).parent().find('.season_to').datepicker('setStartDate', nextDayMin);
			//$(this).parent().find('.season_to').datepicker('setEndDate', lastDayYear);
		});	
	});
	
	//Season To Date change
	$(document).on("click", ".season_to", function(){
		var season_from = $(this).parent().find(".season_from").datepicker('getDate');
		var nextDayMin = moment(season_from).add(1, 'day').toDate();
		//var CheckIn = $(this).datepicker('getDate');
		$(this).datepicker({	
			autoclose: true,
			startDate: nextDayMin,
			endDate: lastDayYear,
			format: 'yyyy-mm-dd',
		}).on('changeDate', function (selected) {
			var season_from = $(this).datepicker('getDate');
			var nextDayMin = moment(season_from).add(1, 'day').toDate();
			//$(this).parent().find('.season_to').datepicker('setStartDate', firstDayYear);
			$(this).parent().find('.season_from').datepicker('setEndDate', nextDayMin);
		});	
	});
});	
</script>

<script type="text/javascript">
	/* Hotel Exclusion repeater */
	jQuery(document).ready(function($) {
		FormRepeater.init();
	});
	var FormRepeater = function () {
		return {
			init: function () {
				jQuery('.mt-repeater').each(function(){ 
					$(this).find(".mt-repeater-delete:eq( 0 )").hide();
					$(this).repeater({
						show: function () {
							$(this).find(".mt-repeater-delete:eq( 0 )").show();
							
							var firstDayYear = new Date(new Date().getFullYear(), 0, 1);
							var lastDayYear = new Date(new Date().getFullYear(), 11, 31);
	
							var prevDiv = $(this).prev(".mt-repeater-item");
							var lastDate = prevDiv.find(".season_to").datepicker('getDate');
							//var CheckIn = $(this).datepicker('getDate');
							var nextDayMin = moment(lastDate).add(1, 'day').toDate();
							//Get First and Last Date of year
							$('.input-daterange').datepicker({
								format: 'yyyy-mm-dd',
								startDate: nextDayMin
							});
							$(this).find('.season_from').datepicker('setStartDate', nextDayMin);
							$(this).find('.season_from').datepicker('setEndDate', lastDayYear);
							
							$(this).find('.season_to').datepicker('setStartDate', nextDayMin);
							$(this).find('.season_to').datepicker('setEndDate', lastDayYear);
							
							$(this).show();
						},
						hide: function (deleteElement) {
							if(confirm('Are you sure you want to delete this element?')) {
								$(this).slideUp(deleteElement);
							}
						},
						ready: function (setIndexes) {

						}

					});
				});
			}	
		};
	}();
</script>

<script type="text/javascript">
jQuery(document).ready(function($){
	$("#addSeason").validate();	
}); 
</script>
