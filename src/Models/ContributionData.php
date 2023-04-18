<?php

namespace Bikaraan\BForm\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ContributionData
 *
 * @property int $id
 * @property int $contribution_id
 * @property int $user_data_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereContributionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData whereUserDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContributionData withoutTrashed()
 * @mixin \Eloquent
 */
class ContributionData extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-contribution-data')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }
}
