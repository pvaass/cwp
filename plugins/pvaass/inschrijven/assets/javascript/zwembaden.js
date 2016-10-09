
var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type');
var fields = JSON.parse(window.zwembaden);
jQuery.each(fields.zwembaden, function(key, value){
    $el.append($("<option></option>").attr("value", key).text(value.name))
});


jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type').on('change', function(e) {
    var id = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type option:selected').val();
    var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden');
    $el.empty();
    jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_dagen').empty();
    jQuery.each(fields.zwembaden[id].fields, function(key, value){
        $el.append($("<option></option>").attr("value", key).text(value.name))
    });
});

jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden').on('change', function(e) {

    var typeId = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_type option:selected').val();
    var badId = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_baden option:selected').val();
    var $el = jQuery('#inschrijf-zwembaden .inschrijf-zwembaden_dagen');
    $el.empty();
    jQuery.each(fields.zwembaden[typeId].fields[badId].fields, function(key, value){
        $el.append($("<option></option>").attr("value", key).text(value.name))
    });
});