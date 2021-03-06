<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" rel="stylesheet" type="text/css" />
<div class="page-container">
	<div class="page-content-wrapper">
		<div class="page-content">
		 <!-- BEGIN SAMPLE TABLE PORTLET-->
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-gift"></i>Agents Incentive
					</div>
				</div>
			</div>
			<?php $sales_team_agents = get_all_sales_team_agents(); ?>
				<div class="row clearfix">
					<form id="frmInsentivecal">
					
						<div class="col-md-offset-3 col-md-3">
							<div class="form-group">
								<label for="daterange">Select Month*:</label>
								<input type="text" required autocomplete="off" class="form-control" id="daterange" name="dateRange" value="" required />
							</div> 
						</div>
						
						<?php if( is_teamleader() ){
							$team_members = is_teamleader(); ?>
							<div class="col-md-3">
								<div class="form-group">
									<label for="sales_user_id">Select Team Member*:</label>
									<select required class="form-control select_user" id='sales_user_id' name="user_id">
										<option value="">Select Team Member</option>
										<?php if( $team_members ){
											foreach( $team_members as $mem ){
												$user_n = get_user_name($mem);
												echo "<option value={$mem}>{$user_n}</option>";
											}
										} ?>
									</select>
								</div> 
							</div>
						<?php } ?>
						
						<div class="col-md-3">
						<div class="form-group">
							<br>
							<input type="submit" class="btn btn-success" value="Generate Incentive">
							<input type="hidden" id="datefrom" name="datefrom" value="<?php echo date("Y-m"); ?>" >
						</div>
						</div>
						<div class="clearfix"></div>
						<div class="processing"></div>
					</form>	
				</div>	
				<div class="clearfix"></div>
				<hr>
			<div class="portlet-body">
				<div class='agent_info_section' style="display:none;">
					<!--theme 1-->
					<div class="cong_theme_1 cntheme">
						<div class="clearfix congrats">
							<h1>Congratulations!</h1>
						</div><!--END theme 1-->
					</div>	
					
					<!--THEME 2 -->
					<div class="cong_theme_2 cntheme">
						<!--div class="fix_cong_section"></div>
						<div class="congo_text">
							<div class="canvas_text showMe">
								<p class="text-congrat">Congratulations</p>
							</div>
						</div-->
					</div>	
					<!--END THEM 2-->
					
					<h4 class='text-center target_section'></h4>
					<h4 class='text-center'><strong class="red ainfo_name">Name: </strong><span id='ainfo_name'></span> <strong class='red'>Month: </strong><span id='ainfo_month'></span></h4>
					
					<div class="table-responsive">
						<table class="table table-bordered display" id="table" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th> # </th>
									<th> ID </th>
									<th> B. Date </th>
									<th> T. Date </th>
									<th> B. Price </th>
									<th> Margin (%) </th>
									<th> Cost </th>
									<th> Advance </th>
									<th> 2nd Inst. Date </th>
									<th> S1 </th>
									<th> S2 </th>
									<th> S3 </th>
									<th title="FIXED DEPARTURE PACKAGE INCENTIVE"> S5 </th>
								</tr>
							</thead>
							<tbody class="ins_data">
								
							</tbody>
						</table>
					</div>
					
					<!--Incentive Terms and conditions-->
					<div class="cong_theme_1 cntheme">
						<div class="clearfix congrats">
							<h1>Congratulations!</h1>
						</div>
					</div>	
					<!--Incentive Terms and conditions-->
					<div class="clearfix incentive_terms_section">
						
					</div>
					
				</div>
			</div>
		</div>
		
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- Modal -->

<style>
.congrats {
    position: relative;
    bottom: 30px;
    width: 550px;
    height: 100px;
    padding: 20px 10px;
    text-align: center;
    margin: 0 auto;
    left: 0;
    right: 0;
	display: block;
}

.incentive_terms_section .alert-success {
    background-color: #37b55d;
    border-color: #209643;
    color: #ffffff;
}
h1 {
	transform-origin: 50% 50%;
    font-size: 50px;
    cursor: pointer;
    z-index: 2;
    top: 0;
    text-align: center;
    width: 100%;
    color: #E91E63;
    text-shadow: 1px 3px 0px #61082678;
}

.blob {
	height: 50px;
	width: 50px;
	color: #ffcc00;
	position: absolute;
	top: 45%;
	left: 45%;
	z-index: 1;
	font-size: 30px;
	display: block;	
}
.cntheme{display: none;}
</style>
<!-- Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.2/underscore-min.js"></script>
<script src="<?php echo base_url();?>site/assets/js/jquery.fireworks.js" type="text/javascript"></script>

