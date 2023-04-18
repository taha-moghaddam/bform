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

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('pattern.name', __('bform::titles.Pattern'));
        $grid->column('name', __('bform::titles.Name'));
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
        $show = new Show(FormModel::findOrFail($id));

        $show->field('id', __('bform::titles.Id'));
        $show->field('pattern.name', __('bform::titles.Pattern'));
        $show->field('name', __('bform::titles.Name'));
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

        return $form;
    }
}
