<?php

namespace App\Models;

use App\Models\City;
use App\Models\Child;
use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'parents';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'country_id',
        'birth_date',
        'age',
        'state_id',
        'city_id',
        'residential_proof',
        'profile_image',
        'education',
        'occupation'
    ];

    protected $casts = [
        'residential_proof' => 'array',
    ];

    public function children()
    {
        return $this->belongsToMany(Child::class, 'child_parent', 'parent_id', 'child_id');
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
