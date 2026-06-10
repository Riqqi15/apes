<div class="stat-card card shadow-sm">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <small class="text-muted">{{ $title ?? 'Title' }}</small>
        <h5 class="mb-0">{{ $value ?? '—' }}</h5>
      </div>
      <div class="ms-3">
        @if(isset($icon)) {!! $icon !!} @endif
      </div>
    </div>
  </div>
</div>
