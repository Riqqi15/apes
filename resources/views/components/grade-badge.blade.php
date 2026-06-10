@php
  $grade = $grade ?? 'N/A';
  $color = 'secondary';
  if($grade === 'A') $color = 'success';
  elseif($grade === 'B') $color = 'primary';
  elseif($grade === 'C') $color = 'warning';
  elseif($grade === 'D') $color = 'danger';
@endphp
<span class="badge bg-{{ $color }}">{{ $grade }}</span>
