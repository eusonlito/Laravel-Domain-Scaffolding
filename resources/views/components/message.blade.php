<app-message {{ $attributes->merge(['class' => $class]) }}>
    <i data-feather="alert-circle" class="w-6 h-6 mr-2"></i>

    {!! $message !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('common.close') }}">
        <i data-feather="x" class="w-4 h-4"></i>
    </button>
</app-message>