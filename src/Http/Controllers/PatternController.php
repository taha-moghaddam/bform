<?php

namespace Bikaraan\BForm\Http\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Bikaraan\BForm\Models\Field;
use Bikaraan\BForm\Models\Pattern;
use Bikaraan\BForm\Enums\FieldType;
use Bikaraan\BForm\Models\PatternField;

class PatternController extends BaseAdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pattern';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pattern());

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('name', __('bform::titles.Name'));
        $grid->column('fields_btn', __('bform::titles.Fields'))->display(function () {
            $route = route('bform.pattern.fields.index', ['pattern_id' => $this->id]);
            return "<a href='$route' class='btn btn-xs btn-primary'>" .
                "<i class='fa-regular fa-pen-field'></i> " . __('bform::titles.Fields') .
                "</a>";
        });
        $grid->column('title_fields_name', __('bform::titles.Title fields'))
            ->display(fn () => $this->title_fields_name);
        $grid->column('created_at', __('bform::titles.Created at'));
        $grid->column('updated_at', __('bform::titles.Updated at'));

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', __('bform::titles.Name'));
        });

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
        $show = new Show(Pattern::findOrFail($id));

        $show->field('id', __('bform::titles.Id'));
        $show->field('name', __('bform::titles.Name'));
        $show->field('title_fields_name', __('bform::titles.Title fields'));
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
        $form = new Form(new Pattern());

        $form->text('name', __('bform::titles.Name'))->required();

        if ($form->isEditing()) {
            $form->multipleSelect('title_fields_id', __('bform::titles.Title fields'))
                ->options(
                    Field::whereIn('type', [FieldType::TEXT])
                        ->whereIn('id', PatternField::where('pattern_id', $this->editingId)->pluck('field_id'))
                        ->pluck('name', 'id')
                )
                ->help('این فیلد ها با خط تیره از همه جدا شده و در عنوان فرم نمایش داده می‌شوند.');
        }

        return $form;
    }
}
