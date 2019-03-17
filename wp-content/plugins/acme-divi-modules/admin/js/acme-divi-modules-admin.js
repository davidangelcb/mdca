(function( $ ) {
	'use strict';

    $(function () {
        var plugin_name = 'acme-divi-modules';
        var spinner = '<div class="spinner is-active" style="float:none;width:auto;height:auto;padding:10px 0 10px 50px;background-position:20px 0;">';

        console.log('This is an Acme Console Log!');



        //clear divi cache
       // var sb_ls_remove = ['et_pb_portfolio_excerpt'];
        window.localStorage.clear();
        console.log('Divi cache maybe cleared!');
       /* for (var prop in localStorage) {
            localStorage.removeItem(prop);
        }*/


        $('#acme-divi-modules-abmp-add-preset').click(function () {
            $('.abmp_new_preset').css('display','block');
            $(this).hide();
        });

        $('.acme-divi-modules-abmp-abmp_preset-post_type').each(function() {
            $(this).change(function () {
                var myIDref = $(this).attr('rel');
                var myDest = $('#acme-divi-modules-abmp-abmp_preset-' + myIDref + '-taxonomy');
                var data = {
                    'action': 'abmp_get_taxonomies',
                    'post_type': $(this).val()
                };
                jQuery.post(ajaxurl, data, function (response) {
                    var ar = $.parseJSON(response);
//                console.log(response);
                    var options = '<option value=""></option>';
                    for (var i in ar) {
                        options += '<option value="' + ar[i] + '">' + ar[i] + '</option>';

                    }
                    $(myDest).html(options);
                    $('#acme-divi-modules-abmp-terms-' + myIDref + '-container').empty();
                });
            });
        });

        $('.acme-divi-modules-abmp-abmp_preset-taxonomy').each(function () {
            $(this).change(function () {
                var myIDref = $(this).attr('rel');
                var myDest = $('#acme-divi-modules-abmp-terms-' + myIDref + '-container');
                myDest.append(spinner);
                var data = {
                    'action': 'abmp_get_terms_html',
                    'taxonomy': $(this).val(),
                    'index_preset': myIDref
                };
                jQuery.post(ajaxurl, data, function (response) {
                    $('.spinner').remove();
                    $(myDest).html(response);
                });
            });
        });

        $('.button-secondary.delete').each(function(){
            $(this).click(function () {
                console.log('triggered');
                $(this).parent().remove();
                $('.notice.notice-warning.hidden.save-reminder').removeClass('hidden');
            });
            console.log($(this).val());
        });

        /*
        * LOAD JQUERY UI INTERFACE
        * */



        var tabs = $('#tabs').tabs();
        var accordion = $('.acme_abmp_accordion').accordion({
            collapsible: true,
            heightStyle: "content"
        });
    });



})( jQuery );
