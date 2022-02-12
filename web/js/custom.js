 // Sets interval...what is transition slide speed?
    $('#carousel-images').carousel({
    interval: 3000
	});
	
	$('#carousel-testimonials').carousel({
    interval: 5000
	});
	
	
	
	
	/*
	
	$('#carousel-images').carousel({
    interval: 4000
});
/*
// handles the carousel thumbnails
$('[id^=carousel-selector-]').click( function(){
  var id_selector = $(this).attr("id");
  var id = id_selector.substr(id_selector.length -1);
  id = parseInt(id);
  $('#carousel-images').carousel(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $(this).addClass('selected');
});

// when the carousel slides, auto update
$('#carousel-images').on('slid', function (e) {
  var id = $('.item.active').data('slide-number');
  id = parseInt(id);
  $('[id^=carousel-selector-]').removeClass('selected');
  $('[id=carousel-selector-'+id+']').addClass('selected');
});
*/
$('#myCarousel').carousel({
  interval: 40000
});
$('.videoCarousel .carousel .item').each(function(){
  var next = $(this).next();
  if (!next.length) {
    next = $(this).siblings(':first');
}
next.children(':first-child').clone().appendTo($(this));
  if (next.next().length>0) {
    next.next().children(':first-child').clone().appendTo($(this)).addClass('rightest');
  }
  else {
      $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
     
  }
});

