//PRINT ITINERARY
function Print_iti() { 
	var _print_stylesheet_link1 = BASE_URL + "site/assets/css/custom_print.css";
	var _print_stylesheet_link2 = BASE_URL + "site/assets/css/components.min.css";
	var _print_stylesheet_link3 = BASE_URL + "site/assets/css/custom.css";
	var _print_stylesheet_link4 = BASE_URL + "site/assets/css/bootstrap.min.css";
	
	var style_print = '<link href="' + _print_stylesheet_link4 +'" rel="stylesheet" type="text/css"  /> ' +
	' <link href="' + _print_stylesheet_link2 +'" rel="stylesheet" type="text/css"  />' +
	' <link href="' + _print_stylesheet_link2 +'" rel="stylesheet" type="text/css"  />' +
	' <link href="' + _print_stylesheet_link1 +'" rel="stylesheet" type="text/css"  />';
	//console.log( style_print );
	var divToPrint = document.getElementById('printable');
	var popupWin = window.open('', '_blank', 'width=800,height=400');
	popupWin.document.open();
	popupWin.document.write('<html><head>'+style_print+'</head><body onload="window.print()">' + printable.innerHTML + '</html>');
	popupWin.document.close();
}
$('.timepicker').timepicker({
	minuteStep: 5,
	showInputs: false,
	disableFocus: true
});

// add active class
$(document).on("click", "ul.page-sidebar-menu >li", function(){
	$(this).addClass('active').siblings().removeClass('active');
});

$(document).ready(function($){
	var url = window.location.href;
	$('.sub-menu li a[href="'+url+'"]').parent().addClass('active');
    $('.sub-menu li a[href="'+url+'"]').parent().parent().parent().removeClass('active');
    $('.sub-menu li a[href="'+url+'"]').parent().parent().parent().addClass('active');
    $('ul.page-sidebar-menu li a[href="'+url+'"]').parent().addClass('active');
	
	$("ul.page-sidebar-menu li").each(function(){
		if( !$("ul.page-sidebar-menu li").hasClass("active") ){
			$("ul.page-sidebar-menu li:nth-child(2)").addClass("active");
		}
	});
});


/***************THEME COLOR CHANGE FUNCTION ****************************/
jQuery( document ).ready(function(){
	var panel = $('.theme-panel');
	var base_url = $("#base_url").val();
	//for live
	//var base_url = window.location.origin + '/';
	//console.log( "Base: " + base_url );
	
	//Add current class
	var currentTheme = $('#style_color').attr("data-style_colour");
	$('ul > li', panel).removeClass("current");
	$('ul#theme_color_listing > li[data-style = '+ currentTheme +']').addClass("current");
	//console.log( currentTheme );
	
	$('.theme-colors > ul > li', panel).click(function() {
		var color = $(this).attr("data-style");
		$('ul > li', panel).removeClass("current");
		$(this).addClass("current");
		var response = $(".th_response");
		
		$.ajax({
			type: "POST",
			url: base_url + 'AjaxRequest/update_user_theme_style',
			dataType: 'json',
			data: {theme_color: color},
			beforeSend: function(){
				response.fadeIn().html('<p class="alert alert-success"><i class="fa fa-spinner fa-spin"></i> Please wait...</p>');
			},
			success: function(res) {
				if (res.status == true){
					setColor(color);
					response.html('<div class="alert alert-success"><strong>Success! </strong>'+res.msg+'</div>');
					setTimeout(function() { response.fadeOut('fast'); }, 2000); // <-- time in milliseconds
					console.log("done");
				}else{
					response.fadeIn().html('<div class="alert alert-danger"><strong>Error! </strong>'+res.msg+'</div>');
					console.log("error");
				}
			},
			error: function(e){
				console.log(e);
			}
		});
	});
	
	var setColor = function(color) {
		var color_ = (App.isRTL() ? color + '-rtl' : color);
		$('#style_color').attr("href", base_url + 'site/assets/css/' + color_ + ".css");
		$('#style_color').attr("data-style_colour", color);
		$("body").removeClass("default theme_dark theme_light");
		$("body").addClass(color);
	};

	/***************THEME CHANGE FUNCTION **************/
	/***********Dashboard panel toggle**********/
	$(".view_table_data").each(function(){
		var rowCount = $(this).parent().find('table >tbody >tr').length;
		
		//show view all button if row > 2
		if( rowCount > 2 )
			$(this).show();
		else
			$(this).hide();
		
		$(this).click(function(e){
			e.preventDefault();
			$(this).parent().toggleClass("full-height");
			//Add show less class
			$(this).toggleClass("showLess");
			
			if ($(this).hasClass("showLess") ) { 
				$(this).html("<i class='fa fa-angle-up'></i> Show Less"); 
			} else { 
				$(this).html("<i class='fa fa-angle-down'></i> View All"); 
			}; 
		});
	});
	
	/***************Slide stats on dashboard********/
	$(".view_all_stat_btn").click(function(e){
		e.preventDefault();
		var target_id = $(this).attr("data-target_id");
		//console.log("clicked" + target_id);
		$("#" + target_id).slideToggle();
		
		$(this).toggleClass("showLess");
		if ($(this).hasClass("showLess") ) { 
			$(this).html("<i class='fa fa-angle-up'></i> Show Less"); 
		} else { 
			$(this).html("<i class='fa fa-angle-down'></i> View All Stats"); 
		};
	});
	
	/* Render calander on sidebar-button click */
	$(document).on("click",".cal_toggle_btn", function(e){
		e.preventDefault();
		
		var _this_modal_id = $(this).attr("data-target");
		$(".modal").modal("hide");
		console.log( _this_modal_id );
		$( "#" + _this_modal_id ).modal("show");
		
		//console.log("clicked");
		setTimeout(function () {
			$(".calender_dashboard").fullCalendar("render");
		}, 300); // Set enough time to wait until animation finishes;
	});
	
	
	/*show/hide sidebar menu*/
	$(".quick-nav").click(function(){
		$(".quick-nav").toggleClass("nav-is-visible");
	});
	
});