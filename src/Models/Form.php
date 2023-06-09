<?php

namespace Bikaraan\BForm\Models;

use Encore\Admin\Facades\Admin;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * App\Models\Form
 *
 * @property int $id
 * @property int $pattern_id
 * @property string $name
 * @property bool $active
 * @property int $contribution_limit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Form onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Form query()
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form wherePatternId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Form withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Form withoutTrashed()
 * @mixin \Eloquent
 */
class Form extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-form')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }

    /*
     * Relations
     */

    public function pattern()
    {
        return $this->belongsTo(Pattern::class);
    }

    /*
     * Accessors
     */

    protected function getHasReachedLimitAttribute()
    {
        if (empty($this->contribution_limit)) return false;

        $currentContributionsCount = Contribution::whereFormId($this->id)
            ->whereUserId(Admin::user()->id)
            ->count();

        return $this->contribution_limit <= $currentContributionsCount;
    }
}
