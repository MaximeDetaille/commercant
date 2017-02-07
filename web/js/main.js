/**
 * Created by Maxime on 18/01/2017.
 */
$( document ).ready(function() {
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
});
