$("#menuBT").click(function () {
    $("#pages").animate({
        height: 'toggle'
    });
    $("#menuBT").toggleClass("change");
});