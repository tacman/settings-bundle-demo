<?php

namespace App\Settings\System;
use Tzunghaor\SettingsBundle\Attribute\Setting;

class BoxSettings
{
    /**
     * @var int
     */
    #[Setting(dataType: 'int')]
    public $padding = 0;

    /**
     * @var string[]
     */
    #[Setting(enum: ['left','right','top','bottom'])]
    public $borders = [];
}
