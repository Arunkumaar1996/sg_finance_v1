@if($employees->hasPages())
<div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
    <div class="text-muted small">
        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} entries
    </div>
    <div>
        {{ $employees->links() }}
    </div>
</div>
@endif