/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-12 Chi Hoang <info@chihoang.de>
 *  All rights reserved
 *
 ***************************************************************/
( function() {
  
    var $j;
    var boxCount = 0, counter = 0;
   
    /*
    ==================================================
    Bildslider
    ==================================================
    */
    var navClicked = 0;
    
    function toggleSlider(type,index,slider)
    {
        var cur = $j(slider).find('li.active'),
        next = cur.next();
        if(!next.length) { next = $j(slider).find('li:first-child'); }
        if(type === 2) { next = $j(slider).find('li').eq(index); }
        next.addClass('next');
        $j(slider).find('li').animate({left:(index*$j(slider).find('li').width()*-1)},400 , 'easeInOutExpo', function()
        {
            $j(slider).find('li.next').removeClass('next').addClass('active').siblings().removeClass('active');
            navClicked = 0;
            var cur = $j(slider).find('li.active'),
            next = cur.next(),
            prev = cur.prev();
        });
    }
    
    function sliderPNNav(nav,slider)
    {
        $j('.slider-content span').live('click',function(){
            var type = $j(this).attr('class'),
            next;
            if(type == 'next') { next = $j(nav).find('li.active').nextUntil('','li'); }
            if(type == 'prev') { next = $j(nav).find('li.active').prevUntil('','li'); }
            if(!next.length)
            {
                if(type == 'next') { next = $j(nav).find('li:first-child'); }
                if(type == 'prev') { next = $j(nav).find('li:last-child'); }
            }
                $j(next).click();
            }
        );
    }
    
    function sliderNav(nav,slider)
    {
        $j(nav).find('li:not(.active)').live('click',function(){
            if(navClicked === 0)
            {
              navClicked = 1;
              var index = $j(this).index();
              // PIE HTC fix
              // if($.browser.msie && $.browser.version <= 8) { index = (($(this).index())-1)/2; }
              $j(this).addClass('active').siblings().removeClass('active');
              toggleSlider(2,index,slider);
              clearInterval(sliderInt);
            }
        });
    }
    
    function initSlider()
    {
        var slider = $j('#tx-chbildgalerie-pi1 #slider-content .slider'),
        sliderContent = $j('#tx-chbildgalerie-pi1 .slider-content');
        $j(slider).width($j(sliderContent).width()*$j(slider).children().size()+20);
        if ($j(slider).children().size() > 1 )
        {
            $j(sliderContent).children('div').append('<span class="prev"></span><span class="next"></span>');
            $j(sliderContent).children('div').append('<ul class="slider-nav"></ul>');
            var nav = $j('.slider-nav');
            $j(slider).find('li').each(function(i,v){$j(nav).append('<li></li>');});
            $j(nav).find('li:first-child').addClass('active');
            sliderNav(nav,slider);
            sliderPNNav(nav,slider);
            $j(slider).find('li:first-child').addClass('active');
            //sliderInt = setInterval( "toggleSlider(1,0)", 7000 );
            /* SLIDER INTERVAL */
            sliderInt = setInterval( function() {
                var tmpIndex,
                tmpNext = $j(nav).find('li.active').next();
                tmpIndex = (!tmpNext.length) ? $j(nav).find('li:first-child').index() : $j(tmpNext).index();
                toggleSlider(2,tmpIndex,$('.slider'));
                $(nav).find('li.active').removeClass('active').parent().find('li').eq(tmpIndex).addClass('active');
            }, 6000 );
        }
        
        if($j.browser.msie && $j.browser.version <= 8)
        {
            $j(nav).show();
            $j('span.prev, span.next').show();
        } else
        {
            $j(nav).show().animate({opacity:"1"},2000);
            $j('span.prev, span.next').show().animate({opacity:"1"},2000);
        }
      }

      //==================================================
      // Sliderpfeile tauchen auf Hover auf
      //==================================================
      function sliderArrows()
      {
        $j('.anythingSlider').children('span').stop().animate({
            opacity: 0.0
        }, 10, function() {
            // Animation complete.
        });
        $j('.anythingSlider').hover(
        function () {
            $j(this).children('span').stop().animate({
                opacity: 1.0
            }, 400, function() {
                // Animation complete.
            });
        },
        function () {
            $j(this).children('span').animate({
                opacity: 0.0
            }, 200, function() {
                // Animation complete.
            });
        });
        $j('.slider-content > div').children('span').stop().animate({
            opacity: 0.0
        }, 10, function() {
            // Animation complete.
        });
        $j('.slider-content > div').hover(
        function () {
            $j(this).children('span').stop().animate({
                opacity: 1.0
            }, 400, function() {
                // Animation complete.
            });
        },
        function () {
            $j(this).children('span').animate({
                opacity: 0.0
            }, 200, function() {
                // Animation complete.
            });
        });
      }
      
      function Standort (uid)
      {
          if (uid !== "0")
          {
             url = $j("form#tx-chbildgalerie-pi1").attr('action')+"&eID=ch_bildergalerie&uid="+uid;
             $j('#tx-chbildgalerie-pi1 #container').css({height: "0px !important"});
          } else
          {
             url = $j("form#tx-chbildgalerie-pi1").attr('action')+"&eID=ch_bildergalerie";
             
             /* $j('#tx-chbildgalerie-pi1 #container').css({
                                                          height: "auto !important"
                                                          });
                                                          
             */
          }
         
          $j.getJSON(url, function(json_response)
          {
              var slider = $j('#tx-chbildgalerie-pi1 #slider-content .slider');
              slider.empty();
              $j.each(json_response.screen, function (idx, ele)
              {
                slider.append($j("#slider-template").tmpl(ele));
              });
 
              var container = $j('#tx-chbildgalerie-pi1 #container');
              
              if (uid !== "0")
              {
                container.empty();
                container.imagesLoaded(function(){
                  container.masonry({
                      itemSelector: '.thumbnail',
                      columnWidth: 220,
                      isAnimated: false
                   });
                 });  
                $j.each(json_response.fx_, function(idx, ele)
                {
                  container.append($j("#thumbnail").tmpl(ele)).masonry('reload'); 
                });
                $j('#tx-chbildgalerie-pi1 .back_button').show();
                $j('#tx-chbildgalerie-pi1 .back_button');
                
              } else
              {
                container.empty();
                container.imagesLoaded(function(){
                  container.masonry({
                      itemSelector: '.screen',
                      columnWidth: 220,
                      isAnimated: false
                   });
                 });  
                $j.each(json_response.fx_, function(idx, ele)
                {
                  container.append($j("#screen").tmpl(ele)).masonry('reload'); 
                });
                
                
                $j('#tx-chbildgalerie-pi1 .back_button').hide(); 
              }
              
              container.imagesLoaded(function(){
                  container.masonry({
                      itemSelector: '.screen',
                      columnWidth: 220,
                      isAnimated: false
                   });
                 });
               
              container.imagesLoaded(function(){
                $j('#container a').lightBox({
                    'imageLoading': "typo3conf/ext/ch_bildergalerie/res/images/lightbox-ico-loading.gif",
                    'imageBtnClose': "typo3conf/ext/ch_bildergalerie/res/images/lightbox-btn-close.gif",
                    'imageBtnPrev': "typo3conf/ext/ch_bildergalerie/res/images/lightbox-btn-prev.gif",
                    'imageBtnNext': "typo3conf/ext/ch_bildergalerie/res/images/lightbox-btn-next.gif",
                    'imageBlank': "typo3conf/ext/ch_bildergalerie/res/images/lightbox-blank.gif"                          
                  }); // Select all links in object with gallery ID
              }); 
              //initSlider();
              //sliderArrows();

           });
      };
      
      Galerie.prototype.Standort = function ( uid )
      {
            return Standort ( uid );
      }

      function Galerie (anonymous)
      {    
          $j = anonymous;
          
          url = $j("form#tx-chbildgalerie-pi1").attr('action')+"&eID=ch_bildergalerie";
          
          // First time, Reload, Tab closed, Browser, Close, Cookie deleted, PHPSESSIONID deleted
          $j.getJSON(url, function(json_response)
          {
              var slider = $j('#tx-chbildgalerie-pi1 #slider-content .slider');
              slider.empty();
              $j.each(json_response.screen, function (idx, ele)
              {
                slider.append($j("#slider-template").tmpl(ele));
              });
 
              //var container = $j('#tx-chbildgalerie-pi1 #container');
              
              //container.masonry({
              //    itemSelector: '.thumbnail',
              //    columnWidth: 220,
              //    isAnimated: false
              // });  
              
              //$j.each(json_response.fx_, function(idx, ele)
              //{
              //  container.append($j("#screen").tmpl(ele)).masonry('reload'); 
              //});
              
              //container.imagesLoaded(function(){
              //  container.masonry({
              //      itemSelector: '.thumbnail',
              //      columnWidth: 220,
              //      isAnimated: false
              //   }).masonry('reload');
              // });
              //container.children("img").each(function(){
              //  var totalHeight = totalHeight + $j(this).outerHeight();
              //});
              //container.css({height: totalHeight/4});
               
              $j('#tx-chbildgalerie-pi1 .back_button').hide(); 
              initSlider();
              sliderArrows();
           });
      };
      
      window.Galerie = Galerie;
})();

var page;
var $ = $.noConflict();
$(document).ready(function()
{
  page = new Galerie($);
  page.Standort("0");
});