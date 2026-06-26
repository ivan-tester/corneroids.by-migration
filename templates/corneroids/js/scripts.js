$(document).ready(function() { 

    $("ul.menu li").hover(function() { 

        $(this).find("ul").hide().show("slow"); 

    }, function() { 

        $(this).find("ul").hide("slow"); 

    }); 

});