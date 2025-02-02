<?php

namespace App\Model;

class Project implements \Stringable
{
    private int $id;

    private string $name;

    private string $owner;

    public function __construct(int $id, string $name, string $owner)
    {
        $this->id = $id;
        $this->name = $name;
        $this->owner = $owner;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    public function __toString(): string
    {
        return sprintf('%s (%s)', $this->getName(), $this->getOwner());
    }
}
