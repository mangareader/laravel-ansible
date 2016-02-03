<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/1/16
 * Time: 1:39 PM
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    protected $table = "templates";

    public function getRolesAttribute($value)
    {
        return explode(",", $value);
    }

    public function setRolesAttribute($value)
    {
        if (is_array($value))
            $this->attributes['roles'] = implode(",", $value);
        else
            $this->attributes['roles'] = $value;
    }
}