<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class group_user extends Pivot
{
    use HasFactory;
 





    protected $table = 'group_user';

    // Additional fields or methods specific to the pivot table
}

