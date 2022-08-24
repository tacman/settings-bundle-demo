<?php

namespace App\Settings;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class SiteSettings
{
    #[Setting]
    public string $version = "1.0.0";

    #[Setting('Tagline', help: "The company slogan")]
    public ?string $tagline = null;

    public string $title = "(title)";

    #[Setting]
    public bool $beta_features = false;

//    #[Setting(enum: ['left','right','top','bottom'])]
}
