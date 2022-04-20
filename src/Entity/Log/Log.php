<?php


namespace App\Entity\Log;


use App\Entity\Interfaces\TimestampedInterface;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\JsonDataTrain;
use App\Entity\Traits\TimestampableTrait;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="app_log")
 * @ORM\Entity()
 * @ORM\EntityListeners({
 *  "App\Listener\Entity\TimestampedListener",
 * })
 */

class Log implements TimestampedInterface
{

    use IdTrait;
    use JsonDataTrain;
    use TimestampableTrait;

}