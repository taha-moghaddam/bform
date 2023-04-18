<?php

namespace Bikaraan\BForm\Models;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Encore\Admin\Auth\Database\Administrator;

/**
 * App\Models\UserData
 *
 * @property int $id
 * @property int $user_id
 * @property int $field_id
 * @property string $value
 * @property string $review_status
 * @property string|null $reviewed_at
 * @property string $review_comment
 * @property int $review_admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereReviewAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereReviewComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereReviewStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserData withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserData withoutTrashed()
 * @mixin \Eloquent
 */
class UserData extends BaseModel
{
    use SoftDeletes;
    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-user-data')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }

    /*
     * Relations
     */

    public function user()
    {
        return $this->belongsTo(Administrator::class, 'user_id');
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
