<?php

namespace Bikaraan\BForm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * App\Models\Pattern
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pattern withoutTrashed()
 * @mixin \Eloquent
 */
class Pattern extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-pattern')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
