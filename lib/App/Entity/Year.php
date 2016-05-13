<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Year
 * @package App\Entity
 *
 * @author Arthur Dombrovski <a.dombrovskiy@redmond-rus.com>
 * @version 1.0
 */
class Year extends Entity
{
    protected $terms;

    public function __construct()
    {
        $this->terms = new ArrayCollection();
    }


    /**
     * get terms of Year
     *
     * @return ArrayCollection $terms
     */
    public function getTerms()
    {
        return $this->terms;
    }

    /**
     * Sets terms of Year
     *
     * @param Term $term
     * @return $this
     */
    public function addTerm(Term $term)
    {
        $this->checkTermsIntersection($term);
        if (!$this->terms->contains($term)) {
            $this->terms->add($term);
        }

        return $this;
    }

    /**
     * Removes term from collection
     * @param Term $term
     * @return $this
     */
    public function removeTerm(Term $term)
    {
        $this->terms->removeElement($term);

        return $this;
    }

    protected function checkTermsIntersection($term)
    {
        foreach ($this->terms as $existingTerm) {
            if ($existingTerm->getStartDate() <= $term->getStopDate() && $existingTerm->getStopDate() >= $term->getStartDate()) {
                throw new \Exception('term dates overlap');
            }
        }

    }

    public function belongs(\DateTime $date){
        return ($date >= $this->getStartDate() && (is_null($this->getStopDate()) || $date <= $this->getStopDate()));
    }

    public function getTerm(\DateTime $date)
    {
        foreach ($this->terms as $term) {
            if ($date >= $term->getStartDate() && $date <= $term->getStopDate()) {
                return $term;
            }
        }
    }
}

