<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
  //protected $guarded = ['user_id']; //不允许修改

  //protected $hidden = ['age']; //结果集中不显示

  //public $timestamps = false; //关闭created_at,updated_at检查
}  
