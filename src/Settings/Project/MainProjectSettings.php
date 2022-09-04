<?php

namespace App\Settings\Project;

/**
 * Main Settings of Project
 */
class MainProjectSettings
{
    /**
     * Budget
     *
     * Given in dollars, we don't care about cents.
     */
    public int $budget = 0;


    public ?\DateTime $deadline = null;
}