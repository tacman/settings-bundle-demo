<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Settings
{
    public array $settings = [];
    public bool $isAdmin=false;
}
