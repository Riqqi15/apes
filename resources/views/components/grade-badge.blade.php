@php
  $grade = $grade ?? 'N/A';
  $label = $label ?? $grade;
  $color = 'secondary';
  if (in_array($grade, ['A', 'A+'])) $color = 'success';
  elseif ($grade === 'B') $color = 'primary';
  elseif ($grade === 'C') $color = 'warning';
  elseif (in_array($grade, ['D', 'E'])) $color = 'danger';
@endphp
<span class="badge grade-badge text-bg-{{ $color }}">{{ $label }}</span>
