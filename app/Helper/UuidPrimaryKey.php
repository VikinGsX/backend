<?php
/**
 * Created by PhpStorm.
 * User: Soros
 * Date: 2019/12/12
 * Time: 上午 07:51
 */

namespace App\Helper;

use Ramsey\Uuid\Uuid;

trait UuidPrimaryKey
{
   // public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static ::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

}