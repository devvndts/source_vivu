<div class="input-group {{ $attributes->get('class-input-group') }}">
    <input class="form-control
            {{ $attributes->get('class') }}"
        {{ $attributes }} />
    <div class="input-group-append">
        <div class="input-group-text"><strong>{{ $slot }}</strong></div>
    </div>
</div>

