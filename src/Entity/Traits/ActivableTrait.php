<?php


namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait ActivableTrait
{

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active = null;

    public function setActive($active): self
    {
        $this->active = $active;
        return $this;
    }

    public function isActive()
    {
        return $this->active;
    }
}