$(document).ready(function() {
    $('body').append('<div id="promo-div"></div>');
    
    var scripts = document.getElementsByTagName("script");
    src = scripts[scripts.length-1].src;
    var currentScriptChunks = src.split( '/' );
    var currentScriptFile = currentScriptChunks[2];
    var url=  'https://'+currentScriptFile+"/home/promo";
    $.ajax({
        type: "POST",
        url:  url,
        data: {},
        success: function (data) {
            // console.log(data.output);
            $('#promo-div').html(data.output);
        },
        error: function (error) {
        }
    });
});



