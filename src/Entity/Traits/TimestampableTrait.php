<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{

    /**
     * @var int
     * @ORM\Column(name="insert_time", type="bigint", nullable=true)
     */
    private $insertedAtTime;

    /**
     * @var int
     * @ORM\Column(name="update_time", type="bigint", nullable=true)
     */
    private $updatedAtTime;

    /**
     * @var \Datetime
     * @ORM\Column(name="insert_date", type="datetime", nullable=true)
     */
    private $insertedAtDate;

    /**
     * @var \Datetime
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    private $updatedAtDate;

    public function setInsertedAtTime(int $insertedAtTime)
    {
        $this->insertedAtTime = $insertedAtTime;

        return $this;
    }

    public function getInsertedAtTime(): int
    {
        return $this->insertedAtTime;
    }

    public function setUpdatedAtTime(?int $updatedAtTime)
    {
        $this->updatedAtTime = $updatedAtTime;

        return $this;
    }

    public function getUpdatedAtTime(): ?int
    {
        return $this->updatedAtTime;
    }

    /**
     * @return \Datetime
     */
    public function getInsertedAtDate(): \Datetime
    {
        return $this->insertedAtDate;
    }

    /**
     * @param int $insertedAtDate
     */
    public function setInsertedAtDate(\Datetime $insertedAtDate): void
    {
        $this->insertedAtDate = $insertedAtDate;
    }

    /**
     * @return \Datetime
     */
    public function getUpdatedAtDate(): ?\Datetime
    {
        return $this->updatedAtDate;
    }

    /**
     * @param int $updatedAtDate
     */
    public function setUpdatedAtDate(\Datetime $updatedAtDate): void
    {
        $this->updatedAtDate = $updatedAtDate;
    }

}
