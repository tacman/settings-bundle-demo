<?php

namespace App\Settings\User;
use Tzunghaor\SettingsBundle\Attribute\Setting;

#[Setting]
class UserSettings
{
    #[Setting]
    public ?string $nickname = null;

    #[Setting(help: 'Turn on Beta Features')]
    public bool $beta = false;

    public int $heartCount = 3;
}
