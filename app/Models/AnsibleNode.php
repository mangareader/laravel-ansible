<?php
/**
 * Created by PhpStorm.
 * User: hieunt
 * Date: 2/2/16
 * Time: 1:34 PM
 */
namespace App\Models;
class AnsibleNode extends \Hoa\Websocket\Node
{
    protected $_jobjd = null;

    public function setJobID($jobjd)
    {
        $old = $this->_jobjd;
        $this->_jobjd = $jobjd;

        return $old;
    }

    public function getJobID()
    {
        return $this->_jobjd;
    }
}