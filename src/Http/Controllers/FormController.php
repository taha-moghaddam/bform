<?php

namespace Bikaraan\BForm\Http\Controllers;

use Bikaraan\BForm\Models\Form as FormModel;
use Bikaraan\BForm\Models\Pattern;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class FormController extends BaseAdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Form';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FormModel());

        $limitParser = $this->parse_limit(...);

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('pattern.name', __('bform::titles.Pattern'));
        $grid->column('name', __('bform::titles.Name'));
        $grid->column('active', __('bform::titles.Active'))->switch();
        $grid->column('contribution_limit', __('bform::titles.Contribution limit'))->display(fn ($v) => $limitParser($v));
        $grid->column('updated_at', __('bform::titles.Updated at'));

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->select('pattern_id', __('bform::titles.Pattern'))->options(Pattern::pluck('name', 'id'));
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
        $show = new Show(FormModel::findOrFail($id));

        $limitParser = $this->parse_limit(...);

        $show->field('id', __('bform::titles.Id'));
        $show->field('pattern.name', __('bform::titles.Pattern'));
        $show->field('name', __('bform::titles.Name'));
        $show->field('active', __('bform::titles.Active'))->bool();
        $show->field('contribution_limit', __('bform::titles.Contribution limit'))->as(fn ($v) => $limitParser($v));
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
        $form = new Form(new FormModel());

        $form->select('pattern_id', __('bform::titles.Pattern'))
            ->options(Pattern::pluck('name', 'id'))
            ->required();
        $form->text('name', __('bform::titles.Name'))
            ->required();
        $form->switch('active', __('bform::titles.Active'))
            ->default(true);
        $form->number('contribution_limit', __('bform::titles.Contribution limit'))
            ->default(1)
            ->help('۰ معادل نامحدود می‌باشد.')
            ->min(0)
            ->required();

        return $form;
    }

    public function parse_limit($value)
    {
        if (empty($value)) {
            return 'نامحدود';
        }
        return $value;
    }
}
