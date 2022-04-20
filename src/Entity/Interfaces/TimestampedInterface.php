<?php

namespace App\Entity\Interfaces;

interface TimestampedInterface
{
    public function getInsertedAtTime(): int;

    public function setInsertedAtTime(int $insertedAtTime);

    public function getUpdatedAtTime(): ?int;

    public function setUpdatedAtTime(?int $updatedAtTime);

    public function getInsertedAtDate(): \Datetime;

    public function setInsertedAtDate(\Datetime $insertedAtDate): void;

    public function getUpdatedAtDate(): ?\Datetime;

    public function setUpdatedAtDate(\Datetime $updatedAtDate): void;
}
