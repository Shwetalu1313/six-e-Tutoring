<div class="py-3">
    You shared the following schedules.
</div>

<div class="card">
    <div class="card-body p-3">
        <div class="table-responsive-md">
            <table id="schedule-table" class="table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Receiver Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($myShares->isEmpty())
                    <tr>
                        <td colspan="7">No shared data</td>
                    </tr>
                @else
                    @foreach($myShares as $i => $myShare)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>
                                @if($myShare->important)
                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                @endif
                                {{ $myShare->title }}
                            </td>
                            <td>{{ $myShare->receiver_email  }}</td>
                            <td>{{ \Carbon\Carbon::parse($myShare->date)->format('Y-M-d (D)') }}</td>
                            <td>{{ \Carbon\Carbon::parse($myShare->time)->format('h:i A') }}</td>
                            <td><span class="badge {{ $myShare->status === 'confirmed' ? 'bg-success' : 'bg-warning' }}">{{ $myShare->status }}</span></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$i}}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $myShare->title }}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            @if($myShare->important)
                                                <span class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> IMPORTANT</span>
                                            @endif
                                            <div class="mb-3">Meeting Date - <strong>{{ \Carbon\Carbon::parse($myShare->date)->format('Y-M-d (D)') }}</strong></div>
                                            <div class="mb-3">Meeting Time - <strong>{{ \Carbon\Carbon::parse($myShare->time)->format('h:i A') }}</strong></div>
                                            <div class="mb-3">Address - <br>
                                                @if(filter_var($myShare->location, FILTER_VALIDATE_URL))
                                                    <a href="{{ $myShare->location }}" target="_blank">{{ $myShare->location }}</a>
                                                @else
                                                    {{ $myShare->location }}
                                                @endif
                                            </div>
                                            <hr>
                                            <div class="mb-3">
                                                @if($myShare->expired)
                                                    The date was <span class="badge bg-danger">expired</span>
                                                @else
                                                    Schedule is in <span class="badge bg-info">waiting</span> stage.
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                @if($myShare->status === 'pending')
                                                    Meeting is in <span class="badge bg-warning">pending</span> stage.
                                                @else
                                                    Meeting was <span class="badge bg-success">confirmed</span>.
                                                @endif
                                            </div>
                                            <hr>
                                            <div class="mb-3 text-end">
                                                <em>received by - </em>{{ $myShare->receiver_email }}<br>
                                                <em class="text-primary">{{ \Carbon\Carbon::parse($myShare->created_at)->toDateTimeString() }}</em>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ url('share/'.$myShare->shared_id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure? This schedule will be deleted from both sides')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
