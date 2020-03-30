<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actions extends Model
{
    protected $table='actions';
    protected $fillable=['name','unique_code','description','logo'];
    public function price()
    {
        return $this->hasMany('App\Price');
    }
    public function Candle($value)
    {

    }

}
