/**
 * Created by 110230 on 16-08-2016.
 */

$(document).click(function (e) {

   var container    =   $('#menu');

    if(!container.is(e.target)//if the target of the click isnt the container
        && container.has(e.target).length==0 // nor a decendent of the container
            && !$('nav ul').hasClass('hide')) //and nav ul dosent have the class hide
    {
        $('nav ul').addClass('hide');

    }
    else if(container.is(e.target))//if the target of the click IS the container
    {
        $('nav ul').toggleClass('hide');

    }
});
$('.details').click(function () {
    $('#verynice').removeClass("hidden");
    console.log("YOYOOYOYOYOYYO");
});

