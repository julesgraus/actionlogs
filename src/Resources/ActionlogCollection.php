<?php


namespace JulesGraus\Actionlogs\Resources;


use Illuminate\Http\Resources\Json\ResourceCollection;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;
use \JulesGraus\Actionlogs\Contracts\ActionlogCollection as ActionlogResourceCollectionContract;
use function app;

class ActionlogCollection extends ResourceCollection implements ActionlogResourceCollectionContract
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
