//Set the progress bar once the dom is loaded 
window.addEventListener('load', function(){
    // Javascript widgets
    $('ul.tabs').tabs();
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
    $('.collapsible').collapsible({
        accordion: false
    });
});
console.log('test');
