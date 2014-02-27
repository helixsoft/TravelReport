/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007, 2013 Brian Cherne
 */
 
/* hoverIntent is similar to jQuery's built-in "hover" method except that
 * instead of firing the handlerIn function immediately, hoverIntent checks
 * to see if the user's mouse has slowed down (beneath the sensitivity
 * threshold) before firing the event. The handlerOut function is only
 * called after a matching handlerIn.
 *
 * // basic usage ... just like .hover()
 * .hoverIntent( handlerIn, handlerOut )
 * .hoverIntent( handlerInOut )
 *
 * // basic usage ... with event delegation!
 * .hoverIntent( handlerIn, handlerOut, selector )
 * .hoverIntent( handlerInOut, selector )
 *
 * // using a basic configuration object
 * .hoverIntent( config )
 *
 * @param  handlerIn   function OR configuration object
 * @param  handlerOut  function OR selector for delegation OR undefined
 * @param  selector    selector OR undefined
 * @author Brian Cherne <brian(at)cherne(dot)net>
 */
(function($) {
    $.fn.hoverIntent = function(handlerIn,handlerOut,selector) {

        // default configuration values
        var cfg = {
            interval: 100,
            sensitivity: 7,
            timeout: 0
        };

        if ( typeof handlerIn === "object" ) {
            cfg = $.extend(cfg, handlerIn );
        } else if ($.isFunction(handlerOut)) {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerOut, selector: selector } );
        } else {
            cfg = $.extend(cfg, { over: handlerIn, out: handlerIn, selector: handlerOut } );
        }

        // instantiate variables
        // cX, cY = current X and Y position of mouse, updated by mousemove event
        // pX, pY = previous X and Y position of mouse, set by mouseover and polling interval
        var cX, cY, pX, pY;

        // A private function for getting mouse position
        var track = function(ev) {
            cX = ev.pageX;
            cY = ev.pageY;
        };

        // A private function for comparing current and previous mouse position
        var compare = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            // compare mouse positions to see if they've crossed the threshold
            if ( ( Math.abs(pX-cX) + Math.abs(pY-cY) ) < cfg.sensitivity ) {
                $(ob).off("mousemove.hoverIntent",track);
                // set hoverIntent state to true (so mouseOut can be called)
                ob.hoverIntent_s = 1;
                return cfg.over.apply(ob,[ev]);
            } else {
                // set previous coordinates for next time
                pX = cX; pY = cY;
                // use self-calling timeout, guarantees intervals are spaced out properly (avoids JavaScript timer bugs)
                ob.hoverIntent_t = setTimeout( function(){compare(ev, ob);} , cfg.interval );
            }
        };

        // A private function for delaying the mouseOut function
        var delay = function(ev,ob) {
            ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
            ob.hoverIntent_s = 0;
            return cfg.out.apply(ob,[ev]);
        };

        // A private function for handling mouse 'hovering'
        var handleHover = function(e) {
            // copy objects to be passed into t (required for event object to be passed in IE)
            var ev = jQuery.extend({},e);
            var ob = this;

            // cancel hoverIntent timer if it exists
            if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); }

            // if e.type == "mouseenter"
            if (e.type == "mouseenter") {
                // set "previous" X and Y position based on initial entry point
                pX = ev.pageX; pY = ev.pageY;
                // update "current" X and Y position based on mousemove
                $(ob).on("mousemove.hoverIntent",track);
                // start polling interval (self-calling timeout) to compare mouse coordinates over time
                if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout( function(){compare(ev,ob);} , cfg.interval );}

                // else e.type == "mouseleave"
            } else {
                // unbind expensive mousemove event
                $(ob).off("mousemove.hoverIntent",track);
                // if hoverIntent state is true, then call the mouseOut function after the specified delay
                if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout( function(){delay(ev,ob);} , cfg.timeout );}
            }
        };

        // listen for mouseenter and mouseleave
        return this.on({'mouseenter.hoverIntent':handleHover,'mouseleave.hoverIntent':handleHover}, cfg.selector);
    };
})(jQuery);

/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */

( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

window.classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

})( window );

