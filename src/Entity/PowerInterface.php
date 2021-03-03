<?php

namespace App\Entity;

interface PowerInterface
{
    public function setPassive(bool $passive): self;

    public function isPassive(): bool;

    public function setEffects(array $effect): self;

    public function getEffects(): ?array;

    public function hasEffects(): bool;

    public function setConditions(array $conditions): self;

    public function getConditions(): ?array;

    public function setExternalConditions(array $externalConditions): self;

    public function getExternalConditions(): ?array;

    public function hasExternalConditions(): bool;

    public function setPrerequisities(array $prerequisities): self;

    public function getPrerequisities(): ?array;
}
