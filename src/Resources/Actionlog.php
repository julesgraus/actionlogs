<?php

namespace JulesGraus\Actionlogs\Resources;

use JulesGraus\Actionlogs\Contracts\ActionlogResource as ActionlogResourceContract;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Actionlog
 *
 * @mixin Actionlog
 * @package JulesGraus\Actionlogs
 */
class Actionlog extends JsonResource implements ActionlogResourceContract
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->whenLoaded('user', $this->user),
            'display_user' => $this->whenLoaded('user', function () {
                if(!$this->user) return __('actionlogs::common.anonymous');
                return implode(' ', [$this->user->first_name, $this->user->last_name]);
            }),
            'created_at' => $this->created_at,
            'action' => $this->action,
            'payload' => $this->payload
        ];
    }
}
