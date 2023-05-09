$("#menuBT").click(function () {
    $("#pages").animate({
        height: 'toggle'
    });
    $("#menuBT").toggleClass("change");
});
if (window.location.pathname === "/mySudoku/login" && window.innerWidth > "768") {
    $("#Login").css("background-color","#0271C0").css("color","#FFFFFF"); 
} else if(window.location.pathname === "/mySudoku/login" && window.innerWidth < "768") {
    $("#Login").css("box-shadow","0 2px 0 #0271C0").css("color","#0271C0");
};
if (window.location.pathname === "/mySudoku/register" && window.innerWidth > "768") {
    $("#Register").css("background-color","#0271C0").css("color","#FFFFFF");   
} else if(window.location.pathname === "/mySudoku/register" && window.innerWidth < "768") {
    $("#Register").css("box-shadow","0 2px 0 #0271C0").css("color","#0271C0");
};
if (window.location.pathname === "/mySudoku/game" && window.innerWidth > "768") {
    $("#Game").css("background-color","#0271C0").css("color","#FFFFFF");
} else if(window.location.pathname === "/mySudoku/game" && window.innerWidth < "768") {
    $("#Game").css("box-shadow","0 2px 0 #0271C0").css("color","#0271C0");
};

$('.profil').click(function () {
    $('.toggle-profil').toggleClass('active')
})
$('main').click(function () {
    $('.toggle-profil').removeClass('active')
})

const close = document.getElementById('close');

close.addEventListener('click', function(){
    document.getElementById('toggle').classList.remove('active');
    document.getElementById('toggle-page').classList.remove('active');
})
