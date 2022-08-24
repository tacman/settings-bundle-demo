<?php

namespace App\Settings;

use Tzunghaor\SettingsBundle\Attribute\Setting;

abstract class AbstractBaseSettings
{
    #[Setting(label: 'Public Name')]
    public string $name = 'baba';

    #[Setting('Private address')]
    private $address = 'yaga';

    /**
     * The minimum
     *
     * This is the minimum description
     */
    #[Setting(label: 'Minimum number of something', help: 'description or help?')]
    protected $minimum = 10;

    /**
     * The maximum
     *
     * This is the maximum description
     */
    #[Setting("Abstract Max", formOptions: ['attr'=> ['class'=> 'max']])]
    protected $maximum = 20;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return int
     */
    public function getMinimum(): int
    {
        return $this->minimum;
    }

    /**
     * @param int $minimum
     */
    public function setMinimum(int $minimum): void
    {
        $this->minimum = $minimum;
    }

    /**
     * @return int
     */
    public function getMaximum(): int
    {
        return $this->maximum;
    }

    /**
     * @param int $maximum
     */
    public function setMaximum(int $maximum): void
    {
        $this->maximum = $maximum;
    }
}
