@extends('errors.master')

@section('content')
    <h2 class="debug-error-code">ERROR {{ esc_html__($error_code, 'en_US') }}</h2>
    <h3 class="debug-error-title">{{ esc_html__($error_title, 'en_US') }}</h3>
    <p class="debug-error-message">{{ esc_html__($error_message, 'en_US') }}</p>

    @if (!empty($error_stack))
        <div class="debug-error-stack">
            <h4>Stack Trace:</h4>
            <ul class="stack-trace-list">
                @foreach ($error_stack as $line)
                    <li>{{ esc_html__($line, 'en_US') }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection