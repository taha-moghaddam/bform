<?php

namespace Bikaraan\BForm\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Field
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $lifetime
 * @property string|null $default_value
 * @property string|null $rules
 * @property string|null $hint
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Field newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Field onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Field query()
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereHint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereLifetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Field withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Field withoutTrashed()
 * @mixin \Eloquent
 */
class Field extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-field')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
