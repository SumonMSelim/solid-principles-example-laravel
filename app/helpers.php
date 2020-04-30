<?php

if (!function_exists('notify_success')) {
    function notify_success($message)
    {
        session()->flash('type', 'success');
        session()->flash('message', $message);
    }
}

if (!function_exists('notify_error')) {
    function notify_error($message)
    {
        session()->flash('type', 'danger');
        session()->flash('message', $message);
    }
}
