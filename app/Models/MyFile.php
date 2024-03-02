<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyFile extends Model
{

    
    use HasFactory;
     protected $fillable = [
        'link',
        'status',
        'group_id',
        'file_name'
        
    ];
        public function group()
    {
        return $this->belongsTo(Group::class);
    }



    // public function users()
    // {
    //     return $this->belongsToMany(User::class, 'file_user')->withPivot('role')->withTimestamps();
    // }
    public function users()
    {
        return $this->belongsToMany(User::class, 'file_user', 'file_id', 'user_id')->withPivot('role')->withTimestamps();
    }

    public function getReportByUserId($userId)
    {
        return $this->users()
            ->where('user_id', $userId)
            //->select('file_user.*', 'my_files.*') // Add other columns you want to select
            ->get();
    }

}
