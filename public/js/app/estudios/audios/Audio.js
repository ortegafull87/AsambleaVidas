/**
 * Created by VictorDavid on 12/01/2017.
 */
var Audio = {
    _self: null,
    TIME_COUNT_PLAYED: 3.0,
    LAST_PAGE: 0,
    SPINNER: '<div class="spiner"><span class="fa fa-2x fa-spinner fa-spin"></span></div>',
    ajaxDone:true,
    _init: function () {
        _self = Audio;
        _self.events();
        _self.LAST_PAGE = $("div.track-box-container").data('lastp');
    },

    events: function () {
        // Abre las opciones para compartir
        $(document).on('click', '.share div a[name="share"]', function (object) {
            object.preventDefault();
            $(object.target)
                .parents('.box')
                .children('.option-share')
                .addClass('option-share-up');
        });

        //Cierra las opciones para compartir
        $(document).on('click', 'div.option-share span.fa-times, div.option-share div.option a', function (object) {
            $(object.target)
                .parents('.option-share')
                .removeClass('option-share-up');
        });
        //Listener para las estrellas rating.
        $(document).on('click', 'div.rate a', function (object) {
            object.preventDefault();
            Audio.setRate(object);
        });
        //Listener para favoritos
        $(document).on('click', 'div.box div.flag i.fa', function (object) {
            object.preventDefault();
            Audio.toggleFavorite(object);
        });//Listener

        $(document).on('click', 'div.toggle-favorite i', function (object) {
            Audio.toggleFavorite(object);
        });
        //Listener para registrar en un toast
        $(document).on('click', 'button.registrar', function () {
            var url = $('body').data('base');
            window.location.href = url + 'register';
        });

        $('audio').bind('play', function (object) {
            var id = $(object.target).attr('id');
            var currentTime = $(object.target).prop('currentTime');
            var url = $(object.target).data('url');
            if (currentTime < Audio.TIME_COUNT_PLAYED) {
                AudioService.set.listened(url, function (data) {
                    console.info(data);
                });
            }
        });

        $(document).on('click', '#btn_post', function (object) {
            Audio.setPost(object);
        });

        $(window).scroll(function () {
            if ($(this).scrollTop() === ($(document).height() - $(window).height())) {
                if(_self.ajaxDone) {
                    Audio.getTrackPerPage();
                }
            }
        });
    }
    ,
    /**
     *
     * @param selector
     */
    onSpinner: function (selector) {
        if (!$('.spiner').length > 0) {
            $(selector).append(_self.SPINNER);
            _self.ajaxDone = false;
        }
    }
    ,
    /**
     *
     * @param selector
     */
    offSpinner: function (selector) {
        $('.spiner').remove();
        _self.ajaxDone = true;
    }
    ,
    /**
     *
     * @param object
     */
    toggleFavorite: function (object) {
        var url = $(object.target).parent().data('url');
        var title = $(object.target).parent().data('titulo');
        AudioService.set.favorite(url, function (xhr) {
            var response = JSON.parse(xhr.responseText);
            switch (response.data.idEstatus) {
                case 3:
                    $(object.target).addClass('favorite');
                    $('.tell-favorite').html('Sí');
                    break;
                case 4:
                    $(object.target).removeClass('favorite');
                    $('.tell-favorite').html('No');
                    break;
                default:
                    console.log(response);
                    break;
            }
            $.toast({
                heading: response.message,
                text: title,
                position: 'mid-center',
                stack: false,
                icon: 'info'
            });//toast

        });
    }
    ,
    /**
     *
     */
    getTrackPerPage: function () {
        var currentPage = $('#hdn_currentPage');
        if (currentPage.val() <= _self.LAST_PAGE) {
            AudioService.ajax.get.trakPerPage(currentPage.val(), function (xhr) {
                $('.track-box-container').append(xhr.view);
                currentPage.val((parseInt(currentPage.val())) + 1);
            });
        }
    }
    ,
    /**
     *
     * @param object
     */
    setRate: function (object) {

        var title = $(object.target).parents('.rate').data('titulo');
        var url = $(object.target).parents('.rate').data('url');
        var rate = $(object.target).parent().attr('id');
        url = url.replace(':rate', rate);

        AudioService.set.rate(url, function (response) {
            if (response != undefined) {
                $.toast({
                    heading: title,
                    text: response.message,
                    position: 'mid-center',
                    stack: false,
                    icon: 'info'
                });//toast
            }//if
        });//AudioService
    }
    ,
    /**
     *
     * @param object
     */
    setPost: function (object) {
        var post = $('input#txt_post');
        var url = post.data('url');
        var data = {
            "comment": post.val(),
            "postTrackParentId": 0,
        };
        AudioService.set.post(url, data, function (xhr) {
            if (xhr != null) {
                var response = JSON.parse(xhr.responseText);
                $('.comments').prepend(response.view);
                post.val('');
            }//if
        });//AudioService
    }
};

$(document).ready(Audio._init);