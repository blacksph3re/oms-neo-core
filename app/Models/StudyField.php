<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyField extends Model
{
    protected $table = "study_fields";

    // Relationships..
	public function recrutedUser() {
        return $this->hasMany('App\Models\RecrutedUser');
    }

    public function user() {
    	return $this->hasMany('App\Models\User');
    }

    // Model methods go down here..
}
