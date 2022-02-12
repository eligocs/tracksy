 <!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
	<?php 
	/* Get User role admin = 99, manager = 98, sales team = 97, service team = 96 */
	$role = get_user_role(); ?>
	
	<?php $menu_name =  $this->uri->segment(1); ?>
	<?php $menu_name_sub =  $this->uri->segment(2); ?>
		<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li class="sidebar-toggler-wrapper hide">
				<div class="sidebar-toggler">
					<span></span>
				</div>
			</li>
			<?php switch( $role ){ 
				/* Menu For admin and super manager */ 
				case ( $role == 99 || is_super_manager() ) : ?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item">
								<a href="<?php echo site_url("dashboard"); ?>" class="nav-link ">
									<i class="icon-home"></i>
									<span class="title">My Dashboard</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("dashboard/user_dashboard"); ?>" class="nav-link ">
									<i class="icon-user"></i>
									<span class="title">User Dashboard</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "flipbook" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Promotions</span>
							<span class="arrow"></span>
						</a>
						
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("flipbook/promotion"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">Promotions</span>
								</a>
							</li>
						</ul>
						
					</li>
					
					<?php if( is_admin() ){ ?>
						<li class="nav-item  <?php if( $menu_name == "indiatourizm" || $menu_name == "customers" || $menu_name == "search" ){ echo 'active'; }?>">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="fa fa-tripadvisor" aria-hidden="true"></i>
								<span class="title">India Tourizm</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item  ">
									<a href="<?php echo site_url("indiatourizm"); ?>" class="nav-link ">
										<i class="fa fa-users" aria-hidden="true"></i>
										<span class="title">All Queries</span>
									</a>
								</li>
								<li class="nav-item  ">
									<a href="<?php echo site_url("indiatourizm/instant_call"); ?>" class="nav-link ">
										<i class="fa fa-headphones" aria-hidden="true"></i>
										<span class="title">Instant Call</span>
									</a>
								</li>
								<li class="nav-item  ">
									<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
										<i class="fa fa-users" aria-hidden="true"></i>
										<span class="title">All Customers</span>
									</a>
								</li>
								<li class="nav-item  ">
									<a href="<?php echo site_url("customers/customer_type"); ?>" class="nav-link ">
										<i class="fa fa-list-alt" aria-hidden="true"></i>
										<span class="title">Customer Type</span>
									</a>
								</li>
							</ul>
						</li><!--end leads from india tourizm-->
					<?php }else{ ?>
					
						<li class="nav-item  <?php if( $menu_name == "customers" || $menu_name == "search"){ echo 'active'; }?>">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="fa fa-users" aria-hidden="true"></i>
								<span class="title">Customers</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item  ">
									<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
										<i class="fa fa-users" aria-hidden="true"></i>
										<span class="title">All Customers</span>
									</a>
								</li>

								<li class="nav-item  ">
									<a href="<?php echo site_url("customers/customer_type"); ?>" class="nav-link ">
										<i class="fa fa-list-alt" aria-hidden="true"></i>
										<span class="title">Customer Type</span>
									</a>
								</li>
							</ul>
						</li>
					<?php } ?>	
					<li class="nav-item  <?php if( $menu_name == "itineraries" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-plane" aria-hidden="true"></i>
							<span class="title">Itineraries</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries"); ?>" class="nav-link ">
									<i class="icon-layers" aria-hidden="true"></i>
									<span class="title">All Itineraries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/bookeditineraries"); ?>" class="nav-link ">
									<i class="fa fa-book" aria-hidden="true"></i>
									<span class="title">Booked Itineraries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/closediti"); ?>" class="nav-link ">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span class="title">Closed Itineraries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/onholditineraries"); ?>" class="nav-link ">
									<i class="fa fa-random"></i>
									<span class="title">On Hold Itineraries</span><span class="badge badge-info"><?php echo onhold_itieraries_count(); ?></span>
								</a>
							</li>
						</ul>
					</li>
				
					<li class="nav-item  <?php if( $menu_name == "packages" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-cube" aria-hidden="true"></i>
							<span class="title">Packages</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("packages"); ?>" class="nav-link ">
									<i class="fa fa-cube" aria-hidden="true"></i>
									<span class="title">All Packages</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("packages/add"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Add Package</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("packages/viewCategory"); ?>" class="nav-link ">
									<i class="fa fa-cube" aria-hidden="true"></i>
									<span class="title">All Categories</span>
								</a>
							</li>
							
							<!--li class="nav-item  ">
								<a href="<?php echo site_url("packages/managestates"); ?>" class="nav-link ">
									<i class="fa fa-building" aria-hidden="true"></i>
									<span class="title">Manage States</span>
								</a>
							</li-->
						</ul>
					</li>
					
					<li class="nav-item <?php if( $menu_name == "hotelbooking" ){ echo 'active'; }?> ">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-briefcase" aria-hidden="true"></i>
							<span class="title">Hotel Booking</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
						
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotelbooking"); ?>" class="nav-link ">
									<i class="icon-share-alt" aria-hidden="true"></i>
									<span class="title">All Hotel Booking</span>
								</a>
							</li>
							
							<!--li class="nav-item  ">
								<a href="<?php echo site_url("hotelbooking/pending_confirmation_request"); ?>" class="nav-link ">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span class="title">Pending Request</span>
								</a>
							</li-->
							
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "vehiclesbooking" ){ echo 'active'; }?> ">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-bus" aria-hidden="true"></i>
							<span class="title">Vehicle Booking</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehiclesbooking"); ?>" class="nav-link ">
									<i class="icon-share-alt" aria-hidden="true"></i>
									<span class="title">All Cab Booking</span>
								</a>
							</li>
							<!--li class="nav-item  ">
								<a href="<?php echo site_url("vehiclesbooking/pending_confirmation_request"); ?>" class="nav-link ">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span class="title">Pending Cab Request</span>
								</a>
							</li-->
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>" class="nav-link ">
									<i class="fa fa-bus" aria-hidden="true"></i>
									<span class="title">All Volvo/Train/Flight Booking</span>
								</a>
							</li>
							<!--li class="nav-item  ">
								<a title="Pending request volvo/train/flight ticket quotations" href="<?php echo site_url("vehiclesbooking/pending_vtf_confirmation_request"); ?>" class="nav-link ">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span class="title">Pending V/T/F Request</span>
								</a>
							</li-->
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "marketing" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-bar-chart" aria-hidden="true"></i>
							<span class="title">Marketing</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing"); ?>" class="nav-link ">
									<i class="fa fa-bar-chart" aria-hidden="true"></i>
									<span class="title">All User List</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing/viewcat"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Marketing Categories</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing/state_codes"); ?>" class="nav-link ">
									<i class="fa fa-building" aria-hidden="true"></i>
									<span class="title">State Codes</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "reference_customers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Ref Customers</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("reference_customers"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Ref Customers</span>
								</a>
							</li>
						</ul>
					</li>
					
					
					<li class="nav-item  <?php if( $menu_name == "bank" ){ echo 'active'; }?> ">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-globe"></i>
							<span class="title">Global Settings</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item">
								<a href="<?php echo site_url("bank"); ?>" class="nav-link ">
									<i class="icon-wallet"></i>
									<span class="title">All Bank</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("terms"); ?>" class="nav-link ">
									<i class="icon-notebook icons"></i>
									<span class="title">Holiday Terms</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("terms/hotel_terms"); ?>" class="nav-link ">
									<i class="fa fa-h-square" aria-hidden="true"></i>
									<span class="title">Hotel Booking Terms</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("terms/cab_terms"); ?>" class="nav-link ">
									<i class="fa fa-car" aria-hidden="true"></i>
									<span class="title">Cab Booking Terms</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("terms/office_branches"); ?>" class="nav-link ">
									<i class="fa fa-home" aria-hidden="true"></i>
									<span class="title">Office Address</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo site_url("settings/sms"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Sms Settings</span>
								</a>
							</li> 
							<li class="nav-item">
								<a href="<?php echo site_url("settings/social"); ?>" class="nav-link ">
									<i class="fa fa-share-square" aria-hidden="true"></i>
									<span class="title">Social Media Settings</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("settings"); ?>" class="nav-link ">
									<i class="icon-settings icons"></i>
									<span class="title">Settings</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("settings/homepage"); ?>" class="nav-link ">
									<i class="icon-settings icons"></i>
									<span class="title">Homepage Settings</span>
								</a>
							</li>							
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "payments" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-inr" aria-hidden="true"></i>
							<span class="title">Payment Details</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("payments"); ?>" class="nav-link ">
									<i class="fa fa-inr" aria-hidden="true"></i>
									<span class="title">Itineraries Payments</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "hotels" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-pointer"></i>
							<span class="title">Hotels</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels"); ?>" class="nav-link ">
									<i class="icon-pointer"></i>
									<span class="title">All Hotels</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/viewroomcategory"); ?>" class="nav-link ">
									<i class="icon-list"></i>
									<span class="title">View Room Category</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/viewroomrates"); ?>" class="nav-link ">
									<i class="icon-calculator"></i>
									<span class="title">View Room Rates</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/seasons"); ?>" class="nav-link ">
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<span class="title">All Season</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/mealplan"); ?>" class="nav-link ">
									<i class="fa fa-cutlery" aria-hidden="true"></i>
									<span class="title">All Meal Plan</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "vehicles" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-car" aria-hidden="true"></i>
							<span class="title">Vehicles</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehicles"); ?>" class="nav-link ">
									<i class="fa fa-car" aria-hidden="true"></i>
									<span class="title">All Vehicles</span>
								</a>
							</li>
							
							<!--li class="nav-item  ">
								<a href="<?php echo site_url("vehicles/vehicle_packages"); ?>" class="nav-link ">
									<i class="fa fa-money" aria-hidden="true"></i>
									<span class="title">Vehicles Packages</span>
								</a>
							</li-->
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehicles/transporters"); ?>" class="nav-link ">
									<i class="fa fa-handshake-o" aria-hidden="true"></i>
									<span class="title">All Transporters</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "clientsection" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-briefcase" aria-hidden="true"></i>
							<span class="title">Client Section</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/reviews"); ?>" class="nav-link ">
									<i class="fa fa-star" aria-hidden="true"></i>
									<span class="title">Reviews</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/youtube"); ?>" class="nav-link ">
									<i class="fa fa-youtube-play" aria-hidden="true"></i>
									<span class="title">Youtube</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/sliders"); ?>" class="nav-link ">
									<i class="fa fa-sliders" aria-hidden="true"></i>
									<span class="title">Sliders</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/offers"); ?>" class="nav-link ">
									<i class="fas fa-gift"></i>
									<span class="title">Offers</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "agents" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-user"></i>
							<span class="title">Users</span>
							<span class="arrow"></span>
						</a>
						
						<ul class="sub-menu">
							<li class="nav-item">
								<a href="<?php echo site_url("agents"); ?>" class="nav-link ">
									<i class="icon-user"></i>
									<span class="title">All Users</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo base_url("agents/teamleaders"); ?>" class="nav-link">
									<i class="fa fa-user-secret" aria-hidden="true"></i>
									<span class="title">Teams</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo site_url("agents/pending_leads"); ?>" class="nav-link ">
									<i class="fa fa-users"></i>
									<span class="title">TL's Pending Leads</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo base_url("agents/loginrequest"); ?>" class="nav-link">
									<i class="fa fa-sign-in" aria-hidden="true"></i>
									<span class="title">Login Requests</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo site_url("agents/view_assign_area"); ?>" class="nav-link ">
									<i class="fa fa-eye"></i>
									<span class="title">View Assign Area</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo site_url("agents/thought_of_day"); ?>" class="nav-link ">
									<i class="fa fa-cloud"></i>
									<span class="title">Latest Update</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "incentive" ||  $menu_name == "incentive" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-gift" aria-hidden="true"></i>
							<span class="title">Incentive</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("incentive"); ?>" class="nav-link ">
									<i class="fa fa-gift" aria-hidden="true"></i>
									<span class="title">Agents Incentive</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("incentive/agenttargets"); ?>" class="nav-link ">
									<i class="fa fa-bullseye" aria-hidden="true"></i>
									<span class="title">Targets</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item" <?php if( $menu_name == "search" ){ echo 'active'; }?>>
						<a href="<?php echo site_url("search"); ?>" class="nav-link nav-toggle">
							<i class="fa fa-search"></i>
							<span class="title">Search</span>
							<span class="arrow"></span>
						</a>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "msg_center" ||  $menu_name == "newsletters" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<span class="title">Message Center</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("msg_center"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Text Message</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("newsletters"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Emails</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/template"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Defult Email Template</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/imagetemplateList"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Image Template</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/templateList"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Text Template</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/offers"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Offers</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "accounts" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-cart-plus" aria-hidden="true"></i>
							<span class="title">Accounts Details</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-user-circle-o"></i>
									<span class="title">Accounts</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts"); ?>" class="nav-link ">
											<i class="fa fa-cart-plus" aria-hidden="true"></i>
											<span class="title">Bank/Cash Accounts</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/customeraccounts"); ?>" class="nav-link ">
											<i class="fa fa-user-circle-o" aria-hidden="true"></i>
											<span class="title">Customer Accounts</span>
										</a>
									</li>
								</ul>	
							</li>
							
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-file-alt" aria-hidden="true"></i>
									<span class="title">Receipts</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/receipts"); ?>" class="nav-link ">
											<i class="fa fa-file-alt" aria-hidden="true"></i>
											<span class="title">Bank Receipts</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/cash_receipts"); ?>" class="nav-link ">
											<i class="fa fa-inr" aria-hidden="true"></i>
											<span class="title">Cash Receipts</span>
										</a>
									</li>
								</ul>
							</li>	
							
							
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-file" aria-hidden="true"></i>
									<span class="title">Invoices</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/invoices"); ?>" class="nav-link ">
											<i class="fa fa-file" aria-hidden="true"></i>
											<span class="title">Confirm Invoices</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/pending_invoices"); ?>" class="nav-link ">
											<i class="fa fa-clock-o" aria-hidden="true"></i>
											<span class="title">Pending Invoices</span>
										</a>
									</li>
									
								</ul>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/all_online_transactions"); ?>" class="nav-link ">
									<i class="fa fa-inr" aria-hidden="true"></i>
									<span class="title">Online Transactions</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/payment_links"); ?>" class="nav-link ">
									<i class="fa fa-link" aria-hidden="true"></i>
									<span class="title">Payment Links</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/check_payment_status"); ?>" class="nav-link ">
									<i class="fa fa-search" aria-hidden="true"></i>
									<span class="title">Order Status</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "vouchers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-folder" aria-hidden="true"></i>
							<span class="title">Vouchers</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("vouchers"); ?>" class="nav-link ">
									<i class="fa fa-check"></i>
									<span class="title">Confirmed Vouchers</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("vouchers/pendingvouchers"); ?>" class="nav-link ">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span class="title">Pending Vouchers</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; 
				case ( $role == 98 ) : ?>
					<!--for manager-->
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item">
								<a href="<?php echo site_url("dashboard"); ?>" class="nav-link ">
									<i class="icon-home"></i>
									<span class="title">My Dashboard</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("dashboard/user_dashboard"); ?>" class="nav-link ">
									<i class="icon-user"></i>
									<span class="title">User Dashboard</span>
								</a>
							</li>
						</ul>
					</li>
					
					<!--all leads from india tourizm-->
					<?php if( is_leads_manager() ){ ?>
					<li class="nav-item  <?php if( $menu_name == "indiatourizm" || $menu_name == "customers" || $menu_name == "search" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-tripadvisor" aria-hidden="true"></i>
							<span class="title">India Tourizm</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("indiatourizm"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Queries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("indiatourizm/instant_call"); ?>" class="nav-link ">
									<i class="fa fa-headphones" aria-hidden="true"></i>
									<span class="title">Instant Call</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Customers</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("customers/customer_type"); ?>" class="nav-link ">
									<i class="fa fa-list-alt" aria-hidden="true"></i>
									<span class="title">Customer Type</span>
								</a>
							</li>
						</ul>
					</li><!--end leads from india tourizm-->
					<?php }else{ ?>
						<li class="nav-item  <?php if( $menu_name == "customers" || $menu_name == "search" ){ echo 'active'; }?>">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="fa fa-users" aria-hidden="true"></i>
								<span class="title">Customers</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item  ">
									<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
										<i class="fa fa-users" aria-hidden="true"></i>
										<span class="title">All Customers</span>
									</a>
								</li>

								<li class="nav-item  ">
									<a href="<?php echo site_url("customers/customer_type"); ?>" class="nav-link ">
										<i class="fa fa-list-alt" aria-hidden="true"></i>
										<span class="title">Customer Type</span>
									</a>
								</li>
							</ul>
						</li>
					<?php } ?>	
					<li class="nav-item  <?php if( $menu_name == "itineraries" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-plane" aria-hidden="true"></i>
							<span class="title">Itineraries</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries"); ?>" class="nav-link ">
									<i class="icon-layers" aria-hidden="true"></i>
									<span class="title">All Itineraries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/bookeditineraries"); ?>" class="nav-link ">
									<i class="fa fa-book" aria-hidden="true"></i>
									<span class="title">Booked Itineraries</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/closediti"); ?>" class="nav-link ">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span class="title">Closed Itineraries</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/onholditineraries"); ?>" class="nav-link ">
									<i class="fa fa-random"></i>
									<span class="title">On Hold Itineraries</span><span class="badge badge-info"><?php echo onhold_itieraries_count(); ?></span>
								</a>
							</li>
						</ul>
					</li>
					
					<?php /* <li class="nav-item  <?php if( $menu_name == "accommodation" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-building-o" aria-hidden="true"></i>
							<span class="title">Accommodation Packages</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("accommodation"); ?>" class="nav-link ">
									<i class="fa fa-building-o" aria-hidden="true"></i>
									<span class="title">All Accommodation Packages</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("accommodation/add"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Add Accommodation Package</span>
								</a>
							</li>
						</ul>
					</li> */ ?>
					
					<li class="nav-item  <?php if( $menu_name == "packages" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-cube" aria-hidden="true"></i>
							<span class="title">Packages</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("packages"); ?>" class="nav-link ">
									<i class="fa fa-cube" aria-hidden="true"></i>
									<span class="title">All Packages</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("packages/add"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Add Package</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("packages/viewCategory"); ?>" class="nav-link ">
									<i class="fa fa-cube" aria-hidden="true"></i>
									<span class="title">All Categories</span>
								</a>
							</li>
							
							
						</ul>
					</li>
					<?php if( is_gm() ){ ?>
						<li class="nav-item <?php if( $menu_name == "hotelbooking" ){ echo 'active'; }?> ">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="icon-briefcase" aria-hidden="true"></i>
								<span class="title">Hotel Booking</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
							
								<li class="nav-item  ">
									<a href="<?php echo site_url("hotelbooking"); ?>" class="nav-link ">
										<i class="icon-share-alt" aria-hidden="true"></i>
										<span class="title">All Hotel Booking</span>
									</a>
								</li>
								
								<!--li class="nav-item  ">
									<a href="<?php echo site_url("hotelbooking/pending_confirmation_request"); ?>" class="nav-link ">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
										<span class="title">Pending Request</span>
									</a>
								</li-->
								
							</ul>
						</li>
						<li class="nav-item  <?php if( $menu_name == "vehiclesbooking" ){ echo 'active'; }?> ">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="fa fa-bus" aria-hidden="true"></i>
								<span class="title">Vehicle Booking</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item  ">
									<a href="<?php echo site_url("vehiclesbooking"); ?>" class="nav-link ">
										<i class="icon-share-alt" aria-hidden="true"></i>
										<span class="title">All Cab Booking</span>
									</a>
								</li>
								<!--li class="nav-item  ">
									<a href="<?php echo site_url("vehiclesbooking/pending_confirmation_request"); ?>" class="nav-link ">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
										<span class="title">Pending Cab Request</span>
									</a>
								</li-->
								<li class="nav-item  ">
									<a href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>" class="nav-link ">
										<i class="fa fa-bus" aria-hidden="true"></i>
										<span class="title">All Volvo/Train/Flight Booking</span>
									</a>
								</li>
								<!--li class="nav-item  ">
									<a title="Pending request volvo/train/flight ticket quotations" href="<?php echo site_url("vehiclesbooking/pending_vtf_confirmation_request"); ?>" class="nav-link ">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
										<span class="title">Pending V/T/F Request</span>
									</a>
								</li-->
							</ul>
						</li>
					<?php } ?>
					
					<li class="nav-item  <?php if( $menu_name == "hotels" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-pointer"></i>
							<span class="title">Hotels</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels"); ?>" class="nav-link ">
									<i class="icon-pointer"></i>
									<span class="title">All Hotels</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/viewroomcategory"); ?>" class="nav-link ">
									<i class="icon-list"></i>
									<span class="title">View Room Category</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/viewroomrates"); ?>" class="nav-link ">
									<i class="icon-calculator"></i>
									<span class="title">View Room Rates</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/seasons"); ?>" class="nav-link ">
									<i class="fa fa-refresh" aria-hidden="true"></i>
									<span class="title">All Season</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels/mealplan"); ?>" class="nav-link ">
									<i class="fa fa-cutlery" aria-hidden="true"></i>
									<span class="title">All Meal Plan</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "vehicles" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-car" aria-hidden="true"></i>
							<span class="title">Vehicles</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehicles"); ?>" class="nav-link ">
									<i class="fa fa-car" aria-hidden="true"></i>
									<span class="title">All Vehicles</span>
								</a>
							</li>
							
							<!--li class="nav-item  ">
								<a href="<?php echo site_url("vehicles/vehicle_packages"); ?>" class="nav-link ">
									<i class="fa fa-money" aria-hidden="true"></i>
									<span class="title">Vehicles Packages</span>
								</a>
							</li-->
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("vehicles/transporters"); ?>" class="nav-link ">
									<i class="fa fa-handshake-o" aria-hidden="true"></i>
									<span class="title">All Transporters</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "clientsection" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-briefcase" aria-hidden="true"></i>
							<span class="title">Client Section</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/reviews"); ?>" class="nav-link ">
									<i class="fa fa-star" aria-hidden="true"></i>
									<span class="title">Reviews</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/youtube"); ?>" class="nav-link ">
									<i class="fa fa-youtube-play" aria-hidden="true"></i>
									<span class="title">Youtube</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/sliders"); ?>" class="nav-link ">
									<i class="fa fa-sliders" aria-hidden="true"></i>
									<span class="title">Sliders</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "incentive" ||  $menu_name == "incentive" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-gift" aria-hidden="true"></i>
							<span class="title">Incentive</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("incentive"); ?>" class="nav-link ">
									<i class="fa fa-gift" aria-hidden="true"></i>
									<span class="title">Agents Incentive</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("incentive/agenttargets"); ?>" class="nav-link ">
									<i class="fa fa-bullseye" aria-hidden="true"></i>
									<span class="title">Targets</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "agents" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Users</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item">
								<a href="<?php echo base_url("agents/loginrequest"); ?>" class="nav-link">
									<i class="fa fa-sign-in" aria-hidden="true"></i>
									<span class="title">Login Requests</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url("agents/teamleaders"); ?>" class="nav-link">
									<i class="fa fa-user-secret" aria-hidden="true"></i>
									<span class="title">Teams</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("agents/pending_leads"); ?>" class="nav-link ">
									<i class="fa fa-users"></i>
									<span class="title">Teamleaders Pending Leads</span>
								</a>
							</li>
							
							<li class="nav-item">
								<a href="<?php echo site_url("agents/thought_of_day"); ?>" class="nav-link ">
									<i class="fa fa-cloud"></i>
									<span class="title">Latest Update</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; ?>
			<?php case 97: /* Menu For sales team */ ?>
				<li class="nav-item start">
					<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
						<i class="icon-home"></i>
						<span class="title">Dashboard</span>
						<span class="selected"></span>
						<span class="arrow open"></span>
					</a>
				</li>
				<li class="nav-item  <?php if( $menu_name == "itineraries" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-plane" aria-hidden="true"></i>
						<span class="title">Itineraries</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("itineraries"); ?>" class="nav-link ">
								<i class="icon-layers" aria-hidden="true"></i>
								<span class="title">Booked Itineraries</span>
							</a>
						</li>
					</ul>
				</li>
				<?php /*
				<li class="nav-item  <?php if( $menu_name == "payments" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-inr" aria-hidden="true"></i>
						<span class="title">Payment Details</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("payments"); ?>" class="nav-link ">
								<i class="fa fa-inr" aria-hidden="true"></i>
								<span class="title">Itineraries Payments</span>
							</a>
						</li>
					</ul>
				</li> */ ?>
				<li class="nav-item <?php if( $menu_name == "hotelbooking" ){ echo 'active'; }?> ">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-briefcase" aria-hidden="true"></i>
						<span class="title">Hotel Booking</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotelbooking"); ?>" class="nav-link ">
								<i class="icon-share-alt" aria-hidden="true"></i>
								<span class="title">All Hotel Booking</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item  <?php if( $menu_name == "vehiclesbooking" ){ echo 'active'; }?> ">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-bus" aria-hidden="true"></i>
						<span class="title">Vehicle Booking</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking"); ?>" class="nav-link ">
								<i class="icon-share-alt" aria-hidden="true"></i>
								<span class="title">All Cab Booking</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>" class="nav-link ">
								<i class="fa fa-bus" aria-hidden="true"></i>
								<span class="title">All Volvo/Train/Flight Booking</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item  <?php if( $menu_name == "hotels" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-pointer"></i>
						<span class="title">Hotels</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotels"); ?>" class="nav-link ">
								<i class="icon-pointer"></i>
								<span class="title">All Hotels</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotels/viewroomcategory"); ?>" class="nav-link ">
								<i class="icon-list"></i>
								<span class="title">View Room Category</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotels/viewroomrates"); ?>" class="nav-link ">
								<i class="icon-calculator"></i>
								<span class="title">View Room Rates</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotels/seasons"); ?>" class="nav-link ">
								<i class="fa fa-refresh" aria-hidden="true"></i>
								<span class="title">All Season</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotels/mealplan"); ?>" class="nav-link ">
								<i class="fa fa-cutlery" aria-hidden="true"></i>
								<span class="title">All Meal Plan</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item  <?php if( $menu_name == "vehicles" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-car" aria-hidden="true"></i>
						<span class="title">Vehicles</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehicles"); ?>" class="nav-link ">
								<i class="fa fa-car" aria-hidden="true"></i>
								<span class="title">All Vehicles</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehicles/transporters"); ?>" class="nav-link ">
								<i class="fa fa-handshake-o" aria-hidden="true"></i>
								<span class="title">All Transporters</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item  <?php if( $menu_name == "vouchers" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-folder" aria-hidden="true"></i>
						<span class="title">Vouchers</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("vouchers"); ?>" class="nav-link ">
								<i class="fa fa-check"></i>
								<span class="title">Confirmed Vouchers</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("vouchers/pendingvouchers"); ?>" class="nav-link ">
								<i class="fa fa-clock-o" aria-hidden="true"></i>
								<span class="title">Pending Vouchers</span>
							</a>
						</li>
					</ul>
				</li>
				
				<li class="nav-item  <?php if( $menu_name == "marketing" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="fa fa-bar-chart" aria-hidden="true"></i>
						<span class="title">Marketing</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("marketing"); ?>" class="nav-link ">
								<i class="fa fa-bar-chart" aria-hidden="true"></i>
								<span class="title">All User List</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("marketing/state_codes"); ?>" class="nav-link ">
								<i class="fa fa-building" aria-hidden="true"></i>
								<span class="title">State Codes</span>
							</a>
						</li>
					</ul>
				</li>
				
				<?php /*
				<li class="nav-item <?php if( $menu_name == "hotelbooking" ){ echo 'active'; }?> ">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-briefcase" aria-hidden="true"></i>
						<span class="title">Hotel Booking</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("hotelbooking"); ?>" class="nav-link ">
								<i class="icon-share-alt" aria-hidden="true"></i>
								<span class="title">All Hotel Booking</span>
							</a>
						</li>	

						<li class="nav-item  ">
							<a href="<?php echo site_url("hotelbooking/add"); ?>" class="nav-link ">
								<i class="icon-note"></i>
								<span class="title">Book Hotel</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item  <?php if( $menu_name == "vehiclesbooking" ){ echo 'active'; }?> ">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-briefcase" aria-hidden="true"></i>
						<span class="title">Vehicle Booking</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking"); ?>" class="nav-link ">
								<i class="icon-share-alt" aria-hidden="true"></i>
								<span class="title">All Cab Booking</span>
							</a>
						</li>	

						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking/bookcab"); ?>" class="nav-link ">
								<i class="fa fa-car" aria-hidden="true"></i>
								<span class="title">Book Cab</span>
							</a>
						</li>
						
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking/allvehiclesbookings"); ?>" class="nav-link ">
								<i class="fa fa-bus" aria-hidden="true"></i>
								<span class="title">All Volvo/Train/Flight Booking</span>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo site_url("vehiclesbooking/addbookingdetails?type=volvo"); ?>" class="nav-link ">
								<i class="fa fa-bus" aria-hidden="true"></i>
								<span class="title">Book Volvo Ticket</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking/addbookingdetails?type=train"); ?>" class="nav-link ">
								<i class="fa fa-train" aria-hidden="true"></i>
								<span class="title">Book Train Ticket</span>
							</a>
						</li>
						<li class="nav-item  ">
							<a href="<?php echo site_url("vehiclesbooking/addbookingdetails?type=flight"); ?>" class="nav-link ">
								<i class="fa fa-plane" aria-hidden="true"></i>
								<span class="title">Book Flight Ticket</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item  <?php if( $menu_name == "vouchers" ){ echo 'active'; }?>">
					<a href="javascript:;" class="nav-link nav-toggle">
						<i class="icon-book-open" aria-hidden="true"></i>
						<span class="title">Vouchers</span>
						<span class="arrow"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item  ">
							<a href="<?php echo site_url("vouchers"); ?>" class="nav-link ">
								<i class="icon-folder" aria-hidden="true"></i>
								<span class="title">All Vouchers</span>
							</a>
						</li>	

						<li class="nav-item  ">
							<a href="<?php echo site_url("vouchers/add"); ?>" class="nav-link ">
								<i class="icon-docs"></i>
								<span class="title">Create Voucher</span>
							</a>
						</li>
					</ul>
				</li> */ ?>
				<li class="nav-item">
					<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
						<i class="fa fa-power-off" aria-hidden="true"></i>
						<span class="title">Logout</span>
					</a>
				</li>	
				<?php break; ?>
				<?php case 96:  /* Menu For Service team */?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
							<span class="arrow open"></span>
						</a>
					</li>
					<li class="nav-item  <?php if( $menu_name == "customers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Customers</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Customers</span>
								</a>
							</li>
						</ul>
					</li> 
					<li class="nav-item  <?php if( $menu_name == "itineraries/bookeditineraries" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-plane" aria-hidden="true"></i>
							<span class="title">Itineraries</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/bookeditineraries"); ?>" class="nav-link ">
									<i class="icon-layers" aria-hidden="true"></i>
									<span class="title">Booked Itineraries</span>
								</a>
							</li>
						</ul>
					</li>
					<?php /*
					<li class="nav-item  <?php if( $menu_name == "accommodation" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-building-o" aria-hidden="true"></i>
							<span class="title">Accommodation Packages</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("accommodation"); ?>" class="nav-link ">
									<i class="fa fa-building-o" aria-hidden="true"></i>
									<span class="title">All Accommodation Packages</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("accommodation/add"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Add Accommodation Package</span>
								</a>
							</li>
						</ul>
					</li> */ ?>
					<li class="nav-item  <?php if( $menu_name == "packages" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-cube" aria-hidden="true"></i>
							<span class="title">Packages</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("packages"); ?>" class="nav-link ">
									<i class="fa fa-cube" aria-hidden="true"></i>
									<span class="title">All Packages</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("packages/add"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Add Package</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "clientsection" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-briefcase" aria-hidden="true"></i>
							<span class="title">Client Section</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/reviews"); ?>" class="nav-link ">
									<i class="fa fa-star" aria-hidden="true"></i>
									<span class="title">Reviews</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/youtube"); ?>" class="nav-link ">
									<i class="fa fa-youtube-play" aria-hidden="true"></i>
									<span class="title">Youtube</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("clientsection/sliders"); ?>" class="nav-link ">
									<i class="fa fa-sliders" aria-hidden="true"></i>
									<span class="title">Sliders</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "marketing" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-bar-chart" aria-hidden="true"></i>
							<span class="title">Marketing</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing"); ?>" class="nav-link ">
									<i class="fa fa-bar-chart" aria-hidden="true"></i>
									<span class="title">All User List</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing/state_codes"); ?>" class="nav-link ">
									<i class="fa fa-building" aria-hidden="true"></i>
									<span class="title">State Codes</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "hotels" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-pointer"></i>
							<span class="title">Hotels</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("hotels"); ?>" class="nav-link ">
									<i class="icon-pointer"></i>
									<span class="title">All Hotels</span>
								</a>
							</li>
						</ul>
					</li>		
					<li class="nav-item" <?php if( $menu_name == "search" ){ echo 'active'; }?>>
						<a href="<?php echo base_url("search"); ?>" class="nav-link">
							<i class="fa fa-search" aria-hidden="true"></i>
							<span class="title">Search</span>
						</a>
					</li>
					<li class="nav-item  <?php if( $menu_name == "msg_center" ||  $menu_name == "newsletters" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<span class="title">Message Center</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("msg_center"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Text Message</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("newsletters"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Emails</span>
								</a>
							</li>
						</ul>
					</li>	
					<!--check if teamleader show teammebers link-->  
					<?php if( is_teamleader() ){ ?>
						<li class="nav-item  <?php if( $menu_name == "agents" ){ echo 'active'; }?>">
							<a href="javascript:;" class="nav-link nav-toggle">
								<i class="icon-users"></i>
								<span class="title">Teammembers</span>
								<span class="arrow"></span>
							</a>
							<ul class="sub-menu">
								<li class="nav-item">
									<a href="<?php echo site_url("agents/myteammembers"); ?>" class="nav-link ">
										<i class="icon-users"></i>
										<span class="title">Team Members</span>
									</a>
								</li>
								<li class="nav-item">
									<a href="<?php echo site_url("agents/pending_leads"); ?>" class="nav-link ">
										<i class="fa fa-users"></i>
										<span class="title">Pending Leads</span>
									</a>
								</li>
							</ul>
						</li>	
					<?php } ?>
					
					<li class="nav-item  <?php if( $menu_name == "incentive" ||  $menu_name == "incentive" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-gift" aria-hidden="true"></i>
							<span class="title">Incentive</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("incentive"); ?>" class="nav-link ">
									<i class="fa fa-gift" aria-hidden="true"></i>
									<span class="title">Incentive</span>
								</a>
							</li>
						</ul>
					</li>
					
					
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; ?>
				
				<?php case 95:  /* Menu For Leads team */ ?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
							<span class="arrow open"></span>
						</a>
					</li>
					<li class="nav-item  <?php if( $menu_name == "customers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Leads</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Leads</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers/workingleads"); ?>" class="nav-link ">
									<i class="fa fa-briefcase" aria-hidden="true"></i>
									<span class="title">Working Leads</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers/bookedleads"); ?>" class="nav-link ">
									<i class="fa fa-briefcase" aria-hidden="true"></i>
									<span class="title">Booked Leads</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers/declinedleads"); ?>" class="nav-link ">
									<i class="fa fa-ban" aria-hidden="true"></i>
									<span class="title">Declined Leads</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("customers/closeleads"); ?>" class="nav-link ">
									<i class="fa fa-cc-diners-club" aria-hidden="true"></i>
									<span class="title">Close Leads</span>
								</a>
							</li>
						</ul>
					</li> 
					<li class="nav-item  <?php if( $menu_name == "purchaseleads" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Purchase Leads</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("purchaseleads"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">Purchase All  Leads</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "itineraries" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-plane" aria-hidden="true"></i>
							<span class="title">Itineraries</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries"); ?>" class="nav-link ">
									<i class="icon-layers" aria-hidden="true"></i>
									<span class="title">Declined Itineraries</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "marketing" || $menu_name_sub == "assign_area" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-bar-chart" aria-hidden="true"></i>
							<span class="title">Marketing</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing"); ?>" class="nav-link ">
									<i class="fa fa-bar-chart" aria-hidden="true"></i>
									<span class="title">All User List</span>
								</a>
							</li>

							<li class="nav-item  ">
								<a href="<?php echo site_url("marketing/viewcat"); ?>" class="nav-link ">
									<i class="icon-plus"></i>
									<span class="title">Marketing Categories</span>
								</a>
							</li>
							<?php /* <li class="nav-item  ">
								<a href="<?php echo site_url("agents/assign_area"); ?>" class="nav-link ">
									<i class="fa fa-eye"></i>
									<span class="title">Assign User Area</span>
								</a>
							</li> */ ?>
							<li class="nav-item">
								<a href="<?php echo site_url("agents/view_assign_area"); ?>" class="nav-link ">
									<i class="fa fa-eye"></i>
									<span class="title">View Assign Area</span>
								</a>
							</li>
						</ul>
					</li>
					<li class="nav-item  <?php if( $menu_name == "reference_customers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-users" aria-hidden="true"></i>
							<span class="title">Ref Customers</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("reference_customers"); ?>" class="nav-link ">
									<i class="fa fa-users" aria-hidden="true"></i>
									<span class="title">All Ref Customers</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "msg_center" ||  $menu_name == "newsletters" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<span class="title">Message Center</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("msg_center"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Text Message</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("newsletters"); ?>" class="nav-link ">
									<i class="fa fa-envelope" aria-hidden="true"></i>
									<span class="title">Send Emails</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/template"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Defult Email Template</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/imagetemplateList"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Image Template</span>
								</a>
							</li>
							<li class="nav-item">
								<a href="<?php echo site_url("newsletters/templateList"); ?>" class="nav-link ">
									<i class="fa fa-columns" aria-hidden="true"></i>
									<span class="title">Text Template</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "agents" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-user" aria-hidden="true"></i>
							<span class="title">All Agents</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("agents"); ?>" class="nav-link ">
									<i class="icon-user" aria-hidden="true"></i>
									<span class="title">All Agents</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; ?>	
				<?php case 94:  /* Menu For Leads team */ ?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
							<span class="arrow open"></span>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; ?>
				
				<?php case 93:  /* Menu For Accounts team */ ?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
							<span class="arrow open"></span>
						</a>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "itineraries" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-plane" aria-hidden="true"></i>
							<span class="title">Itineraries</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries"); ?>" class="nav-link ">
									<i class="icon-layers" aria-hidden="true"></i>
									<span class="title">Booked Itineraries</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("itineraries/closediti"); ?>" class="nav-link ">
									<i class="fa fa-check-circle" aria-hidden="true"></i>
									<span class="title">Closed Itineraries</span>
								</a>
							</li>
						</ul>
					</li>
					<?php $pending_payment_count = pending_payment_count(); ?>
					<li class="nav-item  <?php if( $menu_name == "payments" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-inr" aria-hidden="true"></i>
							<span class="title">Payment Details</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("payments"); ?>" class="nav-link ">
									<i class="fa fa-inr" aria-hidden="true"></i>
									<span class="title">Itineraries Payments</span><span class="badge badge-info"><?php echo $pending_payment_count; ?></span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "accounts" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="fa fa-cart-plus" aria-hidden="true"></i>
							<span class="title">Accounts Details</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-user-circle-o"></i>
									<span class="title">Accounts</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts"); ?>" class="nav-link ">
											<i class="fa fa-cart-plus" aria-hidden="true"></i>
											<span class="title">Bank/Cash Accounts</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/customeraccounts"); ?>" class="nav-link ">
											<i class="fa fa-user-circle-o" aria-hidden="true"></i>
											<span class="title">Customer Accounts</span>
										</a>
									</li>
								</ul>	
							</li>
							
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-file-alt" aria-hidden="true"></i>
									<span class="title">Receipts</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/receipts"); ?>" class="nav-link ">
											<i class="fa fa-file-alt" aria-hidden="true"></i>
											<span class="title">Bank Receipts</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/cash_receipts"); ?>" class="nav-link ">
											<i class="fa fa-inr" aria-hidden="true"></i>
											<span class="title">Cash Receipts</span>
										</a>
									</li>
								</ul>
							</li>	
							
							
							<li class="nav-item  ">
								<a href="javascript:;" class="nav-link nav-toggle">
									<i class="fa fa-file" aria-hidden="true"></i>
									<span class="title">Invoices</span>
									<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/invoices"); ?>" class="nav-link ">
											<i class="fa fa-file" aria-hidden="true"></i>
											<span class="title">Confirm Invoices</span>
										</a>
									</li>
									
									<li class="nav-item  ">
										<a href="<?php echo site_url("accounts/pending_invoices"); ?>" class="nav-link ">
											<i class="fa fa-clock-o" aria-hidden="true"></i>
											<span class="title">Pending Invoices</span>
										</a>
									</li>
									
								</ul>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/all_online_transactions"); ?>" class="nav-link ">
									<i class="fa fa-inr" aria-hidden="true"></i>
									<span class="title">Online Transactions</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/payment_links"); ?>" class="nav-link ">
									<i class="fa fa-link" aria-hidden="true"></i>
									<span class="title">Payment Links</span>
								</a>
							</li>
							
							<li class="nav-item  ">
								<a href="<?php echo site_url("accounts/check_payment_status"); ?>" class="nav-link ">
									<i class="fa fa-search" aria-hidden="true"></i>
									<span class="title">Order Status</span>
								</a>
							</li>
							
						</ul>
					</li>
					
					<li class="nav-item  <?php if( $menu_name == "vouchers" ){ echo 'active'; }?>">
						<a href="javascript:;" class="nav-link nav-toggle">
							<i class="icon-folder" aria-hidden="true"></i>
							<span class="title">Vouchers</span>
							<span class="arrow"></span>
						</a>
						<ul class="sub-menu">
							<li class="nav-item  ">
								<a href="<?php echo site_url("vouchers"); ?>" class="nav-link ">
									<i class="fa fa-check"></i>
									<span class="title">Confirmed Vouchers</span>
								</a>
							</li>
							<li class="nav-item  ">
								<a href="<?php echo site_url("vouchers/pendingvouchers"); ?>" class="nav-link ">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<span class="title">Pending Vouchers</span>
								</a>
							</li>
						</ul>
					</li>
					
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>	
				<?php break; ?>
				
				<?php default: ?>
					<li class="nav-item start">
						<a href="<?php echo site_url("dashboard"); ?>" class="nav-link nav-toggle">
							<i class="icon-home"></i>
							<span class="title">Dashboard</span>
							<span class="selected"></span>
							<span class="arrow open"></span>
						</a>
					</li>
					<li class="nav-item">
						<a href="<?php echo base_url("dashboard/logout"); ?>" class="nav-link">
							<i class="fa fa-power-off" aria-hidden="true"></i>
							<span class="title">Logout</span>
						</a>
					</li>
					<?php break; ?>
				<?php } ?>	
			
			<!--li class="nav-item  ">
				<a href="<?php //echo site_url("databasebackup"); ?>" class="nav-link nav-toggle">
					<i class="icon-cloud-upload" aria-hidden="true"></i>
					<span class="title">Backup</span>
					<span class="arrow"></span>
				</a>
			</li-->
		</ul>
			
		<!-- END SIDEBAR MENU -->
		<!-- END SIDEBAR MENU -->
	</div>
	<!-- END SIDEBAR -->
</div>
