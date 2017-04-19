/**
 * Created by VictorDavid on 15/01/2017.
 */
$(function(){
    console.log("Iniciando configuraciónes " + new Date().toLocaleString());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    console.log("Configuraciónes Terminadas " + new Date().toLocaleString());
});

var ajaxSetUp={
    disableToken:function(){
        delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
    }
    ,
    enableToken:function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }
};