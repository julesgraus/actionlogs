<?php

namespace JulesGraus\Actionlogs\Contracts;

use Illuminate\Http\Request;

interface ActionlogCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request);
}
