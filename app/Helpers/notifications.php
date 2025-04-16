<?php

if (!function_exists('showNotification')) {
    function showNotification($type, $message)
    {
        session()->flash('notification', [
            'type' => $type,
            'message' => $message
        ]);
    }
}
