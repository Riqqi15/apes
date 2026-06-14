<div class="table-actions">
    @if(!empty($view))
        <a href="{{ $view }}" class="action-btn action-btn-view" title="Lihat">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M2.5 12s3.8-7 9.5-7 9.5 7 9.5 7-3.8 7-9.5 7-9.5-7-9.5-7z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </a>
    @endif
    @if(!empty($edit))
        <a href="{{ $edit }}" class="action-btn action-btn-edit" title="Edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m12 20 8-8"></path>
                <path d="M14.5 5.5 18.5 9.5"></path>
                <path d="M4 20h5"></path>
                <path d="M4 16.5 14.5 6 18 9.5 7.5 20H4z"></path>
            </svg>
        </a>
    @endif
    @if(!empty($print))
        <a href="{{ $print }}" class="action-btn action-btn-print" title="Print">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M6 9V4h12v5"></path>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <path d="M6 14h12v6H6z"></path>
            </svg>
        </a>
    @endif
    @if(!empty($delete))
        <form method="POST" action="{{ $delete }}" onsubmit="return confirm('Hapus data ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn action-btn-delete" title="Hapus">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M3 6h18"></path>
                    <path d="M8 6V4h8v2"></path>
                    <path d="M6 6l1 14h10l1-14"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
            </button>
        </form>
    @endif
</div>
