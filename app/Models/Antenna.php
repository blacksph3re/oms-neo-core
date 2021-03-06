<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antenna extends Model
{
    protected $table = "antennas";

    // Relationships..
    public function country() {
    	return $this->belongsTo('App\Models\Country');
    }

    public function user() {
    	return $this->hasMany('App\Models\User');
    }

    // Model methods go down here..
    public function getFiltered($search = array(), $onlyTotal = false) {
    	$antennae = $this->with('country');

    	// Filters here..
    	if(isset($search['name']) && !empty($search['name'])) {
            $antennae = $antennae->where('name', 'LIKE', "%".$search['name']."%");
        }

        if(isset($search['city']) && !empty($search['city'])) {
            $antennae = $antennae->where('city', 'LIKE', "%".$search['city']."%");
        }

        if(isset($search['country_id']) && !empty($search['country_id'])) {
            $antennae = $antennae->where('country_id', $search['country_id']);
        }
    	// END filters..

    	if($onlyTotal) {
    		return $antennae->count();
    	}

    	// Ordering..
    	$sOrder = (isset($search['sord']) && ($search['sord'] == 'asc' || $search['sord'] == 'desc')) ? $search['sord'] : 'asc';
    	if(isset($search['sidx'])) {
			switch ($search['sidx']) {
				case 'name':
                case 'city':
                case 'email':
                case 'address':
				case 'phone':
					$antennae = $antennae->orderBy($search['sidx'], $search['sord']);
					break;

				default:
					$antennae = $antennae->orderBy('name', $search['sord']);
					break;
			}
    	}

		if(!isset($search['noLimit']) || !$search['noLimit']) {
			$limit 	= !isset($search['limit']) || empty($search['limit']) ? 10 : $search['limit'];
			$page 	= !isset($search['page']) || empty($search['page']) ? 1 : $search['page'];
			$from 	= ($page - 1)*$limit;
			$antennae = $antennae->take($limit)->skip($from);
		}

		return $antennae->get();
    }
}
