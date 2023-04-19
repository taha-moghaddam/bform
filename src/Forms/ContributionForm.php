<?php

namespace Bikaraan\BForm\Forms;

use Bikaraan\BForm\Models\Contribution;
use Bikaraan\BForm\Models\ContributionData;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Facades\Admin;
use Bikaraan\BForm\Models\UserData;
use Bikaraan\BForm\Models\Form as ModelsForm;

class ContributionForm extends Form
{
    /**
     * The form title.
     *
     * @var  string
     */
    public $title = 'Form';

    protected ModelsForm $formModel;

    public function __construct(?ModelsForm $formModel)
    {
        parent::__construct();

        if (empty($formModel?->id)) {
            request()->validate(['form_id' => 'required']);
            $formId = request()->input('form_id');
            $formModel = ModelsForm::findOrFail($formId);
        }

        $this->formModel = $formModel;
        $this->title = $formModel->name;
    }

    /**
     * Handle the form request.
     *
     * @param  Request $request
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        // TODO: Prevent multiple contribution in a form

        // Create new contribution
        $contribution = new Contribution();
        $contribution->user_id = Admin::user()->id;
        $contribution->form_id = $this->formModel->id;
        $contribution->save();

        foreach ($this->formModel->pattern->fields as $field) {

            $input = $request->input('field_' . $field->id);
            if (empty($input)) {
                continue;
            }

            // Find equivalent value in user-data for this field or create new one
            $userData = UserData::firstOrCreate([
                'field_id' => $field->id,
                'user_id' => Admin::user()->id,
                'value' => $input,
            ]);

            // Save user-data on contribution data
            $contributionData = new ContributionData();
            $contributionData->contribution_id = $contribution->id;
            $contributionData->user_data_id = $userData->id;
            $contributionData->save();

        }

        admin_toastr(__('bform::msg.Data saved successfully.'));

        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('form_id')->default($this->formModel->id);

        foreach ($this->formModel->pattern->fields as $field) {
            $f = $this->{$field->type->func()}('field_' . $field->id, $field->name);

            if ($field->pivot->is_required) {
                $f->required();
            }

            $f->default($field->pivot->default_value ?? $field->default_value);

            if (!empty($field->hint)) {
                $f->help($field->hint);
            }
        }
    }

    /**
     * The data of the form.
     *
     * @return  array $data
     */
    public function data()
    {
        return [
            'name'       => 'John Doe',
            'email'      => 'John.Doe@gmail.com',
            'created_at' => now(),
        ];
    }
}
