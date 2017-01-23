/**
 * Created by Maxime on 18/01/2017.
 */
$( document ).ready(function() {
    var pathname = $(location).attr('pathname');
    var res = pathname.split("/");

    if((res[res.length-1]=="app_dev.php") || (res[res.length-2]=="app_dev.php")){  // Permet de load seulement cette partie si l'on se trouve sur la homepage
        var tab = ["boulangerie.png","plomberie.png","pizza.png"];
        var cpt = 0

        setInterval(function(){
            $(".jumbo")[0].style.backgroundImage = "url(../img/"+tab[cpt]+")";
            if(cpt==tab.length-1){
                cpt=0;
            }
            else{
                cpt++;
            }
        }, 5000);

        $(window).scroll(function() {
            if ($(document).scrollTop() > 200) {
                $('nav').addClass('shrink');
            } else {
                $('nav').removeClass('shrink');
            }
        });
    }
    else{
        $('nav').removeClass('navbarCustom')
        $('nav').addClass('navbarCustomPage') //On change le style de la navbar
    }
});
