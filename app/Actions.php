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
        $subquery=\DB::table('prices')
            ->select(\DB::raw('actions_id,
		   DATE(created_at) AS dates,
           MIN(current_quantity) AS min_value,
           MAX(current_quantity) AS max_value,
           MIN(created_at) AS min_created,
           MAX(created_at) AS max_created'))
            ->whereRaw('actions_id='.$value)
            ->groupBy('dates','actions_id')
            ->toSql();
        $query=\DB::table(\DB::raw('('.$subquery.') AS t'))
            ->select('t.dates', 't.min_value','t.max_value',\DB::raw('FIRST_VALUE(price_min.current_quantity) OVER (ORDER BY price_min.created_at DESC) open_value,
                LAST_VALUE(price_max.current_quantity) OVER(ORDER BY price_max.created_at ASC) close_value'))
            ->join('prices AS price_min', 'price_min.created_at', '=', 't.min_created')
            ->join('prices AS price_max', 'price_max.created_at', '=', 't.max_created');
        return $query->get();
    }

}
