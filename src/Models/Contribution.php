<?php

namespace Bikaraan\BForm\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Contribution
 *
 * @property int $id
 * @property int $user_id
 * @property int $form_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contribution withoutTrashed()
 * @mixin \Eloquent
 */
class Contribution extends BaseModel
{
    use SoftDeletes;
}
