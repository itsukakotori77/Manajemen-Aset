<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'roles';
    protected $primaryKey = 'id';

    // Function 
    public function user()
    {
        return $this->hasOne(User::class, 'role_id');
    }
}
