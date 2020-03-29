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
		   date(created_at) as date,
           MIN(current_quantity) as min_value,
           MAX(current_quantity) as max_value,
           MIN(created_at) as min_created,
           MAX(created_at) as max_created'))
            ->whereRaw('actions_id='.$value)
            ->groupBy('date','actions_id')
            ->toSql();
        $query=\DB::table(\DB::raw('('.$subquery.') as t'))
            ->select(\DB::raw('t.date, t.min_value,t.max_value,
                first_value(price_min.current_quantity) over(PARTITION BY date(price_min.created_at) ORDER BY price_min.`created_at` desc) as open_value,
                last_value(price_max.current_quantity) over(PARTITION BY date(price_max.created_at) ORDER BY price_min.`created_at` asc) as close_value
            '))
            ->join('prices as price_min', 'price_min.created_at', '=', 't.min_created')
            ->join('prices as price_max', 'price_max.created_at', '=', 't.max_created');
        return $query->get();
    }

}
