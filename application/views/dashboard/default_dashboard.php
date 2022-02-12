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
<!-- BEGIN CONTENT User Role: 96 -->
<div class="page-content-wrapper sales_team_dashboard">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
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
		<nav class="quick-nav">
            <a class="quick-nav-trigger" href="javascript: void(0)">
                <span aria-hidden="true"></span>
            </a>
            <ul class="sidebar-buttons">
                <li><button class="btn sidebar-button btn-side-1 cal_toggle_btn" data-target="myModal1"><i class="fa fa-users"></i> Lead Follow Up</button></li>
				<!--li><button class="btn sidebar-button btn-side-2 cal_toggle_btn" data-target="myModal2"><i class="fa fa-map"></i> Holiday Follow Up</button></li-->
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>
        </nav>
		<div class="quick-nav-overlay"></div>
		<!-- END PAGE BAR -->
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
		<!-- BEGIN PAGE TITLE-->
		<h1 class="page-title">Dashboard
		</h1>
		<div class="row">
			<h1 class="uppercase text-center">Welcome to trackitinerary</h1>
		</div>
</div>
</div>			