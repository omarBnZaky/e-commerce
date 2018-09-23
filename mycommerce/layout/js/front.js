$(function () {
    'use strict';
    //switch between login &sign up
    $('.login-page h1 span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.' + $(this).data('class')).fadeIn(100);
    });
  
    
    //Hide placeholder
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
    $('.confirm').click(function () {
        
        return confirm('Are you sure?');
        
        
    });
    $('.cat h3').click(function () {
        $(this).next('full-view').fadeToggle(200);
    });
    
      $('.live-name').keyup(function(){
      $('.live-preview h3').text($(this).val());
    });
      $('.live-price').keyup(function(){
      $('.live-preview span').text("$"+$(this).val());
    });
      $('.live-desc').keyup(function(){
      $('.live-preview p').text($(this).val());
    });
});
