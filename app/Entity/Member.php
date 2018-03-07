<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //

    protected $table = 'members';  //对应数据库表名

    protected $primaryKey = 'id';  //对应表的主键, 表默认id主键则可省略
}
