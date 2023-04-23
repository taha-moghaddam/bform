<?php

namespace Bikaraan\BForm\Http\Controllers;

use Bikaraan\BForm\Enums\FieldType;
use Bikaraan\BForm\Models\Field;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FieldController extends BaseAdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Field';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Field());

        $lifetimeParser = $this->parse_lifetime(...);

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('name', __('bform::titles.Name'));
        $grid->column('type', __('bform::titles.Type'))->using(FieldType::pluck());
        $grid->column('lifetime', __('bform::titles.Lifetime'))->display(fn($v) => $lifetimeParser($v));
        $grid->column('default_value', __('bform::titles.Default value'));
        $grid->column('rules', __('bform::titles.Rules'));
        $grid->column('hint', __('bform::titles.Hint'));
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
        $show = new Show(Field::findOrFail($id));

        $lifetimeParser = $this->parse_lifetime(...);

        $show->field('id', __('bform::titles.Id'));
        $show->field('name', __('bform::titles.Name'));
        $show->field('type', __('bform::titles.Type'))->using(FieldType::pluck());
        $show->field('lifetime', __('bform::titles.Lifetime'))->as(fn($v) => $lifetimeParser($v));
        $show->field('default_value', __('bform::titles.Default value'));
        $show->field('rules', __('bform::titles.Rules'));
        $show->field('hint', __('bform::titles.Hint'));
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
        $form = new Form(new Field());

        $form->text('name', __('bform::titles.Name'))->required();
        $form->select('type', __('bform::titles.Type'))->options(FieldType::pluck())->required();
        $form->number('lifetime', __('bform::titles.Lifetime'))
            ->help('واحد روز می‌باشد. برای اعتبار دائم -۱ وارد کنید.')
            ->required();
        $form->text('default_value', __('bform::titles.Default value'));
        $form->text('rules', __('bform::titles.Rules'));
        $form->text('hint', __('bform::titles.Hint'));

        return $form;
    }

    public function parse_lifetime($value)
    {
        return match ($value) {
            -1 => 'دائم',
            default => "$value روز",
        };
    }
}
