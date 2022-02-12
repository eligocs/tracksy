

<?php
   //date use to filter
   $from = date('Y-m-01');
   $to = date('Y-m-t');
   //from date from app start
   $from_start = "2017-11-01";
   $today_date = date('Y-m-d');
   //This Month
   $this_month = date("Y-m");
   $todAy = date("Y-m-d");
   ?>
<!-- END SIDEBAR -->
<!-- BEGIN CONTENT -->
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
      <!-- BEGIN PAGE BAR -->
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li>
               <a href="<?php echo site_url(); ?>">Home</a>
               <i class="fa fa-circle"></i>
            </li>
            <li>
               <span>Dashboard</span>
            </li>
         </ul>
      </div>
      <!-- END PAGE BAR -->
      <!-- BEGIN PAGE TITLE-->
      <h1 class="page-title"> Leads Team Dashboard
         <small>recent declined itineraries etc.</small>
      </h1>
      <!-- END PAGE TITLE-->
      <!-- END PAGE HEADER-->
      <!-- BEGIN DASHBOARD STATS 1-->
      <div class="portlet box blue">
         <div class="portlet-title">
            <div class="caption"><i class="fa fa-calendar"></i>Itineraries Status</div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("customers") . "/?todayStatus={$todAy}&leadStatus=declined"; ?>">
                  <div class="visual">
                     <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($leads_declined_today) ? $leads_declined_today : 0; ?>">0</span> 
                     </div>
                     <div class="desc"> Today's Declined <br>Leads </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("customers") . "/?todayStatus={$this_month}&leadStatus=declined"; ?>">
                  <div class="visual">
                     <i class="fa fa-comments"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($leads_declined_month) ? $leads_declined_month : 0; ?>">0</span>
                     </div>
                     <div class="desc"> This Month Declined <br>Leads </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("itineraries") . "/?todayStatus={$todAy}&leadStatus=declined"; ?>">
                  <div class="visual">
                     <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($totalDecItiToday) ? $totalDecItiToday : 0; ?>">0</span> 
                     </div>
                     <div class="desc"> Today's Declined <br>Itineraries </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("itineraries") . "/?todayStatus={$this_month}&leadStatus=declined"; ?>">
                  <div class="visual">
                     <i class="fa fa-comments"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($totalDecItiMonth) ? $totalDecItiMonth : 0; ?>">0</span>
                     </div>
                     <div class="desc"> This Month Declined <br>Itineraries </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 purple" href="<?php echo site_url("marketing") . "/?todayStatus={$todAy}"; ?>">
                  <div class="visual">
                     <i class="fa fa-bar-chart-o"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($marketing_user_today) ? $marketing_user_today : 0; ?>">0</span> 
                     </div>
                     <div class="desc"> Today's Marketing <br>Users </div>
                  </div>
               </a>
            </div>
         </div>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="callCountBlock">
               <a class="dashboard-stat dashboard-stat-v2 blue" href="<?php echo site_url("marketing") . "/?todayStatus={$this_month}"; ?>">
                  <div class="visual">
                     <i class="fa fa-comments"></i>
                  </div>
                  <div class="details">
                     <div class="number">
                        <span data-counter="counterup" data-value="<?php echo isset($marketing_user_month) ? $marketing_user_month : 0; ?>">0</span>
                     </div>
                     <div class="desc"> This Month Marketing <br>Users </div>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
      <!-- END CONTENT BODY -->
   </div>
   <!-- END CONTENT -->
   <!-- END QUICK SIDEBAR -->
</div>

