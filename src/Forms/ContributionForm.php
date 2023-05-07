<?php

namespace Bikaraan\BForm\Forms;

use Bikaraan\BForm\Enums\FieldFillOut;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Facades\Admin;
use Bikaraan\BForm\Models\Field;
use Bikaraan\BForm\Enums\FieldType;
use Bikaraan\BForm\Models\UserData;
use Bikaraan\BForm\Models\Contribution;
use Bikaraan\BForm\Models\ContributionData;
use Bikaraan\BForm\Models\Form as ModelsForm;
use Bikaraan\BForm\Services\ContributionService;

class ContributionForm extends Form
{
    /**
     * The form title.
     *
     * @var  string
     */
    public $title = 'Form';

    const FILE_UPLOAD_DIR = 'bform' . DIRECTORY_SEPARATOR . 'user-data';

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
        // Check is form active
        if (!$this->formModel->active) {
            admin_error(__('bform::msg.Form has deactivated!'));
            return back();
        }

        // Prevent multiple contribution in a form
        if ($this->formModel->has_reached_limit) {
            admin_error(__('bform::msg.You have reached contribution limit!'));
            return back();
        }

        // Create new contribution
        $contribution = new Contribution();
        $contribution->user_id = Admin::user()->id;
        $contribution->form_id = $this->formModel->id;
        $contribution->save();

        $titleFieldsArray = [];

        foreach ($this->formModel->pattern->fields as $field) {

            $value = $this->parseInput($request, $field);

            if (empty($value)) continue;

            // Find equivalent value in user-data for this field or create new one
            $userData = UserData::firstOrCreate([
                'field_id' => $field->id,
                'user_id' => Admin::user()->id,
                'value' => $value,
            ]);

            // Save user-data on contribution data
            $contributionData = new ContributionData();
            $contributionData->contribution_id = $contribution->id;
            $contributionData->user_data_id = $userData->id;
            $contributionData->save();

            // Update related fill-out
            if ($field->pivot->fill_out) {
                FieldFillOut::tryFrom($field->pivot->fill_out)?->update($value);
            }

            // Fill contribution-title
            if (in_array($field->id, $this->formModel->pattern->title_fields_id)) {
                $titleFieldsArray[] = $value;
            }
        }

        // Update contribution title
        $contribution->title = implode(' - ', $titleFieldsArray);
        $contribution->save();

        admin_toastr(__('bform::msg.Data saved successfully.'));

        return redirect()->route('bform.contributions.index');
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->hidden('form_id')->default($this->formModel->id);

        foreach ($this->formModel->pattern->fields as $field) {
            $f = $this->{$field->type->func()}('field_' . $field->id, $field->name)
                ->rules($field->rules);

            if ($field->pivot->is_required) {
                $f->required();
            }

            $f->default($field->pivot->default_value ?? $field->default_value);

            if (!empty($field->hint)) {
                $f->help($field->hint);
            }

            switch ($field->type) {
                case FieldType::IMAGE:
                    $f->disk('local')->dir(self::FILE_UPLOAD_DIR);
                    break;
                case FieldType::ZONE:
                    $f->ajax(route('bzones.search'));
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

    /**
     * Prase input to value
     *
     * @param Request $request
     * @param Field $field
     * @return string Field value
     */
    protected function parseInput(Request $request, Field $field): ?string
    {
        $inputName = "field_{$field->id}";

        if (!$request->has($inputName)) return null;

        return match ($field->type) {
            FieldType::IMAGE => $this->handleImage($request, $inputName, $field),
            default => $request->input($inputName),
        };
    }

    /**
     * Handle image on parsing inputs
     *
     * @param Request $request
     * @param string $inputName
     * @param Field $fieldName
     * @return string Uploaded file address
     */
    protected function handleImage(Request $request, string $inputName, Field $field): string
    {
        if (!$request->hasFile($inputName)) return $request->input($inputName);

        $request->validate([$inputName => 'file']);

        $fileNameToStore = Admin::user()->id . "-{$field->id}-" . time() . '-' . random_int(1, 9);

        $request->file($inputName)->storeAs(self::FILE_UPLOAD_DIR, $fileNameToStore);

        return $fileNameToStore;
    }
}
