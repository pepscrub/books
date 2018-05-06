window.addEventListener('load', function(){
    $('select').formSelect();
    
});
var countClick = 0;

function admin_page_ajax(page_req){
    var url = 'http://localhost/books/control/php/body.php?ping=low&page=';
    if(window.navigator.connection.rtt > 500){
        var url = 'http://localhost/books/control/php/body.php?ping=high&page=';
    }

    
    $('#ajax_loader').css({
        'visibility': 'visable'
    });
    $('#loading_opacity').css({
        'opacity': '0.4',
        'filter': 'blur(2.5px)'
    });

    $.ajax({
        url: url + '' + page_req,
        type: 'get',
        dataType: "text",
        success: function (res) {
            $('#ajax_loader').css({
                'visibility': 'hidden'
            })
            $('#loading_opacity').css({
                'transition': 'opacity 1s cubic-bezier(0, 0.9, 0.53, 1), filter 1s cubic-bezier(0, 0.91, 0.58, 1)',
                'opacity': '1',
                'filter': 'blur(0px)'
            });
            setTimeout( function(){
                location.reload(); //I got sick of trying ajax methods of loading php 
            }, 10)

        },
        error: function (err) {
            ajax_err(err, checkurl);
        }
    });
}


// Disabling the enter key as a quickfix
// Hitting enter before would automatically detect the delete form
// first before anything else so it'd delete the object
$(document).keypress(
    function(event){
     if (event.which == '13') {
        event.preventDefault();
      }
});
