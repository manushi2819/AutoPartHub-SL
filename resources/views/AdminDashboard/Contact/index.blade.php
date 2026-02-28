@extends('AdminDashboard.index')

@section('title', 'Contact Inquiries')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h6>Contact Messages</h6>

</div>


<div class="card basic-data-table">
    <div class="card-body">
        <div class="table-responsive">
                <table class="table basic-border-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Subject</th>
                            <th>Replied</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                   <tbody>
                        @foreach ($messages as $index => $message)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone }}</td>
                            <td>{{ $message->subject }}</td>
                            <td>
                                @if($message->is_replied)
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-success-focus text-success-main">Yes</span>
                                @else
                                    <span class="px-24 py-4 rounded-pill fw-medium text-sm bg-warning-focus text-warning-main">No</span>
                                @endif
                              
                            </td>
                            <td>
                              
                                <div class="d-flex gap-2">
                                <a data-bs-toggle="modal"
                                        data-bs-target="#viewMessageModal{{ $message->id }}" class="w-32-px h-32-px bg-info-focus text-info-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:eye"></iconify-icon>
                                </a>

                                <!-- Example delete button in your table -->
                                <button type="button" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center open-delete-modal" 
                                        data-url="{{ route('admin.contact.destroy', $message->id) }}">
                                    <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                </button>
                            </div>

                            </td>
                        </tr>
                        <div class="modal fade" id="viewMessageModal{{ $message->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <form action="{{ route('admin.contact.reply', $message->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h6 class="modal-title">Contact Message</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p><strong>Name:</strong> {{ $message->name }}</p>
                                            <p><strong>Email:</strong> {{ $message->email }}</p>
                                            <p><strong>Phone:</strong> {{ $message->phone }}</p>
                                            <p><strong>Subject:</strong> {{ $message->subject }}</p>
                                            <p><strong>Message:</strong></p>
                                            <div class="border p-2 mb-3">
                                                {{ $message->message }}
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Reply</label>
                                                <textarea name="reply_comment" class="form-control" rows="4"
                                                    {{ $message->is_replied ? 'readonly' : '' }}>{{ $message->reply_comment }}</textarea>
                                            </div>

                                            @if($message->is_replied)
                                                <p class="text-success">
                                                    Replied on {{ $message->replied_at?->format('Y-m-d') }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="modal-footer">
                                            @if(!$message->is_replied)
                                                <button type="submit" class="btn btn-primary">Send Reply</button>
                                            @endif
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
