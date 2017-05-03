<script type="text/javascript" src="includes/lib/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="includes/lib/jquery.jcarousel.min.js"></script>
<script type="text/javascript" src="includes/thickbox/thickbox.js"></script>
<link rel="stylesheet" type="text/css" href="includes/thickbox/thickbox.css" />
<link rel="stylesheet" type="text/css" href="includes/skins/ie7/skin.css" />

<script type="text/javascript">
// Set thickbox loading image
tb_pathToImage = "includes/images/loading-thickbox.gif";

var mycarousel_itemList = [
    {url: "images/cars/Car_00001.jpg", title: "pic1"},
    {url: "images/cars/Car_00002.jpg", title: "pic2"},
    {url: "images/cars/Car_00003.jpg", title: "pic3"},
    {url: "images/cars/Car_00004.jpg", title: "pic4"},
    {url: "images/cars/Car_00005.jpg", title: "pic5"},
];

function mycarousel_itemLoadCallback(carousel, state)
{
    for (var i = carousel.first; i <= carousel.last; i++) {
        if (carousel.has(i)) {
            continue;
        }

        if (i > mycarousel_itemList.length) {
            break;
        }

        // Create an object from HTML
        var item = jQuery(mycarousel_getItemHTML(mycarousel_itemList[i-1])).get(0);

        // Apply thickbox
        tb_init(item);

        carousel.add(i, item);
    }
};

/**
 * Item html creation helper.
 */
function mycarousel_getItemHTML(item)
{
    var url_m = item.url.replace(/_s.jpg/g, '_m.jpg');
    return '<a href="' + url_m + '" title="' + item.title + '"><img src="' + item.url + '" width="75" height="75" border="0" alt="' + item.title + '" /></a>';
};

jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
        size: mycarousel_itemList.length,
        itemLoadCallback: {onBeforeAnimation: mycarousel_itemLoadCallback}
    });
});

</script>
