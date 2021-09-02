<?php

namespace JulesGraus\Actionlogs\Contracts;

interface ActionlogResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request);
}
