<!-- BEGIN CONTENT User Role: 96 -->
<div class="page-content-wrapper sales_team_dashboard">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>">Home</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<span>User Dashboard</span>
				</li>
			</ul>
		</div>
		<div class="row">
			<div class="container">
					<h3 class="text-center">User Dashboard </h3>
					<div class="getDashboardSection" id="getDashboardSection">
						<form id="salesTeamDashboarFrm">
							<?php /* if( is_admin() ){ ?>
								<div class="col-md-4">
								<div class="form-group">
									<label>Select manager<span style="color:red;">*</span></label>
									<?php if( !empty( $managers ) ){ ?>
										<select required class="form-control" id='manager_user_id' name="manager_id">
											<option value="">Select User</option>
											<?php foreach( $managers as $user ){ ?>
												<option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?></option>
											<?php } ?>
										</select>
									<?php }else{ ?>
										<p>No Users found!.
									<?php } ?>
								</div>
								</div>
							<?php } */ ?>
							<div class="col-md-offset-4 col-md-4">
								<div class="form-group">
									<label>Select salesteam user<span style="color:red;">*</span></label>
									<?php if( !empty( $sales_team_users ) ){ ?>
										<select required class="form-control" id='sales_user_id' name="user_id">
											<option value="">Select User</option>
											<?php foreach( $sales_team_users as $user ){ ?>
												<option value="<?php echo $user->user_id; ?>"><?php echo $user->user_name . " ( " . ucfirst( $user->first_name ) . " "  . ucfirst( $user->last_name) . " )"; ?></option>
											<?php } ?>
										</select>
									<?php }else{ ?>
										<p>No Users found!.
									<?php } ?>
								</div>
							</div>
						</form>
					</div>	
				
			</div>	
		</div>
		
</div><!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<script>
jQuery(document).ready(function($){
	$(document).on("change", "#sales_user_id", function(){
		var user_id = $(this).val();
		if( user_id == '' ){
			alert( "Please select user" );
			return false;
		}
		//alert("user: " + user_id);
		var redirect_url = "<?php echo site_url('dashboard/user_dashboard'); ?>?user_id=" + user_id ;
		//alert( redirect_url );
		window.location.href = redirect_url ;
	});
	
	//manager dashboard
	$(document).on("change", "#manager_user_id", function(){
		var user_id = $(this).val();
		if( user_id == '' ){
			alert( "Please select user" );
			return false;
		}
		//alert("user: " + user_id);
		var redirect_url = "<?php echo site_url('dashboard/user_dashboard'); ?>?manager_id=" + user_id ;
		//alert( redirect_url );
		window.location.href = redirect_url ;
	});
});
</script>