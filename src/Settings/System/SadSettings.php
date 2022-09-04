<?php

namespace App\Settings\System;

use App\Settings\Section;

#[Section]
class SadSettings extends AbstractBaseSettings
{
    public $reason = 'nothing';
}
