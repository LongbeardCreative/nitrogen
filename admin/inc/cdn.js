var $ = jQuery.noConflict();


$(function() {
    getFields();
});

function getFields() {
    $('.nt-script-entry').each(function() {
        var slug = $(this).data('script-slug'),
            deps = $(this).data('script-deps').split(', '),
            data = '';

        $.get("//api.cdnjs.com/libraries/" + slug, function(data) {
            setFields(data, deps);
        });
    });
}

function setFields(data, deps) {
    $("#version-result").text(data.version);
    $("#description-result").text(data.description);

    $.each(data.assets[0].files, function(key, value) {
        if ( deps.indexOf(value) > -1 ) {
            $("#assets-result").append('<span style="display:block" class="asset">' + value + '</span>');
        }
    });
}

$('.script-button').click(function(e) {
	var option = $(this).closest('.nt-script-entry').data('script-slug');

	console.log(option);

    $.post( '/wp-content/plugins/nitrogen/admin/inc/get_scripts.php', { 'nt_settings': option } ).error( 
        function(e) {
            alert('There was an error setting your script: ' + e.error);
        }).success( function() {
            alert('success');   
        });
    return false;    
});