<?php

namespace App\Entity;

use App\Entity\Interfaces\TimestampedInterface;
use App\Entity\Traits\ActivableTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\JsonDataTrain;
use App\Entity\Traits\KeywordTrain;
use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 * @ORM\EntityListeners({
 *  "App\Listener\Entity\TimestampedListener",
 * })
 */

class Project implements TimestampedInterface
{

    use IdTrait;
    use JsonDataTrain;
    use TimestampableTrait;
    use KeywordTrain;
    use ActivableTrait;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="cover_image", type="string", length=2048, nullable=true)
     */
    private $coverImage;

    /**
     * @var bool
     *
     * @ORM\Column(name="main_project", type="boolean", nullable=true)
     */
    private $mainProject = null;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setMainProject($mainProject): self
    {
        $this->mainProject = $mainProject;
        return $this;
    }

    public function isMainProject()
    {
        return $this->mainProject;
    }

    /**
     * @return mixed
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * @param mixed $coverImage
     */
    public function setCoverImage($coverImage): self
    {
        $this->coverImage = $coverImage;
        return $this;
    }

}