<?php

namespace App\Settings\User;
use Tzunghaor\SettingsBundle\Attribute\Setting;

#[Setting(help: "Site-wide user-specific settings")]
class UserSettings
{
    #[Setting]
    public ?string $nickname = null;

    #[Setting(help: 'Turn on Beta Features')]
    public bool $beta = false;

    #[Setting(help: 'Set Vacation Mode')]
    public bool $onVacation = false;

    #[Setting(help: 'Return from Vacation, auto-restart after this date', formOptions: ['required' => false])]
    public ?\DateTime $vacationReturn = null;
}
