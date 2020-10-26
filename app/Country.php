<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'slug', 'code', 'name_code'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states(){
        return $this->hasMany(State::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities(){
        return $this->hasMany(City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function zipcodes(){
        return $this->hasManyThrough('App\Zipcode', 'App\City');
    }

    /**
     * Set the countries name code
     *
     * @param  string  $value
     * @return void
     */
    public function setNameCodeAttribute($value)
    {
        $this->attributes['name_code'] = strtoupper($value);
    }
}
