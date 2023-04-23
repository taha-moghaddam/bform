<?php

namespace Bikaraan\BForm\Http\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Bikaraan\BForm\Models\Pattern;

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

        return $form;
    }
}
