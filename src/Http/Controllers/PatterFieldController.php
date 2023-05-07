<?php

namespace Bikaraan\BForm\Http\Controllers;

use Bikaraan\BForm\Enums\FieldFillOut;
use Bikaraan\BForm\Enums\FieldType;
use Bikaraan\BForm\Models\Field;
use Bikaraan\BForm\Models\Pattern;
use Bikaraan\BForm\Models\PatternField;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PatterFieldController extends BaseAdminController
{

    protected int $pattern_id;
    protected Pattern $pattern;

    public function __construct()
    {
        $patterId = request()->route('pattern_id');
        if (\App::runningInConsole()) {
            // To fix `artisan route:list` problem
            $patterId ??= 0;
        } else {
            $this->pattern_id = $patterId;
            $this->pattern = Pattern::findOrFail($patterId);
        }


        $this->title = __('bform::titles.PatternFields', ['pattern' => $this->pattern->name ?? __('Pattern')]);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PatternField());

        $grid->model()->where('pattern_id', $this->pattern_id);

        $grid->sortable();

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('field.name', __('bform::titles.Field'));
        $grid->column('default_value', __('bform::titles.Default value'));
        $grid->column('is_required', __('bform::titles.Is required'))->bool();
        $grid->column('reference_fields_id', __('bform::titles.Reference field'));
        $grid->column('created_at', __('bform::titles.Created at'));
        $grid->column('updated_at', __('bform::titles.Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(PatternField::findOrFail($id));

        $show->field('id', __('bform::titles.Id'));
        $show->field('pattern_id', __('bform::titles.Pattern id'));
        $show->field('field_id', __('bform::titles.Field id'));
        $show->field('default_value', __('bform::titles.Default value'));
        $show->field('is_required', __('bform::titles.Is required'));
        $show->field('order', __('bform::titles.Order'));
        $show->field('fill_out', __('bform::titles.Fill out'))->using(FieldFillOut::pluck());
        $show->field('reference_fields_id', __('bform::titles.Reference field id'));
        $show->field('created_at', __('bform::titles.Created at'));
        $show->field('updated_at', __('bform::titles.Updated at'));
        $show->field('deleted_at', __('bform::titles.Deleted at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PatternField());

        $form->hidden('pattern_id')->value($this->pattern_id)->required();
        $form->select('field_id', __('bform::titles.Field'))->options(Field::pluck('name', 'id'))->required();
        $form->text('default_value', __('bform::titles.Default value'));
        $form->switch('is_required', __('bform::titles.Is required'));
        $form->tags('reference_fields_id', __('bform::titles.Reference field'))
            ->setAsJSON()
            ->options(Field::where('type', '!=', FieldType::IMAGE)->pluck('name', 'id'))
            ->help('در موقع بررسی، این فیلد به عنوان مرجع جهت تطبیق به ارزیاب نمایش داده می‌شود. برای مثال مرجع کد ملی می‌تواند کارت ملی باشد. به همین جهت مرجع باید از نوع تصویر باشد.');
        $form->select('fill_out', __('bform::titles.Fill out'))
            ->options(FieldFillOut::pluck())
            ->help('با پر شدن این فیلد چه چیز به طور خودکار به روز شود؟');

        $patternId = $this->pattern_id;
        $form->saving(function (Form $form) use ($patternId) {
            $form->pattern_id = $patternId;
        });

        return $form;
    }
}
