<?php

namespace App\Models;

use App\Library\Constantes;
use App\Library\SendMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Track extends Model
{
    /**
     * @var string
     */
    protected $table = 'tracks';

    /**
     * @var array
     */
    protected $fillable = [
        'title', 'duration', 'file','author_id','albume_id','description','status_id','sketch','remote_repository',
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\Author');
    }

    public function albume()
    {
        return $this->belongsTo('App\Models\albume');
    }

    

}
