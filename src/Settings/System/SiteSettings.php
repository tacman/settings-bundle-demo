<?php

namespace App\Settings\System;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class SiteSettings
{
    #[Setting]
    public string $version = "1.0.0";

    #[Setting('Tagline', help: "A site for Joksters")]
    public ?string $tagline = null;

    #[Setting('Branch', help: "Repository Branch")]
    public ?string $branch = null;

    public string $title = "(title)";

    #[Setting]
    public bool $beta_features = false;

//    #[Setting(enum: ['left','right','top','bottom'])]
}
