var $ = jQuery.noConflict();


$(function() {
    getFields();
});

function getFields() {
    $('.nt-script-entry').each(function() {
        var slug = $(this).data('script-slug'),
            deps = $(this).data('script-deps').split(', '),
            data = '',
            el = $(this);

        $.get("//api.cdnjs.com/libraries/" + slug, function(data) {
            setFields(el, data, deps);
        });
    });
}

function setFields(el, data, deps) {
    $("#version-result", el).text(data.version);
    $("#description-result", el).text(data.description);

    // $.each(data.assets[0].files, function(key, value) {
    //     if ( deps.indexOf(value) > -1 ) {
    //         $("#assets-result", el).append('<span style="display:block" class="asset">' + value + '</span>');
    //     }
    // });

    checkVersion();
}

function getFileExtension(filename) {
  return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
}

$('.script-button').click(function(e) {
    var button = $(this),
        ref = $(this).closest('.nt-script-entry'),
        script = ref.data('script-deps').split(', '),
        slug = ref.data('script-slug'),
        version = ref.data('script-version');

	$.ajax({
            type:   'POST',
            url:    '/wp-admin/admin-ajax.php',
            data:   {
                action     : 'nt_scripts',
                scriptURL  : script,
                slug       : slug,
                version    : version
            },
            dataType: 'json'
        }).done(function( json ) {
            if( json.success ) {
                if ( button.hasClass('nt-enabled') ) {
                    ref.removeClass('enabled').addClass('nt-disabled');
                    button.text('Enable').removeClass('nt-enabled').addClass('nt-disabled');
                    $( '<div style="display: none;" class="success-msg">' + json.message + ' removed.</div>' ).prependTo('#wpbody').fadeIn().delay(5000).fadeOut();
                } else if ( button.hasClass('nt-disabled') ) {
                    ref.removeClass('nt-disabled').addClass('nt-enabled');
                    button.text('Disable').removeClass('nt-disabled').addClass('nt-enabled');
                    $( '<div style="display: none;" class="success-msg">' + json.message + ' added.</div>' ).prependTo('#wpbody').fadeIn().delay(5000).fadeOut();
                }
            } else if( !json.success ) {
                $( '<div style="display: none;" class="fail-msg">Function failed and returned: ' + json.message + '</div>' ).prependTo('#wpbody').fadeIn().delay(5000).fadeOut();
            }
        }).fail(function() {
            $( '<div style="display: none;" class="error-msg">AJAX: Failed.</div>' ).prependTo('#wpbody').fadeIn().delay(5000).fadeOut();
        });
});

function checkVersion() {
    $('.nt-script-entry').each(function(){
        var approvedVersion = $('#approved-version', this),
        currentVersion = $('#version-result', this);

        if ( cmpVersions( currentVersion.text(), approvedVersion.text())  <= 0 ) {
            approvedVersion.text(approvedVersion.text() + ' ✔');
        } else {
            $('.script-button', this).attr('disabled');
        }
    });
}

function cmpVersions (a, b) {
    var i, diff;
    var regExStrip0 = /(\.0+)+$/;
    var segmentsA = a.replace(regExStrip0, '').split('.');
    var segmentsB = b.replace(regExStrip0, '').split('.');
    var l = Math.min(segmentsA.length, segmentsB.length);

    for (i = 0; i < l; i++) {
        diff = parseInt(segmentsA[i], 10) - parseInt(segmentsB[i], 10);
        if (diff) {
            return diff;
        }
    }
    return segmentsA.length - segmentsB.length;
}