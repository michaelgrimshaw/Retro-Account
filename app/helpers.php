<?php

/**
 * Get the authenticated user instance
 *
 * @return \Illuminate\Contracts\Auth\Authenticatable|null
 */
function user()
{
    if (request()->routeIs('admin*')) {
        return auth()->guard('admin')->user();
    }

    return auth()->guard('portal')->user();
}

/**
 * formats values to display as money
 *
 * @return string
 */
function format_money($value)
{
    return '£' . number_format($value, 2);
}
