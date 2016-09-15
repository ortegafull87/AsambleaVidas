<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    //
	protected $table = 'Tracks';

	public function author(){
		return $this->belongsTo('App\Models\Author');
	}

	public function albume(){
		return $this->belongsTo('App\Models\albume');
	}

}
