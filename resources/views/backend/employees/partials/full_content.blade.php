<!-- Include both table and pagination -->
@include('backend.employees.partials.table', ['employees' => $employees])

@if($employees->hasPages())
    @include('backend.employees.partials.pagination', ['employees' => $employees])
@endif