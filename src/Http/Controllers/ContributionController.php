<?php

namespace Bikaraan\BForm\Http\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Row;
use Encore\Admin\Layout\Content;
use Bikaraan\BForm\Models\Contribution;
use Bikaraan\BForm\Forms\ContributionForm;
use Bikaraan\BForm\Models\Form as ModelsForm;

class ContributionController extends BaseAdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Contribution';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        $this->title = 'Dashboard';
        $grid = $this->grid();
        $forms = ModelsForm::whereActive(true)->get();

        return $content
            ->title($this->title())
            ->description(__('bform::titles.Forms'))
            ->view('bform::contributions.dashboard', [
                'forms' => $forms,
                'grid' => $grid,
            ]);
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Contribution());

        $grid->model()->orderByDesc('id');

        $grid->column('id', __('bform::titles.Id'))->sortable();
        $grid->column('form.name', __('bform::titles.Form'))->sortable();
        $grid->column('title', __('bform::titles.Title'))->sortable();
        $grid->column('created_at', __('bform::titles.Created at'))->sortable();

        $grid->disableCreateButton()
            ->disableBatchActions()
            ->disableColumnSelector()
            ->disableExport()
            ->disableFilter()
            ->disableActions();

        return $grid;
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        request()->validate(['form_id' => 'required']);
        $formModel = ModelsForm::findOrFail(request()->input('form_id'));

        return $content
            ->title($formModel->name)
            ->description(__('bform::titles.Request'))
            ->row(function (Row $row) use ($formModel) {
                $row->column(2, '');
                $row->column(8, new ContributionForm($formModel));
            });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Contribution::findOrFail($id));

        $show->field('id', __('bform::titles.Id'));
        $show->field('user_id', __('bform::titles.User id'));
        $show->field('form_id', __('bform::titles.Form id'));
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
        request()->validate([
            'form_id' => 'required'
        ]);

        $formId = request()->get('form_id');
        $formModel = ModelsForm::findOrFail($formId);

        $form = new Form(new Contribution());

        $form->number('user_id', __('bform::titles.User id'));
        $form->number('form_id', __('bform::titles.Form id'));

        return $form;
    }
}
