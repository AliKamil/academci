<?php

namespace App\Service;

use App\Entity\Term;
use App\Entity\Year;

/**
 * Class EntityFactory
 *
 * @author Arthur Dombrovski <a.dombrovskiy@redmond-rus.com>
 * @version 1.0
 */
class EntityFactory
{
    protected $dateFormat;

    /**
     * EntityFactory constructor.
     * @param string $dateFormat
     */
    public function __construct($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @param array $data
     * @return array
     */
    public function createFromData($data)
    {
        $years = [];
        $prevYear = null;
        foreach ($data as $entry) {
            $year = $this->createEntity($entry);
            if ($prevYear) {
                $prevYear->setStopDate($year->getStartDate());
                $years[] = $prevYear;
            }
            $prevYear = $year;
        }
        $years[] = $prevYear;
        foreach ($years as $year){
        }

        return $years;
    }

    /**
     * @param array $array
     * @return Year
     * @throws \Exception
     */
    protected function createEntity($array)
    {
        if (!$this->checkForKeys($array, ['name', 'start_date', 'term_name', 'terms_dates'])) {
            throw new \Exception('incorrect data');
        }
        if (count($array['terms_dates']) % 2 != 0) {
            throw new \Exception('Number of term_dates must be even!');
        }
        $year = new Year();
        $year->setName($array['name'])
             ->setStartDate($this->getDate($array['start_date']));
        while ($term_dates = array_splice($array['terms_dates'], 0, 2)) {
            $term = new Term();
            $term->setName($array['term_name'])
                 ->setStartDate($this->getDate($term_dates[0]))
                 ->setStopDate($this->getDate($term_dates[1]));
            $year->addTerm($term);
        }

        return $year;
    }

    /**
     * @param $array
     * @param $keys
     * @return bool
     */
    protected function checkForKeys($array, $keys)
    {
        return count(array_intersect_key(array_flip($keys), $array)) === count($array);
    }

    /**
     * @param $date
     * @return \DateTime
     * @throws \Exception
     */
    protected function getDate($date)
    {
        $date = \DateTime::createFromFormat($this->dateFormat, $date);

        if (!$date) {
            throw new \Exception('Error creating date');
        }

        return $date;
    }
}