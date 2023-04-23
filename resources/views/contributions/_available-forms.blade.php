@foreach ($forms as $form)
    <a href="{{ route('bform.contributions.create', ['form_id' => $form->id]) }}" @class([
        'btn',
        'btn-lg',
        'btn-success',
        'disabled' => $form->has_reached_limit,
    ])>
        <i class="fa-regular fa-plus"></i>
        {{ $form->name }}
    </a>
@endforeach
