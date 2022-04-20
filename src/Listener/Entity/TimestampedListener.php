<?php
namespace App\Listener\Entity;

use App\Entity\Interfaces\TimestampedInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;

class TimestampedListener
{

    /**
     * @ORM\PrePersist
     */
    public function prePersistHandler(TimestampedInterface $entity): void
    {
        $time = time();
        $entity->setInsertedAtTime($time);
        $entity->setUpdatedAtTime($time);
        $entity->setInsertedAtDate(new \Datetime());
        $entity->setUpdatedAtDate(new \Datetime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdateHandler(TimestampedInterface $entity): void
    {
        $time = time();
        $entity->setUpdatedAtTime($time);
        $entity->setUpdatedAtDate(new \Datetime());
    }
}
