/*
==================================================
Bildslider
==================================================
*/
var navClicked = 0;

function toggleSlider(type,index,slider)
{
    var cur = $(slider).find('li.active'),
    next = cur.next();
    if(!next.length) { next = $(slider).find('li:first-child'); }
    if(type === 2) { next = $(slider).find('li').eq(index); }
    next.addClass('next');
    $(slider).find('li').animate({left:(index*$(slider).find('li').width()*-1)},400 , 'easeInOutExpo', function()
    {
        $(slider).find('li.next').removeClass('next').addClass('active').siblings().removeClass('active');
        navClicked = 0;
        var cur = $(slider).find('li.active'),
        next = cur.next(),
        prev = cur.prev();
    });
}

function sliderPNNav(nav,slider)
{
    $('.slider-content span').live('click',function(){
        var type = $(this).attr('class'),
        next;
        if(type == 'next') { next = $(nav).find('li.active').nextUntil('','li'); }
        if(type == 'prev') { next = $(nav).find('li.active').prevUntil('','li'); }
        if(!next.length)
        {
            if(type == 'next') { next = $(nav).find('li:first-child'); }
            if(type == 'prev') { next = $(nav).find('li:last-child'); }
        }
            $(next).click();
        }
    );
}

function sliderNav(nav,slider)
{
    $(nav).find('li:not(.active)').live('click',function(){
        if(navClicked === 0)
        {
            navClicked = 1;
            var index = $(this).index();
            // PIE HTC fix
            // if($.browser.msie && $.browser.version <= 8) { index = (($(this).index())-1)/2; }
            $(this).addClass('active').siblings().removeClass('active');
            toggleSlider(2,index,slider);
            clearInterval(sliderInt);
        }
    });
}

function initSlider()
{
    var slider = $('.slider'),
    sliderContent = $('.slider-content');
    $(slider).width($(sliderContent).width()*$(slider).children().size());
    if ($(slider).children().size() > 1 )
    {
        $(sliderContent).children('div').append('<span class="prev"></span><span class="next"></span>');
        $(sliderContent).children('div').append('<ul class="slider-nav"></ul>');
        var nav = $('.slider-nav');
        $(slider).find('li').each(function(i,v){$(nav).append('<li></li>');});
        $(nav).find('li:first-child').addClass('active');
        sliderNav(nav,slider);
        sliderPNNav(nav,slider);
        $(slider).find('li:first-child').addClass('active');
        //sliderInt = setInterval( "toggleSlider(1,0)", 7000 );
        /* SLIDER INTERVAL */
        sliderInt = setInterval( function() {
            var tmpIndex,
            tmpNext = $(nav).find('li.active').next();
            tmpIndex = (!tmpNext.length) ? $(nav).find('li:first-child').index() : $(tmpNext).index();
            toggleSlider(2,tmpIndex,$('.slider'));
            $(nav).find('li.active').removeClass('active').parent().find('li').eq(tmpIndex).addClass('active');
        }, 6000 );
    }
    
    if($.browser.msie && $.browser.version <= 8)
    {
        $(nav).show();
        $('span.prev, span.next').show();
    } else
    {
        $(nav).show().animate({opacity:"1"},2000);
        $('span.prev, span.next').show().animate({opacity:"1"},2000);
    }
}

//==================================================
// Sliderpfeile tauchen auf Hover auf
//==================================================
function sliderArrows()
{
    $('.anythingSlider').children('span').stop().animate({
    opacity: 0.0
    }, 10, function() {
        // Animation complete.
    });
    $('.anythingSlider').hover(
    function () {
        $(this).children('span').stop().animate({
            opacity: 1.0
        }, 400, function() {
            // Animation complete.
        });
    },
    function () {
        $(this).children('span').animate({
            opacity: 0.0
        }, 200, function() {
            // Animation complete.
        });
    });
    $('.slider-content > div').children('span').stop().animate({
        opacity: 0.0
    }, 10, function() {
        // Animation complete.
    });
    $('.slider-content > div').hover(
    function () {
        $(this).children('span').stop().animate({
            opacity: 1.0
        }, 400, function() {
            // Animation complete.
        });
    },
    function () {
        $(this).children('span').animate({
            opacity: 0.0
        }, 200, function() {
            // Animation complete.
        });
    });
}