<?php

namespace Bikaraan\BForm\Models;

use Bikaraan\BForm\Enums\FieldFillOut;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    protected $casts = [
        'title_fields_id' => 'object',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-pattern')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }

    /*
     * Accessors
     */

    // title_fields_name
    public function getTitleFieldsNameAttribute()
    {
        if (empty($this->title_fields_id)) return;
        return Field::whereIn('id', $this->title_fields_id)?->pluck('name')?->join('، ');
    }

    /*
     * Relations
     */

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class, $this->prefix . 'field_pattern')
            ->whereNull($this->prefix . 'field_pattern.deleted_at')
            ->withPivot(['is_required', 'default_value', 'reference_fields_id', 'fill_out'])
            ->orderBy('order');
    }
}
