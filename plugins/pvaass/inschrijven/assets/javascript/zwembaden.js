//
// var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type');
// var fields = JSON.parse(window.zwembaden);
// jQuery.each(fields.zwembaden, function(key, value){
//     $el.append($("<option></option>").attr("value", key).text(value.name))
// });
//
//
// jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type').on('change', function(e) {
//     var id = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type option:selected').val();
//     var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden');
//     $el.empty();
//     jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_dagen').empty();
//     jQuery.each(fields.zwembaden[id].fields, function(key, value){
//         $el.append($("<option></option>").attr("value", key).text(value.name))
//     });
// });
//
// jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden').on('change', function(e) {
//
//     var typeId = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type option:selected').val();
//     var badId = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden option:selected').val();
//     var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_dagen');
//     $el.empty();
//     jQuery.each(fields.zwembaden[typeId].fields[badId].fields, function(key, value){
//         $el.append($("<option></option>").attr("value", key).text(value.name))
//     });
// });

function registerZwembadPicker() {
    var $portfolio_selectors = $('.portfolio-filter >li>a');
    var $portfolio = $('.portfolio-items');
    $portfolio.isotope({
        itemSelector: '.portfolio-item',
        layoutMode: 'fitRows'
    });

    $portfolio_selectors.on('click', function () {
        $portfolio_selectors.removeClass('active');
        $(this).addClass('active');
        var selector = $(this).attr('data-filter');
        $portfolio.isotope({filter: selector});
        return false;
    });

    $ = jQuery;
    $(".inschrijven-zwembad[data-toggle]").tooltip();

    $(".inschrijven-zwembad").on('click', function () {
        if ($(this).children().hasClass('zwembad-disable')) {
            return;
        }
        var zwembad = $(this).data("zwembad");
        $('.inschrijven-zwembad-tijden[data-zwembad]').hide();

        $("input[type=radio]").attr('checked', false);

        console.log($('[data-zwembad="' + zwembad + '"] input[type=radio]').first());
        $('[data-zwembad="' + zwembad + '"] input[type=radio]').first().prop('checked', true);
        $('[data-zwembad="' + zwembad + '"]').show();

        console.log($('#main-menu').height());
        $('html, body').animate({scrollTop: $('.inschrijven-zwembad-tijden[data-zwembad="' + zwembad + '"]').offset().top - 20 - $('#main-menu').height()}, 300);
    });
}

function toTop() {
    $('html, body').animate({scrollTop: $('.guide').offset().top - 20 - $('#main-menu').height()}, 1);
}

var formSubmitting = false;
var setFormSubmitting = function() { formSubmitting = true; };
window.addEventListener("beforeunload", function (e) {
    if (formSubmitting || window.isApp) {
        return undefined;
    }
    var confirmationMessage = 'Je hebt de inschrijving nog niet helemaal voltooid. Weet je zeker dat je de pagina wilt verlaten?';

    (e || window.event).returnValue = confirmationMessage; //Gecko + IE
    return confirmationMessage; //Gecko + Webkit, Safari, Chrome etc.
});
