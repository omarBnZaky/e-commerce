$(function () {
    'use strict';
  
    $('[placeholder]').focus(function () {
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    
    }).blur(function () {
        $(this).attr('placeholder', $(this).attr('data-text'));
    });
    
    //convert password field to textfield
    var passfield = $('.Pass');
    $('.show-password').hover(function () {
        passfield.attr('type', 'text');
        
    }, function () {
        passfield.attr('type', 'password');
    });
    $('.confirm').click(function(){
        
        return confirm('Are you sure?');
        
        
    });
    $('.cat h3').click(function(){
        $(this).next('full-view').fadeToggle(200);
    });
    
});
