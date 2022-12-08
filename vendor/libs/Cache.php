<?php

namespace vendor\libs;

class Cache
{

    public function set($key, $data, $seconds = 3600): bool
    {
        $content['data'] = $data;
        $content['end_time'] = time() + $seconds;

        if (file_put_contents(CACHE . '/' . hash('md5', $key) . '.txt', serialize($content))) {
            return true;
        }

        return false;
    }

    public function get($key)
    {
        $file = CACHE . '/' . hash('md5', $key) . '.txt';
        if (file_exists($file)) {
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) {
                return $content['data'];
            }
            unlink($file);
        }

        return false;
    }
}