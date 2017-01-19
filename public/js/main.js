$(function() {
    $(".dropdown-button").dropdown();
    $(".button-collapse").sideNav();
    $('select').material_select();
    $('.colorpicker').colorpicker({
      component: '.btn'
    });

    $(".alert").delay(4000).slideUp();
});
