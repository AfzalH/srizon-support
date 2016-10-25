var ajaxinprogress = false;
window.onbeforeunload = function () {
    if (ajaxinprogress) {
        return "Some background requests are still not complete.";
    }
};
$(function () {
    $("form").on("submit", function (event) {
        var $this = $(this);
        $(this).find('input:submit').attr('disabled', 'disabled');
        setTimeout(function () {
            $this.find('input:submit').removeAttr('disabled');
        }, 3000);
    });

    if ($('.focus-element').length) {
        $('.focus-element .box-tools, .defocus, .title-collapse').click(function () {
            $('.defocus').fadeOut();
        });
    }
    $('.ticket-filter a').click(function (e) {
        e.preventDefault();
        $(this).closest('ul').find('li.active').removeClass('active');
        $(this).closest('li').addClass('active');
        var product_id = $('.product-list-for-ticket li.active a').data('id');
        var status_id = $('.status-list-for-ticket li.active a').data('id');

        $("#recent-tickets").append('<div class="overlay">\
            <i class="fa fa-refresh fa-spin"></i>\
            </div>');
        var ajaxobj = $.ajax({
            url: recent_tickets_url,
            method: 'GET',
            data: {
                'product': product_id,
                'status': status_id
            }
        });

        ajaxobj.done(function (data) {
            $("#recent-tickets .tickets-list").html(data);
        });

        ajaxobj.fail(function () {
            alert('Something went wrong while getting requested data.');
        });

        ajaxobj.always(function () {
            $('#recent-tickets .overlay').remove();
        });
    });

    $(".sortable-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999,
        update: function (event, ui) {
            var $this = $(this);
            var items = $(this).find('li').map(function () {
                var item = {};
                item.sort_order = $(this).index();
                item.id = $(this).data('id');
                return item;
            });

            $.ajax({
                url: $(this).data('sorturl'),
                method: 'POST',
                data: {
                    '_token': $(this).data('csrf'),
                    'query': JSON.stringify(items)
                },
                success: function (data) {
                    var callclass = 'callout' + Math.random().toString(36).substring(7);
                    $('.floating-callout-box').append('<div class="floating-callout callout ' + callclass + ' callout-success">\
                    <p>Order Saved!</p>\
                    </div>');

                    console.log(data);

                    setTimeout(function () {
                        callclass = '.' + callclass;
                        $(callclass).fadeOut();
                    }, 3000);
                }
            })
        }
    });

    $('input.floatlabel').floatlabel();
    $(".clickable-row").click(function () {
        window.document.location = $(this).data("href");
    });
    $('#forgot-key-button').click(function () {
        $('#emailattempt').removeClass('hidden');
        $('#inputemail').focus();
    });
    $('select.select2').select2();
});

// toggle bootstrap column width
$(function(){
    $('.toggle-5').click(function(){$(this).closest('.togglecol').toggleClass('col-md-5')});
    $('.toggle-7').click(function(){$(this).closest('.togglecol').toggleClass('col-md-7')});
    $('.toggle-12').click(function(){
        var $target = $(this).closest('.togglecol');
        $target.toggleClass('col-md-12');
        setTimeout(function () {
            $('html, body').animate({
                scrollTop: $target.offset().top
            }, 200);
        },50);
    });
});

$(document).ajaxSuccess(function () {
    $(".clickable-row").click(function () {
        window.document.location = $(this).data("href");
    });
});

// Ticket status ajax update
$(function () {
    $('.statuschange').click(function (e) {
        $this = $(this);
        if($this.hasClass('active')) return;
        var parentdiv = $(this).closest('div');
        var csrf = parentdiv.data('csrf');
        var ajaxurl = parentdiv.data('ajaxurl');
        var ticketid = parentdiv.data('ticketid');
        var statusid = $(this).data('statusid');
        parentdiv.find('span.active').addClass('prev-active').removeClass('active');
        $this.addClass('active');
        ajaxinprogress = true;
        var ajaxobj = $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                '_token': csrf,
                'ticketid': ticketid,
                'statusid': statusid
            }
        });

        ajaxobj.done(function () {
            parentdiv.find('span.prev-active').removeClass('prev-active');
        });

        ajaxobj.fail(function () {
            parentdiv.find('span.active').removeClass('active');
            parentdiv.find('span.prev-active').removeClass('prev-active').addClass('active');
        });

        ajaxobj.always(function () {
            ajaxinprogress = false;
        });
    })
});

// ajax update single text filter

(function ($) {
    $('.ajax-filter').each(function () {
        var ajax_target = $(this).data('ajax_target');
        var output_target = $(this).data('output_target');
        var default_output = $(output_target).html();
        var timeid;
        var ajaxobj;
        $(this).on('input paste', function () {
            $this = $(this);
            var term = $(this).val();
            if (term == '') {
                if (ajaxobj) ajaxobj.abort();
                $(output_target).html(default_output);
            }
            else {
                $(output_target + ' .overlay').remove();
                $(output_target).append('<div class="overlay">\
                    <i class="fa fa-refresh fa-spin"></i>\
                    </div>');
                clearTimeout(timeid);
                timeid = setTimeout(function () {
                    console.log('ajax');
                    ajaxobj = $.ajax({
                        url: ajax_target,
                        method: 'GET',
                        data: {
                            'term': term
                        }
                    });
                    ajaxobj.done(function (data) {
                        if ($this.val() == '') {
                            $(output_target).html(default_output);
                        }
                        else {
                            $(output_target).html(data);
                        }
                    });

                    ajaxobj.fail(function () {
                        if (ajaxobj.statusText != 'abort') {
                            alert('Something went wrong while getting requested data.');
                        }
                    });

                    ajaxobj.always(function () {
                        $(output_target + ' .overlay').remove();
                    });
                }, 500);
            }
        });
    });
}(jQuery));