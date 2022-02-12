       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" type="text/javascript"></script>
		        <script src="<?php echo base_url();?>site/turn.js" type="text/javascript"></script>
		        <script src="https://cdnjs.cloudflare.com/ajax/libs/simple-slider/1.0.0/simpleslider.js" type="text/javascript"></script>
		       
<style>
 body{overflow-x:hidden;}
.evenp{
	padding: 0;
	background: white !important;
	border-top: 1px solid #afafaf !important;
	box-shadow: inset -28px 0px 20px 0px #00000014;
	border-left: 1px solid #afafaf !important;
	border-bottom: 1px solid #afafaf !important;
	text-align: justify;
}
.oddp {
  height:100%;
  background: #fff;
  border: 1px solid #afafaf !important;
  box-shadow: inset 28px 1px 20px 0px #00000014;
  border-left: none !important;
      z-index: 99;
 
  }
	border:10px solid orange !important;}
.pg2{
	padding:20px;
	background-color: #FF0;
}
img{
	margin: 0 auto;
	max-width: 100%;
	 
}

.book {
    margin: 0 auto;
    width: 90%;
    height: 90%;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.hard.turn-page.p1 {
    background-image:  url(https://www.trackitinerary.com/uploadsimage/pack/logo-42.png);
    background-size: 70%;
    background-repeat: no-repeat;
    background-position: center center;
    background-color: #440951;
}
 #flipbook.shadow{
  -webkit-box-shadow: 0 4px 10px #666;
  -moz-box-shadow: 0 4px 10px #666;
  -ms-box-shadow: 0 4px 10px #666;
  -o-box-shadow: 0 4px 10px #666;
  box-shadow: 0 4px 10px #666;
}
div#flipbook {
    line-height: 150%; overflow:hidden;
}

.evenp .div_txt {
    padding: 15px 45px 15px 15px;
}

.oddp .div_txt {
    padding: 15px 15px 15px 45px;
}

.div_img img{width:100%;}
.cn{margin: 0 auto;}

div.flip-control {
	  padding-top: 25px ;
		margin:0 auto;
    width: 400px;
    text-align: center;
	
}

div.flip-control a {
	
      background-color: red;
    color: white;
    padding: 10px;
    text-decoration: none;
    text-transform: uppercase;
    text-orientation: mixed;
    margin-left: 10px;
    font-size: 14px;
    border-radius: 17px;
	  box-shadow: 0 5px 0 darkred;

}
.b{
	width:89.61px;
}
a:hover {
  background-color: #555;
}

a:active {
  background-color: black;
}

a:visited {
  background-color: #ccc;
}
</style>
<div >
		<div   id="flipbook" style="margin:0 auto;" >
		<div class="hard"> </div>
					<?php 
				if(isset($images)  && !empty($images)){
				$i=1;
				foreach($images as $data){
				//dump();die;
				$title =$data->page_title;
				$type =$data->page_type;
				$content =$data->content;
				$pid =get_promo_name($data->promotion_id);
				$o = $data->p_order;
				$class = $o%2==0? "evenp" : 'oddp' ;
				if($type ==1){
					echo "<div class='$class'><div  class='div_txt' ><h2>$title</h2><p>$content</p></div></div>";
				}
				else{
				echo "<div class='$class'><div class='div_img' ><img  src=".base_url('site/images/promotions/').$content. "></div></div>";
		
				}
					$i++;  
				} 
				}?>
<div class="hard cn" style="background-color:black;"></div>
				
	
	
</div>
<div id="slider-bar" class="turnjs-slider">
		<div id="slider"></div>
	</div>
	
</div>
<div class="flip-control">
    <a href="#"  class="btn " id="prevBtn"> Previous </a>
    <a href="#" class="btn b" id="nextBtn"> Next </a>
</div>


<script>
 var allpages = $("#flipbook").children().length;
$("#flipbook").turn({
		width:1100,
		height:700,
		pages:allpages,
		autoCenter: true,
		display: 'double',
		elevation:50,
		  when: {
                    turning: function(e, page, view) {
                        //do some animations
                        var w = $(this).width();
                        if(page==1){
                            $(this).animate({"left":"-"+w/4+"px"}, 650);
                        }
                          else if(page == allpages ){
                            $(this).animate({"left": w/4+"px" }, 650);
                        }  
                        else{
                            $(this).animate({"left": 0}, 650);

                        }
                        console.debug('bb');
                        // Gets the range of pages that the book needs right now
                          
                    }
                    
                }

});




$("#flipbook").bind("turned", function(event, page, view) {
		$("#pageFld").val(page);
	//$("#flipbook").turn('display','double');
		if(page ==1  && $(this).data('done') ){
			$("#flipbook").removeClass('book');
		}
		else{	
		$("#flipbook").addClass('book');
		}  

});

$("#pageFld").change(function() {
		$("#flipbook").turn("page", $(this).val());
});

$("#prevBtn").click(function() {
		$("#flipbook").turn("previous");
});

$("#nextBtn").click(function() {
		$("#flipbook").turn("next");
});
</script>

<script>
/*
 * Turn.js responsive book
 */

/*globals window, document, $*/
 /*


 (function () {
    'use strict';

    var module = {
        ratio: 1.38,
        init: function (id) {
            var me = this;

            // if older browser then don't run javascript
            if (document.addEventListener) {
                this.el = document.getElementById(id);
                this.resize();
                this.plugins();

                // on window resize, update the plugin size
                window.addEventListener('resize', function (e) {
                    var size = me.resize();
                    $(me.el).turn('size', size.width, size.height);
                });
            }
        },
        resize: function () {
            // reset the width and height to the css defaults
            this.el.style.width = '';
            this.el.style.height = '';

            var width = this.el.clientWidth,
                height = Math.round(width / this.ratio),
                padded = Math.round(document.body.clientHeight * 0.9);

            // if the height is too big for the window, constrain it
            if (height > padded) {
                height = padded;
                width = Math.round(height * this.ratio);
            }

            // set the width and height matching the aspect ratio
            this.el.style.width = width + 'px';
            this.el.style.height = height + 'px';

            return {
                width: width,
                height: height
            };
        },
        plugins: function () {
            // run the plugin
            $(this.el).turn({
                gradients: true,
                acceleration: false
            });
            // hide the body overflow
            document.body.className = 'hide-overflow';
        }
    };

    module.init('#flipbbok');
}());  */
</script>