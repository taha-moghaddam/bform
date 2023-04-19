<?php

namespace Bikaraan\BForm\Http\Controllers;

use Bikaraan\BForm\Models\UserData;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserDataController extends BaseAdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Data';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserData());

        $grid->column('id', __('bform::titles.Id'));
        $grid->column('user.name', __('bform::titles.User'));
        $grid->column('field.name', __('bform::titles.Field'));
        $grid->column('value', __('bform::titles.Value'));
        $grid->column('review_status', __('bform::titles.Review status'))->display(fn() => $this->review_status->label());
        $grid->column('reviewed_at', __('bform::titles.Reviewed at'));
        $grid->column('review_comment', __('bform::titles.Review comment'));
        $grid->column('review_admin_id', __('bform::titles.Review admin'));
        $grid->column('created_at', __('bform::titles.Created at'));

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
        $show = new Show(UserData::findOrFail($id));

        $show->field('id', __('bform::titles.Id'));
        $show->field('user_id', __('bform::titles.User id'));
        $show->field('field_id', __('bform::titles.Field id'));
        $show->field('value', __('bform::titles.Value'));
        $show->field('review_status', __('bform::titles.Review status'));
        $show->field('reviewed_at', __('bform::titles.Reviewed at'));
        $show->field('review_comment', __('bform::titles.Review comment'));
        $show->field('review_admin_id', __('bform::titles.Review admin id'));
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
        $form = new Form(new UserData());

        $form->number('user_id', __('bform::titles.User id'));
        $form->number('field_id', __('bform::titles.Field id'));
        $form->text('value', __('bform::titles.Value'));
        $form->text('review_status', __('bform::titles.Review status'));
        $form->datetime('reviewed_at', __('bform::titles.Reviewed at'))->default(date('Y-m-d H:i:s'));
        $form->textarea('review_comment', __('bform::titles.Review comment'));
        $form->number('review_admin_id', __('bform::titles.Review admin id'));

        return $form;
    }
}
