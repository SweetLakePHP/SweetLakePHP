$(document).ready(function(){
    // setup tooltips
    $('.contributors img').tooltip();
    $('#follow-us').tooltip();
    $('.sponsors a img').tooltip();

    $('#writeup_content').autosize();

    $("#writeup_content").on('keyup', function(){
        var text = $(this).val();
        $.post(Routing.generate('event.writeup.preview'), {
            'text': text
        })
        .always(function(jqXHR, status){
            if (status == 'success') {
                $("#writeup_preview").html(jQuery.parseJSON(jqXHR));
            }
        });
    });

    var saveForm = '';

    window.setInterval(function(){
        if ($("#writeup_autosave").is(':checked')) {
            var form           = $("#writeup_form");
            var eventId        = $("#event_id").text();
            var autosaveHolder = $("#autosave_holder");

            if (saveForm != form.serialize()) {
                $.post(Routing.generate('event.writeup.autosave', {'eventId': eventId}), form.serialize())
                .always(function(jqXHR, status){
                    if (status == 'success') {
                        var data = jQuery.parseJSON(jqXHR);
                        if (data['success']) {
                            autosaveHolder.css('background-color', '#9FC76F');
                            setTimeout(function(){
                                autosaveHolder.css('background-color', "")
                            }, 1500);
                        } else {
                            autosaveHolder.css('background-color', '#CA6F74');
                            setTimeout(function(){
                                autosaveHolder.css('background-color', "")
                            }, 1500);
                        }
                    } else {
                        autosaveHolder.css('background-color', '#CA6F74');
                        setTimeout(function(){
                            autosaveHolder.css('background-color', "")
                        }, 1500);
                    }
                });

                saveForm = form.serialize();
            }
        }
    }, 7500);


})