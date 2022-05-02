<?php

use Proto\Models\Setting;

/**
 * Get the value of a setting by its key and subkey.
 * @param string $key
 * @param string $subkey
 * @return array|null|string
 */
function setting($key, $subkey)
{
    return Setting::get($key, $subkey)->value;
}