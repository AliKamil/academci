<?php
namespace App\Entity;

/**
 * Class Entity
 * @package App\Entity
 *
 * @author Arthur Dombrovski <a.dombrovskiy@redmond-rus.com>
 * @version 1.0
 */
class Entity
{
    protected $name;

    protected $startDate;

    protected $stopDate;

    /**
     * get name of Entity
     *
     * @return mixed $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets name of Entity
     *
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * get stopDate of Entity
     *
     * @return mixed $stopDate
     */
    public function getStopDate()
    {
        return $this->stopDate;
    }

    /**
     * Sets stopDate of Entity
     *
     * @param \DateTime $stopDate
     * @return $this
     */
    public function setStopDate(\DateTime $stopDate)
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    /**
     * get startDate of Entity
     *
     * @return mixed $startDate
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets startDate of Entity
     *
     * @param \DateTime $startDate
     * @return $this
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }
}