<script type="text/javascript">
 jQuery(document).ready(function($){
	$('#daterange').datepicker({
		startDate: new Date('2019-01-01'),
		autoclose: true,
		minViewMode: 1,
		endDate: '+0m',
		format: 'MM, yyyy'
	}).on('changeDate', function(selected){
		//console.log( selected.format('yyyy-mm') );
		$("#datefrom").val(selected.format('yyyy-mm'));
	}).datepicker("setDate",'now');
}); 
//$('#daterange').datepicker('update', new Date());
</script>
<script type="text/javascript">
var table;
$(document).ready(function() {
    //datatables
    $("#frmInsentivecal").validate({
		submitHandler: function(form) {
			$(".agent_info_section").show();
			var month_a = $("#daterange").val();
			$("#ainfo_month").text(month_a);
			var agent_name = $("#sales_user_id").find('option:selected').text();
			//console.log( agent_name );
			if( agent_name == "" ){
				$(".ainfo_name").hide();
			}	
			$("#ainfo_name").text(agent_name);
			
			var resp	 = $(".processing");
			var congrats	 = $(".cntheme");
			var ins_data = $(".ins_data");
			var target_section = $(".target_section");
			var terms = $(".incentive_terms_section");
			var formData = $("#frmInsentivecal").serializeArray();
			
			//console.log(formData);
			//console.log(formData);
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('incentive/ajax_check_agent_incentive'); ?>",
				dataType: 'json',
				data: formData,
				beforeSend: function(){
					resp.html('<p class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
					congrats.hide();
				},
				success: function(res) {
					if (res.status == true){
						resp.html('');
						ins_data.html(res.data);
						terms.html(res.terms);
						target_section.html(res.target_data);
						
						//if target complete show congratulation msg
						if( res.succ == 1 ){
							var random_theme = Math.floor(Math.random() * 2) + 1;
							//console.log( random_theme );
							$(".congo_text, .fix_cong_section ").remove();
							$(".cong_theme_2").html('<div class="fix_cong_section"></div><div class="congo_text"><div class="canvas_text showMe"><p class="text-congrat">Congratulations</p></div></div>');
							
							//congratulation section THEME 2
							if( random_theme == 2  ){
								$('.congo_text').fireworks({
									sound: false,
									opacity: 0.6, 
									width: '100%',
									height: '100%'
								});
								setTimeout( '$(".congo_text, .fix_cong_section ").remove()', 7000 );
							}
							//THEME congo
							$(".cong_theme_" + random_theme ).show();
						}
					}else{
						congrats.hide();
						ins_data.html("");
						terms.html("");
						target_section.html("");
					}
				},
				error: function(e){
					console.log(e);
					congrats.hide();
					ins_data.html("");
					terms.html("");
					target_section.html("");
					resp.html('<div class="alert alert-danger"><strong>Error!</strong>Please Try again later! </div>');
				}
			});
			return false;
		}
	});	
	
	
	//CONGRATULATIONS SCRIPT
	$(function() {
		var numberOfStars = 20;
		for (var i = 0; i < numberOfStars; i++) {
		  $('.congrats').append('<div class="blob fa fa-star ' + i + '"></div>');
		}
		animateText();	
		animateBlobs();
	});

	/*
	$('.congrats').click(function() {
		reset();	
		animateText();	
		animateBlobs();
	}); */

	function reset() {
		$.each($('.blob'), function(i) {
			TweenMax.set($(this), { x: 0, y: 0, opacity: 1 });
		});
		TweenMax.set($('h1'), { scale: 1, opacity: 1, rotation: 0 });
	}

		function animateText() {
			TweenMax.from($('h1'), 0.8, {
			scale: 0.4,
			opacity: 0,
			repeat: -1,
			rotation: 15,
			ease: Back.easeOut.config(4),
		});
	}
		
	function animateBlobs() {
		var xSeed = _.random(350, 380);
		var ySeed = _.random(120, 170);
		
		$.each($('.blob'), function(i) {
			var $blob = $(this);
			var speed = _.random(1, 5);
			var rotation = _.random(5, 100);
			var scale = _.random(0.8, 1.5);
			var x = _.random(-xSeed, xSeed);
			var y = _.random(-ySeed, ySeed);

			TweenMax.to($blob, speed, {
				x: x,
				y: y,
				repeat: -1,
				ease: Power1.easeOut,
				opacity: 0,
				rotation: rotation,
				scale: scale,
				onStartParams: [$blob],
				onStart: function($element) {
					$element.css('display', 'block');
				},
				onCompleteParams: [$blob],
				onComplete: function($element) {
					$element.css('display', 'none');
				}
			});
		});
	}
});
</script>