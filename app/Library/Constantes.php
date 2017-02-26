<?php
/**
 * Created by PhpStorm.
 * User: VictorDavid
 * Date: 13/10/2016
 * Time: 11:11 PM
 */

namespace App\Library;


class Constantes
{
    const USER_CREATED = 1;
    const USER_ACTIVE = 3;
    const USER_INACTIVE = 4;

    const STATUS_CREATED = 1;
    const STATUS_VALID = 2;
    const STATUS_ACTIVE = 3;
    const STATUS_INACTIVE = 4;
    const STATUS_DELETED = 5;
    const STATUS_AUDITED = 6;

    public static $ALBUME_GENRE = [
        [
            'id'=> 1,
            'genre' => 'Nuevos',
            'description' => 'Audios nuevos aun sin revisar',
            'icon' => 'fa fa-music',
            'count' => 0
        ]
        ,
        [
            'id'=> 2,
            'genre' => 'Pendientes',
            'description' => 'Audios por revisar.',
            'icon' => 'fa fa-exclamation',
            'count' => 0
        ]
        ,
        /*[
            'id'=> 3,
            'genre' => 'Revisados',
            'description' => 'Audios revisados recientemente.',
            'icon' => 'fa fa-history',
            'count' => 0
        ],*/
        [
            'id'=> 4,
            'genre' => 'Inactivos',
            'description' => 'Audios actualmente inactivos.',
            'icon' => 'fa fa-microphone-slash',
            'count' => 0
        ],
        [
            'id'=> 6,
            'genre' => 'Auditados',
            'description' => 'Audios en estado de auditoria.',
            'icon' => 'fa fa-ban',
            'count' => 0
        ],
    ];
}