jQuery(document).ready(function($) {

  var postType = fangohr_dynload.postType;
  var pageNum = parseInt(fangohr_dynload.startPage) + 1;
  var postPageNum = parseInt(fangohr_dynload.startPostPage) + 1;
  var max = parseInt(fangohr_dynload.maxPages);
  var nextLink = fangohr_dynload.nextLink;
  var nextPostPageLink = fangohr_dynload.nextPostPageLink
  var maxPostPage = $('#continue_post').addClass('continue_post_' + postPageNum ).attr('data-maxPages') ;
  if (!nextLink) {
    $('#view_more_posts').addClass('hidden');
  }
  $('#view_more_posts').click(function() {
    $('.sticky_ad').show();

    // Are there more posts to load?
    if(pageNum <= max) {
    
      // Show that we're working.
      $(this).text('Laddar artiklar...');
      
      $('.more_posts_'+ pageNum).load(nextLink + ' .post',
        function() {
          console.log (nextLink);
          // Update page number and nextLink.
          pageNum++;
          nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
          
          // Add a new placeholder, for when user clicks again.
          $('#view_more_posts')
            .before('<div class="more_posts_'+ pageNum +'"></div>')
          
          // Update the button message.
          if(pageNum <= max) {
            $('#view_more_posts').text('+ Visa Fler Artiklar');
          } else {
            $('#view_more_posts').text('Inga Fler Artiklar.');
          }
          tm.initSocial();
          tm.initDirt();
          $("img").trigger("sporty");
          _gaq.push(['_trackEvent', 'DynamicContent', 'loadMorePostsNEW', nextLink]);
        }
      );
    } else {
      $('#view_more_posts').append('.');
    } 
    
    return false;
  });
});
  jQuery(document).ready(function($){
		var originalColor=new Array();;
		//var hoverColor=[];
		originalColor[77]='#EF4F4F';
		originalColor[71]='#C861E6';
		originalColor[64]='#F3AB56';
		originalColor[48]='#4F95EC';
		originalColor[63]='#FDD574';
		originalColor[52]='#75BF75';
        $('.menu-item').hover(
            function(e){
				var id_number=$(this).attr('id').split('-')[2];
				if($('#sub_menu_hover-'+id_number).css('display')=='none'){
					$('#sub_menu_hover-'+id_number).show().animate({"opacity":1},600);
					if(!$('.main_menu #menu-item-'+id_number).hasClass('current-menu-item')){
						$('.main_menu #menu-item-'+id_number).children('a').css('color',originalColor[id_number]);
					}
				}
            },
            function(e){
				var id_number=$(this).attr('id').split('-')[2];
				$('#sub_menu_hover-'+id_number).hide().css({"opacity":0});
				if(!$('.main_menu #menu-item-'+id_number).hasClass('current-menu-item')){
					$('.main_menu #menu-item-'+id_number).children('a').css('color','#fff');
					console.log($('.main_menu #menu-item-'+id_number));
				}
            }            
        );
		
		$('.sub_menu_hover').hover(
			function(e){
				var id_number=$(this).attr('id').split('-')[1];
				var container = $('#menu-item-'+id_number);
				if(!container.hasClass('current-menu-item')){
					container.children('a').css('color',originalColor[id_number]);
				}
				$('#sub_menu_hover-'+id_number).show().css({"opacity":1});
			},
			function(e){
				var id_number=$(this).attr('id').split('-')[1];
				var container = $('#menu-item-'+id_number);
				if(!$(e.relatedTarget.parentNode).is(container)){
					$('#sub_menu_hover-'+id_number).hide().css({"opacity":0});
					if(!container.hasClass('current-menu-item')){
						container.children('a').css('color','#fff');
					}
				}else if($(e.relatedTarget.parentNode).is(container)){
					if(!container.hasClass('current-menu-item')){
						container.children('a').css('color',originalColor[id_number]);
					}
				}else{
					container.children('a').css('color','#fff');
				}
				
			}
		);
        $('.large-450 .color_coding').css('border-top-color',$('#sub_menu_hover-'+$('.current-menu-item').attr('id').split("-")[2]).css('border-top-color'));
        $('.large-450 .text-container p.description .arrow').css('color',$('#sub_menu_hover-'+$('.current-menu-item').attr('id').split("-")[2]).css('border-top-color'));
        $('#js-share-area-2').sharrre({
         share: {
           facebook: true,
           twitter: true,
           pinterest: true,
           googlePlus: true,
         },
         buttons: {
           facebook: {
             layout: 'button_count',
             count: 'horizontal'
           },
           twitter: {count: 'horizontal'},
           pinterest: {media: $('#js-share-area-2').data('media'), description: $('#js-share-area-2').data('text'), layout: 'horizontal'},
           googlePlus: {annotation: 'bubble'},
         },
         enableHover: false,
         enableCounter: false,
         enableTracking: true
       });
  });
var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
        showLeftPush = document.getElementById( 'showLeftPush' ),
        body = document.body;
      showLeftPush.onclick = function() {
        classie.toggle( this, 'active' );
        classie.toggle( body, 'cbp-spmenu-push-toright' );
        classie.toggle( menuLeft, 'cbp-spmenu-open' );
        disableOther( 'showLeftPush' );
      };

      function disableOther( button ) {
        
        if( button !== 'showLeftPush' ) {
          classie.toggle( showLeftPush, 'disabled' );
        }
       
      }