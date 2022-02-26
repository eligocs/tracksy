	<!-----------------Popup THOUGHT OF THE DAY----------------------->
		<?php if( !empty( get_thought_of_day() ) ){ ?>
			<a class="btn green btn-outline sbold thought-btn" id="checkTODbtn" data-toggle="modal" href="#thoughtOfDayPopup"> Latest Update </a>
			<div class="modal fade " id="thoughtOfDayPopup" tabindex="-1" role="basic" aria-hidden="true" >
				<div class="modal-dialog">
					<div class="modal-content">
					
						<div class="modal-header ui-draggable-handle">
							<button type="button" class="close closetModal" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title text-center"><i class="fa fa-thumbs-o-up"></i> &nbsp; Latest Update </h4>
						</div>
						
						<div class="modal-body">
							<?php echo get_thought_of_day(); ?> 
						</div>
						
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			
			<?php 
			//check time
			if( ((int) date('H')) >= 11 ){ ?>
				<script>
					jQuery( document ).ready(function($){
						//var dt = new Date();
						//var hours = dt.getHours();
						//var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
						//if( hours <= 18 ){
							//showTODPopup();
						//}
						
						//Set Cookie
						if ( !!$.cookie('openThoughtPopup') ) {
							// have cookie
							//console.log("have cookies");
						} else {
							//console.log("Not have cookies");
							// no cookie
							//set cookie for 1 minute
							showTODPopup();
						}
						function showTODPopup(){
							$("#thoughtOfDayPopup").show();
							var date = new Date();
							//set cookie time in minutes
							var minutes = 800;
							date.setTime(date.getTime() + (minutes * 60 * 1000));
							$.cookie("openThoughtPopup", true , { path: '/', expires: date });
						}
					});
				</script>
			<?php } ?>
			<script>
			jQuery( document ).ready(function($){
				$(document).on("click", "#checkTODbtn", function (e){
					e.preventDefault();
					console.log("clicke");
					$("#thoughtOfDayPopup").show();
				});
				
				//close popup
				$(".closetModal").click(function(){
					$("#thoughtOfDayPopup").fadeOut();
					var video = $("#iframe_tod").attr("src");
					$("#iframe_tod").attr("src","");
					$("#iframe_tod").attr("src",video);
				});
			});
			</script>
		<?php } ?>
	<!--------------------Popup THOUGHT OF THE DAY end------------>
		
		
		<!-- BEGIN FOOTER -->
            <div class="page-footer container">
                <div class="page-footer-inner"> <?php echo date("Y"); ?> &copy; Develop By
                    <a target="_blank" href="http://eligocs.com">Eligocs</a></div>
					<div class="text-right text-white">Page rendered in <strong>{elapsed_time}</strong> seconds</div>
                <div class="scroll-to-top">
                    <i class="icon-arrow-up"></i>
                </div>
            </div>
            <!-- END FOOTER -->
        </div>
		<?php 
			$segment_one =  $this->uri->segment(1);
			$current_url = base_url(uri_string());
		?>
		<!-- Angluar js -->
		
        <!-- BEGIN CORE PLUGINS -->
		<script src="<?php echo base_url();?>site/assets/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>site/assets/js/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/table-bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/moment.min.js" type="text/javascript"></script>
       	<script src="<?php echo base_url();?>site/assets/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
       	<script src="<?php echo base_url();?>site/assets/js/daterangepicker.js" type="text/javascript"></script>
       	<script src="<?php echo base_url();?>site/assets/js/jquery.repeater.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url();?>site/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/morris.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/jquery.counterup.min.js" type="text/javascript"></script>
		<?php /*<script src="<?php echo base_url();?>site/assets/js/jquery.multiselect.js" type="text/javascript"></script> */?>
		<script src="<?php echo base_url();?>site/assets/js/app.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/dashboard.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/fullcalendar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/sweetalert.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/script_themes.js" type="text/javascript"></script>
		<?php /*<script src="<?php echo base_url();?>site/assets/js/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>site/assets/js/quick-nav.min.js" type="text/javascript"></script> */ ?>
		
		<!--call chart script for dashboard only -->
		<?php 
		if( ( $segment_one == "dashboard" || $current_url == base_url() ) && is_admin_or_manager()){ ?>
			<script src="<?php echo base_url();?>site/assets/dist/echarts-all.js" type="text/javascript"></script>
			<script src="<?php echo base_url();?>site/assets/chart/admin_chart.js" type="text/javascript"></script>
			<!-- <script src="<?php echo base_url();?>site/assets/echarts-en.min.js" type="text/javascript"></script> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"> </script> -->
			<!-- <script src="<?php echo base_url();?>site/assets/js/echarts/echarts.js" type="text/javascript"></script>
			<script src="<?php echo base_url();?>site/assets/js/charts_dashboard.js" type="text/javascript"></script> -->
			<?php 
		}
		?>
		<!-------------------- sales Dashboard Chart ------------------------------------>
		<?php
		if(($segment_one == "dashboard" || $current_url == base_url() ) && is_salesteam() ){ ?>
			<script src="<?php echo base_url();?>site/assets/dist/echarts-all.js" type="text/javascript"></script>
			<script src="<?php echo base_url();?>site/assets/chart/sales_chart.js" type="text/javascript"></script>
		<?php } ?>
		
		<!--desktop notifications script 103.97.231.30 -->
		<!--hide notifications for development ip-->
		<?php if (isset( $_SERVER['REMOTE_ADDR']) && ($_SERVER['REMOTE_ADDR'] != '182.75.81.2' && $_SERVER['REMOTE_ADDR'] != '117.247.236.178' )){ ?>
			<script src="<?php echo base_url();?>site/assets/js/notifications.js" type="text/javascript"></script>
		<?php } ?>
		
        <script src="<?php echo base_url();?>site/assets/js/custom.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>
</html>