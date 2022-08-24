<?php

namespace App\Settings;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class SiteSettings
{
    #[Setting]
    public string $version = "1.0.0";

    #[Setting]
    public string $title = "(title)";

    #[Setting]
    public bool $beta_features = false;

//    #[Setting(enum: ['left','right','top','bottom'])]
}
