<?php
namespace App\Entity;

/**
 * Class Term
 * @package App\Entity
 *
 * @author Arthur Dombrovski <a.dombrovskiy@redmond-rus.com>
 * @version 1.0
 */
class Term extends Entity
{
    public function getLength()
    {
       return $this->getStartDate()->diff($this->getStopDate());
    }
}