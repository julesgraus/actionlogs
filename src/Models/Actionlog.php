<?php


namespace JulesGraus\Actionlogs\Models;


use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;
use JulesGraus\Actionlogs\Tests\Artifacts\SampleUser;
use JulesGraus\Utilities\Casts\JsTimeStamp;
use RuntimeException;

/**
 * Class ActionLog
 *
 * @mixin Model
 * @property Authenticatable $user
 * @property string $action
 * @property mixed $payload
 *
 * @package JulesGraus\Actionlogs
 */
class Actionlog extends Model implements ActionlogContract
{
    protected $fillable = ['action', 'payload'];

    public function user(): BelongsTo {
        return $this->belongsTo(SampleUser::class);
    }

    public function setPayloadAttribute(mixed $value) {
        if(is_resource($value)) throw new RuntimeException('The payload attribute can be any type except resource');
        $this->attributes['payload'] = serialize($value);
    }

    public function getPayloadAttribute() {
        return unserialize($this->attributes['payload']);
    }
}
