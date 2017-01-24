/**
 * Created by VictorDavid on 12/01/2017.
 */
var Audio = {
    _self: null,
    _init: function () {
        _self = Audio;
        _self.events();
    },

    events: function () {
        // Abre las opciones para compartir
        $(document).on('click', '.share div a', function (object) {
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
            Audio.toggleFavorite(object);
        });//Listener

        //Listener para registrar en un toast
        $(document).on('click', 'button.registrar', function () {
            var url = $('body').data('base');
            window.location.href = url + 'register';
        });
    },
    /**
     *
     * @param object
     */
    toggleFavorite: function (object) {
        var url = $(object.target).parent().data('url');
        var title = $(object.target).parent().data('titulo');
        AudioService.set.favorite(url, function (xhr) {
            var response = JSON.parse(xhr.responseText);
            console.debug(response);
            switch (response.data.idEstatus) {
                case 3:
                    $(object.target).addClass('favorite');
                    break;
                case 4:
                    $(object.target).removeClass('favorite');
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
};

$(document).ready(Audio._init);