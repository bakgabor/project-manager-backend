<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait KeywordTrain
{

    /**
     * @ORM\Column(name="keywords", type="text", nullable=true)
     */
    private $keywords;

    /**
     * @return mixed
     */
    public function getKeywords()
    {
        return explode(",", $this->keywords);
    }

    /**
     * @param mixed $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = '';
        foreach ($keywords as $item) {
            $this->keywords .= $item . ',';
        }
        $this->keywords = substr($this->keywords, 0, -1);
        return $this;
    }

}