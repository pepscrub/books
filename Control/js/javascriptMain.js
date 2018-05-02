//Set the progress bar once the dom is loaded 
window.addEventListener('load', function(){
    // Javascript widgets
    $('ul.tabs').tabs();
    $('.carousel').carousel({
        fullWidth: true,
        duration: 500
    });
    $('.dropdown-trigger').dropdown({
        constrainWidth: false,
    });
    $('.materialboxed').materialbox();
    $('.tooltipped').tooltip({
        html: true
    });
    $('.sidenav').sidenav();
    $('.scrollspy').scrollSpy();
    $('.modal').modal();
    $('.datepicker').datepicker();
    $('.fixed-action-btn').floatingActionButton();
    $('.scrollspy').scrollSpy();
    $('.collapsible').collapsible({
        accordion: false
    });
    $('.parallax').parallax();

    //Datepicker
    var date = new Date();

    $('.datepicker').datepicker({
        maxDate: date,
        format: 'yyyy'

    });
    page_ajax(' '); // Default landing page
    scroll_window();
    optimzation();
});

$(window).scroll(function () { 
    scroll_window();
});

function optimzation(){
    //If the ping is over 850 delete all the images in the dom
    if(window.navigator.hardwareConcurrency < 2 || window.navigator.deviceMemory < 2){ //If there's less than 2 cores in the cpu or less than 2gbs of ram 
        var elems = document.getElementsByTagName("img"), index;
        for(index = elems.length - 1; index >= 0; index--){
            elems[index].parentNode.removeChild(elems[index]);
        }
    }
}

function scroll_window(){//If the users got less than 3 logical processors dont render out the gradient nav
    if(window.navigator.hardwareConcurrency > 4){
        if($(window).scrollTop() < 300){
            document.getElementById('nav-colors').style = 'background: linear-gradient(42deg, #1627ae00, #a016ae00, #16aea900); animation: AnimationName 60s ease infinite; transition: background .5s linear; background-size: 600% 600%;';
        }else{
            document.getElementById('nav-colors').style = 'background: linear-gradient(42deg, #1627ae, #a016ae, #16aea9); animation: AnimationName 60s ease infinite; background-size: 600% 600%; transition: background .25s linear; ';
        }
    }else{
        if($(window).scrollTop() < 450){
            document.getElementById('nav-colors').style = 'background-color: #26a69a00; transition: background-color .5s linear;';
        }else{
            document.getElementById('nav-colors').style = 'background-color: #26a69a; transition: background-color .25s linear;';
        }
    }
}

// Just moves the slider every 15 seconds

setInterval(function(){
    var instance = M.Carousel.getInstance(header_slider);
    instance.next();
}, 15000)



function page_ajax(page_req){
    $('#ajax_loader').css({
        'visibility': 'visable'
    });
    $('#loading_opacity').css({
        'opacity': '0.4',
        'filter': 'blur(2.5px)'
    });
    var url = 'control/php/body.php?ping=low&page=';
    if(window.navigator.connection.rtt > 500){
        var url = 'control/php/body.php?ping=high&page=';
    }
    console.log(url + '' + page_req);
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

            battery();

        },
        error: function (err) {
            ajax_err(err, checkurl);
        }
    });
}

// Progress bar for battery if the person is on a laptop or phone 
// Kind of unnecassary but it was a fun side project

function battery(){
    var promise = window.navigator.getBattery(); //Getting promise from navigator object
    promise.then(function(value){ //Opening promise
        //If the charging value is true and chargingtime is not 0 or if the dischargingin time is not inifity
        if(value.charging === true && value.chargingTime != 0 || value.dischargingTime != 'Infinity'){
            value.onlevelchange = function(){
                var charge = this.level * 100;
                console.log(charge);
                $('#ajax_loader').html('<div class="determinate" style="width: '+charge+'%"></div>')
                battery();
            }
        }
    });
}


