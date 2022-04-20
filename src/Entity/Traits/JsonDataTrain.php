<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait JsonDataTrain
{

    /**
     * @ORM\Column(name="json_data", type="text", nullable=true)
     */
    private $jsonData;

    /**
     * @return array|null
     */
    public function getJsonData()
    {
        return json_decode($this->jsonData);
    }

    /**
     * @param array|null $brand
     * @return JsonDataTrain
     */
    public function setJsonData(?array $jsonData): self
    {
        $this->jsonData = json_encode($jsonData);
        return $this;
    }

}