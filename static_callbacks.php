<script type="text/javascript" src="includes/lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="includes/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="includes/skins/tango/skin.css" />

<style type="text/css">

/**
 * Overwrite for having a carousel with dynamic width.
 */
.jcarousel-skin-tango .jcarousel-container-horizontal {
    width: 85%;
}

.jcarousel-skin-tango .jcarousel-clip-horizontal {
    width: 100%;
}

#display {
    clear: both;
    width: auto;
    height: 250px;
    overflow: scroll;
    border: 1px solid #666;
    background-color: #fcfcfc;
    padding: 10px;
}
</style>

<script type="text/javascript">
function mycarousel_buttonNextCallback(carousel, button, enabled) {
    display('Next button is now ' + (enabled ? 'enabled' : 'disabled'));
};
function mycarousel_buttonPrevCallback(carousel, button, enabled) {
    display('Prev button is now ' + (enabled ? 'enabled' : 'disabled'));
};
function mycarousel_initCallback(carousel, state) {
    if (state == 'init')
        display('Carousel initialised');
    else if (state == 'reset')
        display('Carousel reseted');
};
function mycarousel_reloadCallback(carousel) {
    display('Carousel reloaded');
};
function mycarousel_itemFirstInCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is now the first item');
};
function mycarousel_itemFirstOutCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer the first item');
};
function mycarousel_itemLastInCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is now the last item');
};
function mycarousel_itemLastOutCallback(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer the last item');
};
function mycarousel_itemVisibleInCallbackBeforeAnimation(carousel, item, idx, state) {
    // No animation on first load of the carousel
    if (state == 'init')
        return;

    jQuery('img', item).fadeIn('slow');
};
function mycarousel_itemVisibleInCallbackAfterAnimation(carousel, item, idx, state) {
    display('Item #' + idx + ' is now visible');
};
function mycarousel_itemVisibleOutCallbackBeforeAnimation(carousel, item, idx, state) {
    jQuery('img', item).fadeOut('slow');
};
function mycarousel_itemVisibleOutCallbackAfterAnimation(carousel, item, idx, state) {
    display('Item #' + idx + ' is no longer visible');
};

var row = 1;
function display(s) {
    // Log to Firebug (getfirebug.com) if available
    //if (window.console != undefined && typeof window.console.log == 'function')
      //  console.log(s);

    if (row >= 1000)
        var r = row;
    else if (row >= 100)
        var r = '&nbsp;' + row;
    else if (row >= 10)
        var r = '&nbsp;&nbsp;' + row;
    else
        var r = '&nbsp;&nbsp;&nbsp;' + row;

    jQuery('#display').html(jQuery('#display').html() + r + ': ' + s + '<br />').get(0).scrollTop += 10000;

    row++;
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        scroll: 1,

        initCallback:   mycarousel_initCallback,
        reloadCallback: mycarousel_reloadCallback,

        buttonNextCallback:   mycarousel_buttonNextCallback,
        buttonPrevCallback:   mycarousel_buttonPrevCallback,

        itemFirstInCallback:  mycarousel_itemFirstInCallback,
        itemFirstOutCallback: mycarousel_itemFirstOutCallback,
        itemLastInCallback:   mycarousel_itemLastInCallback,
        itemLastOutCallback:  mycarousel_itemLastOutCallback,
        itemVisibleInCallback: {
            onBeforeAnimation: mycarousel_itemVisibleInCallbackBeforeAnimation,
            onAfterAnimation:  mycarousel_itemVisibleInCallbackAfterAnimation
        },
        itemVisibleOutCallback: {
            onBeforeAnimation: mycarousel_itemVisibleOutCallbackBeforeAnimation,
            onAfterAnimation:  mycarousel_itemVisibleOutCallbackAfterAnimation
        }
    });
});

</script>