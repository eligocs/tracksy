<?php
	//date use to filter
	$from = date('Y-m-01');
	$to = date('Y-m-t');
	//from date from app start
	$from_start = "2017-11-01";
	$today_date = date('Y-m-d');
	//This Month
	$this_month = date("Y-m");
?>
<div class="page-content-wrapper sales_team_dashboard" ng-app='myapp' ng-controller="dashCtrl">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
		<div class="theme-panel hidden-xs hidden-sm">
			<div class="toggler"> </div>
			<div class="toggler-close"> </div>
			<div class="theme-options">
				<div class="theme-option theme-colors clearfix">
					<span> THEME COLOR </span>
					<ul id="theme_color_listing">
						<li class="color-default current tooltips" data-style="default" data-container="body" data-original-title="Default"> </li>
						<li class="color-darkblue tooltips" data-style="theme_dark" data-container="body" data-original-title="Theme Dark"> </li>
						<li class="color-blue tooltips" data-style="theme_light" data-container="body" data-original-title="Theme Light"> </li>
					</ul>
				</div>
				<div class="th_response"></div>
				
			</div>
		</div>
	 
		<!-- BEGIN PAGE BAR -->
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="<?php echo base_url(); ?>">Home</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<span>Dashboard</span>
				</li>
			</ul>
		</div>
		<!-- END PAGE BAR -->
		<!-- BEGIN PAGE TITLE-->
		<h1 class="page-title"> Admin Dashboard
			<small>Users, recent customers and vouchers</small>
		</h1>
		<!-- END PAGE TITLE-->
		<!-- END PAGE HEADER-->
		<!-- BEGIN DASHBOARD STATS 1-->
		<div class="row">
			<div class="portlet box blue">
				<div class="">
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("agents"); ?>">
							<div class="visual">
								<i class="fa fa-comments"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo isset($total_agents) ? $total_agents : 0; ?>">0</span>
								</div>
								<div class="desc"> Total Users </div>
							</div>
						</a>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 red" href="<?php echo site_url("customers"); ?>">
							<div class="visual">
								<i class="fa fa-bar-chart-o"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo isset($total_customers) ? $total_customers : 0; ?>">0</span> </div>
								<div class="desc"> Total Customers </div>
							</div>
						</a>
					</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 green" href="<?php echo site_url("itineraries"); ?>">
							<div class="visual">
								<i class="fa fa-shopping-cart"></i>
							</div>
							<div class="details">
								<div class="number">
									<span data-counter="counterup" data-value="<?php echo isset($total_iti) ? $total_iti : 0; ?>">0</span>
								</div>
								<div class="desc"> Total Itineraries </div>
							</div>
						</a>
					</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="callCountBlock">
						<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("vouchers"); ?>">
							<div class="visual">
								<i class="fa fa-globe"></i>
							</div>
							<div class="details">
								<div class="number"> 
									<span data-counter="counterup" data-value="<?php echo isset($total_vouchers) ? $total_vouchers : 0; ?>">0</span> </div>
								<div class="desc"> Total Vouchers </div>
							</div>
						</a>
					</div>
			</div>
			</div>
			
		</div>
		<div class="clearfix"></div>
		<!-- END DASHBOARD STATS 1-->
		<!-- ITINERARIES MONTHLY STATUS 1-->
			<div class="">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?leadfrom={$from}&leadto={$to}&leadStatus=all"; ?>">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_iti_month) ? $total_iti_month : 0; ?>">0</span>
							</div>
							<div class="desc"> Total Itineraries<br> This Month </div>
						</div>
					</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?leadfrom={$from}&leadto={$to}&leadStatus=9"; ?>">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_iti_booked_month) ? $total_iti_booked_month : 0; ?>">0</span> </div>
							<div class="desc">Booked Itineraries<br> This Month </div>
						</div>
					</a>
				</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries"). "/?leadfrom={$from}&leadto={$to}&leadStatus=7"; ?>">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_iti_dec_month) ? $total_iti_dec_month : 0; ?>">0</span>
							</div>
							<div class="desc">Declined Itineraries<br> This Month </div>
						</div>
					</a>
				</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("vouchers"); ?>">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number"> 
								<span data-counter="counterup" data-value="<?php echo isset($voucher_confirm_month) ? $voucher_confirm_month : 0; ?>">0</span> </div>
							<div class="desc">Confirm Vouchers<br>This Month </div>
						</div>
					</a>
				</div>
		</div>
			
			<!--leads monthly status-->
						<div class="">
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?leadfrom={$from}&leadto={$to}&leadStatus=all"; ?>">
						<div class="visual">
							<i class="fa fa-comments"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_cus_month) ? $total_cus_month : 0; ?>">0</span>
							</div>
							<div class="desc"> Total Customers<br>This Month </div>
						</div>
					</a>
					</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?leadfrom={$from}&leadto={$to}&leadStatus=9"; ?>">
						<div class="visual">
							<i class="fa fa-bar-chart-o"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_cus_booked_month) ? $total_cus_booked_month : 0; ?>">0</span> </div>
							<div class="desc"> Booked Leads<br>This Month </div>
						</div>
					</a>
				</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?leadfrom={$from}&leadto={$to}&leadStatus=8"; ?>">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								<span data-counter="counterup" data-value="<?php echo isset($total_cus_dec_month) ? $total_cus_dec_month : 0; ?>">0</span>
							</div>
							<div class="desc"> Declined Leads<br>This Month </div>
						</div>
					</a>
				</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				<div class="callCountBlock">
					<a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers"). "/?leadfrom={$from}&leadto={$to}&leadStatus=pending"; ?>">
						<div class="visual">
							<i class="fa fa-globe"></i>
						</div>
						<div class="details">
							<div class="number"> 
								<span data-counter="counterup" data-value="<?php echo isset($working_lead_month) ? $working_lead_month : 0; ?>">0</span> </div>
									<div class="desc"> Working Leads<br>This Month </div>
						</div>
					</a>
				</div>
			</div>

		
		
	</div>
	
	<!-- END CONTENT BODY -->
	<div class="clearfix"></div>
		<!--Chart Section-->
		<div class="col-md-12">
			<div class="portlet light portlet-fit bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-bar-chart" style="font-size:30px;"></i>
						<span class="caption-subject font-green bold uppercase">Statistics</span>
					</div>
				</div>
				<div class="col-md-6">
					<div class="titile_section">
						<h3 class="col-lg-6">ITINERARIES GRAPH</h3>
						<div class="form-group col-lg-6 pull-right">
							<label for="sel1">Select Year:</label>
							<select class="form-control" id="year_iti">
							<?php 			
							$current_year = date('Y');
								for( $year = 2017; $year <=  $current_year; $year++ ) {
									$selected = $year == $current_year ? 'selected = selected' : '';
									echo "<option value={$year} {$selected} >{$year}</option>";
								}
							?>
							</select>
						</div>
					</div>	
					<div class="portlet-body card-padding">
						<div class="loader_iti processer"><img class="img-responsive" src="<?php echo base_url();?>site/images/loader.gif" /></div>
						<div id="iti_echarts_bar" style="height:400px;"></div>
					</div>
				</div>
				<div class="col-md-6">
						<div class="titile_section">
							<h3 class="col-lg-6">LEADS GRAPH</h3>
							<div class="form-group col-lg-6 pull-right">
							<label for="seld1">Select Year:</label>
							<select class="form-control" id="year_leads">
								<?php 			
								$current_year = date('Y');
									for( $year1 = 2017; $year1 <=  $current_year; $year1++ ) {
										$selected = $year1 == $current_year ? 'selected = selected' : '';
										echo "<option value={$year1} {$selected} >{$year1}</option>";
									}
								?>
							</select>
						</div>	
					</div>
					<div class="portlet-body">
						<div class="loader_lead processer"><img class="img-responsive" src="<?php echo base_url();?>site/images/loader.gif" /></div>
						<div id="leads_echarts_bar" style="height:400px;"></div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<hr>
		<br>
		<br>
		<br>
		<br>
	</div>
	<!--End Chart Section-->
</div>
<!-- END CONTENT -->
<!-- END QUICK SIDEBAR -->
</div>
</div>
<!-- END CONTAINER -->
<!--angular js-->
<!--script>
	var fetch = angular.module('myapp', []);
	fetch.controller('dashCtrl', ['$scope', '$http', function ($scope, $http) {
		$http({
			method: 'get',
			url: 'getData.php'
		}).then(function successCallback(response) {
			// Store response data
			$scope.users = response.data;
		});
	}
	]);
</script-->