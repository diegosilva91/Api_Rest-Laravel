<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    //
    protected $fillable=['current_quantity','actions_id'];
    public function actions()
    {

        return $this->belongsTo('App\Actions');
    }

}
