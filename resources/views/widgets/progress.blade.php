<div class="progress" style="{{ $height ?? '' }}">
    <div class="progress-bar bg-{{ $class }} {{ $stripped ? 'progress-bar-striped' : '' }} {{ $animated ? 'progress-bar-animated' : '' }}" role="progressbar" style="width: {{ $value }}%" aria-valuenow="{{ $value }}" aria-valuemin="{{ $min }}" aria-valuemax="{{ $max }}">{{ $text }}</div>
</div>
