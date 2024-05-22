<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Subscriber
 *
 * @property int $id
 * @property string $name
 * @property string $chat_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Subscriber newModelQuery()
 * @method static Builder|Subscriber newQuery()
 * @method static Builder|Subscriber query()
 * @method static Builder|Subscriber whereChatId($value)
 * @method static Builder|Subscriber whereCreatedAt($value)
 * @method static Builder|Subscriber whereId($value)
 * @method static Builder|Subscriber whereName($value)
 * @method static Builder|Subscriber whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Subscriber extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'subscribers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Get subscribers chat ids
     *
     * @return array
     */
    public static function getChatIds(): array
    {
        return self::pluck('chat_id')->all();
    }

    /**
     * Register new subscribers
     *
     * @param string $chatId
     * @param string $name
     * @return void
     */
    public static function register(string $chatId, string $name)
    {
        $existing = self::where('chat_id', $chatId)->first();

        if (!$existing) {
            $subscriber = new self();

            $subscriber
                ->fill([
                    'chat_id' => $chatId,
                    'name' => $name
                ])
                ->save();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
