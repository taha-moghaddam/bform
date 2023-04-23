<?php

namespace Bikaraan\BForm\Models;

use Bikaraan\BForm\Enums\FieldFillOut;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

/**
 * App\Models\PatternField
 *
 * @property int $id
 * @property int $pattern_id
 * @property int $field_id
 * @property string|null $default_value
 * @property int $is_required
 * @property int $order
 * @property int|null $reference_field_id Source of truth of this field in review-panel
 * @property string|null $fill_out This field fill-out this column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereDefaultValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereIsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField wherePatternId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereReferenceFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PatternField withoutTrashed()
 * @mixin \Eloquent
 */
class PatternField extends BaseModel implements Sortable
{
    use SoftDeletes;
    use LogsActivity;
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected $casts = [
        'fill_out' => FieldFillOut::class,
    ];

    protected $table = 'field_pattern';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('bform-pattern-field')
            ->logAll()
            ->logExcept(['updated_at'])
            ->logOnlyDirty();
    }

    /*
     * Relations
     */

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function reference_field()
    {
        return $this->belongsTo(Field::class, 'reference_field_id');
    }
}
