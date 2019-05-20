<?php

namespace App\Http\Request;

class Request extends \Illuminate\Http\Request
{
    /**
     * override
     */
    public function expectsJson()
    {
        return true;
    }

    /**
     * override
     */
    public function wantsJson()
    {
        return true;
    }
}
