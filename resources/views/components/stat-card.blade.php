@php
    $tone = $tone ?? 'yellow';
@endphp

<div class="stat-card stat-card-{{ $tone }} card">
    <div class="stat-card-icon">{!! $icon ?? '<span>AP</span>' !!}</div>
    <div class="stat-card-body">
        <p class="stat-card-title">{{ $title ?? 'Title' }}</p>
        <div class="stat-card-value">{{ $value ?? '0' }}</div>
        @if(!empty($subtitle))
            <p class="stat-card-subtitle">{{ $subtitle }}</p>
        @endif
    </div>
</div>
