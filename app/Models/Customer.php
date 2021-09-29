<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name','email', 'age', 'date', 'address', 'gender' ,'city_id', 'number', 'customerGroupID', 'stockBroker', 'AccountNumber', 'routesOfKnownID', 'createdBy','updatedBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
    
    public function customerCity(){
        return $this->hasOne('App\Models\City','id','city_id')
                    ->where('isActive','Y')
                    ->where('isApproved','Y');
    }

    public function customerGroup(){
        return $this->hasOne('App\Models\Customergroup','id','customerGroupID')
                    ->where('isActive','Y')
                    ->where('isApproved','Y');
    }

    public function customerRouteKnown(){
        return $this->hasOne('App\Models\Routeknown','id','routesOfKnownID')
                    ->where('isActive','Y')
                    ->where('isApproved','Y');
    }
}
