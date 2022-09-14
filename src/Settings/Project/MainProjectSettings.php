<?php

namespace App\Settings\Project;

use Tzunghaor\SettingsBundle\Attribute\Setting;

/**
 * Main Settings of Project
 */
class MainProjectSettings
{

    #[Setting(help: 'Receive updates from this project')]
    public string $emailFrequency = 'weekly';

    #[Setting(help: 'Add To Quick Links')]
    public bool $isFavorite = false;

}
