@extends('AdminDashboard.master')
@section('title', 'Categories')

@section('content')


<div class="d-flex justify-content-between mb-3">
    <h6>Categories</h6>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        Create Category
    </a>
</div>

<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>

            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Status</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
            <tbody>

        @php $mainCounter = 1; @endphp

        @foreach($categories as $main)
        <tr>
            <td>{{ $mainCounter }}</td>
            <td><strong>{{ $main->name }}</strong></td>
            <td>Main</td>
            <td>
                  <span class="px-24 py-4 rounded-pill fw-medium text-sm
                        {{ $main->status
                            ? 'bg-success-focus text-success-main'
                            : 'bg-danger-focus text-danger-main' }}">
                        {{ $main->status ? 'Active' : 'Inactive' }}
                    </span>
            </td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $main->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </a>

                    <form action="{{ route('admin.categories.destroy', $main->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                    </form>
                </div>
            </td>
        </tr>

        @php $subCounter = 1; @endphp
        @foreach($main->children as $sub)
        <tr>
            <td>{{ $mainCounter }}.{{ $subCounter }}</td>
            <td>— {{ $sub->name }}</td>
            <td>Sub</td>
            <td>
                <span class="px-24 py-4 rounded-pill fw-medium text-sm
                        {{ $sub->status
                            ? 'bg-success-focus text-success-main'
                            : 'bg-danger-focus text-danger-main' }}">
                        {{ $sub->status ? 'Active' : 'Inactive' }}
                    </span>
            </td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $sub->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </a>

                    <form action="{{ route('admin.categories.destroy', $sub->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                    </form>
                </div>
            </td>
        </tr>

        @php $subSubCounter = 1; @endphp
        @foreach($sub->children as $subsub)
        <tr>
            <td>{{ $mainCounter }}.{{ $subCounter }}.{{ $subSubCounter }}</td>
            <td>—— {{ $subsub->name }}</td>
            <td>Sub-Sub</td>
            <td>
                    <span class="px-24 py-4 rounded-pill fw-medium text-sm
                        {{ $subsub->status
                            ? 'bg-success-focus text-success-main'
                            : 'bg-danger-focus text-danger-main' }}">
                        {{ $subsub->status ? 'Active' : 'Inactive' }}
                    </span>
            </td>
            <td>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $subsub->id) }}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                        <iconify-icon icon="lucide:edit"></iconify-icon>
                    </a>

                    <form action="{{ route('admin.categories.destroy', $subsub->id) }}" method="POST" class="m-0 p-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @php $subSubCounter++; @endphp
        @endforeach

        @php $subCounter++; @endphp
        @endforeach

        @php $mainCounter++; @endphp
        @endforeach

            </tbody>
    </table>
</div>
</div>
</div>
@endsection
