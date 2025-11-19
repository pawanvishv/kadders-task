<?php

namespace App\Models;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Child extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_id',
        'birth_date',
        'age',
        'state_id',
        'city_id',
        'birth_certificate'
    ];

    public function parent()
    {
        return $this->belongsToMany(ParentModel::class, 'child_parent', 'child_id', 'parent_id');
    }


    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
