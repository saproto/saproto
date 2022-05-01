<?php

namespace Proto\Models;

class Setting
{
    /**
     * @param string $key
     * @param string $subkey
     * @param string|array $value
     * @return HashMapItem
     */
    public static function create($key, $subkey, $value)
    {
        return HashMapItem::create(['key' => $key, 'subkey' => $subkey, 'value' => $value]);
    }

    /**
     * @param string $key
     * @param string $subkey
     * @param string|array $value
     * @return HashMapItem
     */
    public static function update($key, $subkey, $value)
    {
        $value = is_array($value) ? json_encode(array_filter($value)) : $value;
        $setting = HashMapItem::where('key', $key)->where('subkey', $subkey)->first();
        $setting->value = $value;
        $setting->update();
        return $setting;
    }

    /**
     * @param string $key
     * @param string $subkey
     * @return object
     */
    public static function get($key, $subkey)
    {
        $config = config("proto.settings.$key.$subkey");
        if ($config == null) {
            abort(404, "Setting $key->$subkey could not be found.");
        }

        $setting = HashMapItem::where('key', $key)->where('subkey', $subkey)->first();
        if ($setting == null) {
            $setting = self::create($key, $subkey, config("proto.settings.$key.$subkey.default"));
        } elseif ($setting->value == '[]') {
            $setting = self::update($key, $subkey, config("proto.settings.$key.$subkey.default"));
        }

        if ($config['type'] == 'list') {
            $value = json_decode($setting->value);
            $default = json_decode($config['default']);
        }

        return (object) [
            'id' => $setting->id,
            'type' => $config['type'],
            'value' => $value ?? $setting->value,
            'default' => $default ?? $config['default'],
        ];
    }

    /**
     * @return array
     */
    public static function all()
    {
        $settings = [];
        foreach(config('proto.settings') as $key => $subkeys) {
            foreach($subkeys as $subkey => $config) {
                $settings[$key][$subkey] = self::get($key, $subkey);
            }
        }

        return $settings;
    }
}
