$(document).ready(function () {
    // $('.collapse').not('.show').slideUp(1);
    $('.collapse.show').slideDown(1);
    $('.enable_readonly').click(function (e) {
        e.preventDefault();
        let c_ro_input = $(this).parent().find('input');
        let if_active_name = c_ro_input.attr('if_active_name');
        c_ro_input.removeAttr('readonly').removeAttr('disabled').attr('name', if_active_name);
    });
    $('.nav-link.collapsed').click(function (e) {
        e.preventDefault();
        $($(this).attr('href')).toggleClass('show').slideToggle();

    });
    let contaDropDown = 0;
    $('.dropdown-menu').each(function (index, element) {
        $(this).attr('meta-ddm',contaDropDown);
        contaDropDown++;
    });
    $('body').on('click', '.close_modal', function (e) {
        $(this).closest('.modal').remove();
    });
    $('body').on('click', '.dropdown-menu', function (e) {
        $(this).closest('.dropstart').find('.dropdown-menu').removeClass('show');
    });
    $('body').on('click', '.dropdown-toggle', function (e) {
        e.preventDefault();
        let myThis = $(this);
        let currentDropDownMenu = myThis.closest('.dropstart').find('.dropdown-menu');
        let currentDropDownMenuDDM = currentDropDownMenu.attr('meta-ddm');

        $('.dropdown-menu').each(function (index, element) {
            if(currentDropDownMenuDDM != $(this).attr('meta-ddm')){
                $(this).removeClass('show');
            }
        });
        currentDropDownMenu.toggleClass('show');
    });

});