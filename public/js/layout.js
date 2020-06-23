$(document).ready(function () {
    if(window.location.href.includes("catalogs"))
    {
        console.log("Oke catalog");
        $('.sidebar-sticky a').siblings('a').removeClass('active');
        $('#menuCatalog').addClass('active');
    }
    if(window.location.href.includes("flowers"))
    {
        $('.sidebar-sticky a').siblings('a').removeClass('active');
        $('#menuFlower').addClass('active');
    }
})