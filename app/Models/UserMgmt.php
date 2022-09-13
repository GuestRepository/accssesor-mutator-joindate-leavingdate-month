<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserMgmt extends Model
{
    use HasFactory;

    protected $fillable =['name','email','date_of_joining','date_of_leaving','still_working_status','avatar'];

    public function getToatalExpAttribute($value)
    {
        if($this->attributes['still_working_status'] == 1){
            $years = Carbon::parse($this->attributes['date_of_joining'])->diff(Carbon::now())->format('%y years, %m months and %d days');

        }
        else{
        $years = Carbon::parse($this->attributes['date_of_joining'])->diff($this->attributes['date_of_leaving'])->format('%y years, %m months and %d days');

        }
        return $years;
        // 
    }
}
