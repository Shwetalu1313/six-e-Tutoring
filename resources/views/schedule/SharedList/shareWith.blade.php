<div class="card">
    <div class="card-body p-3">
        <div class="table-responsive-md">
            <table id="schedule-table" class="table">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Owner Email</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $scheduleUsers = Auth::user()->scheduleUsers;
                @endphp

                @if($scheduleUsers->count() === 0)
                    <tr>
                        <td class="colspan-7">No shared Data</td>
                    </tr>
                @else
                    @foreach($scheduleUsers as $i => $scheduleUser)
                        <tr>
                            <td>{{$i + 1}}</td>
                            <td>
                                @if($scheduleUser->schedule->important)
                                    <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                                @endif
                                {{$scheduleUser->schedule->title}}
                            </td>
                            <td>{{ $scheduleUser->ownerUser->email }}</td>
                            <td>{{ \Carbon\Carbon::parse($scheduleUser->schedule->date)->format('Y-M-d (D)') }}</td>
                            <td>{{ \Carbon\Carbon::parse($scheduleUser->schedule->time)->format('h:i A') }}</td>
                            <td><span class="badge {{ $scheduleUser->schedule->status === 'confirmed' ? 'text-bg-success' : 'text-bg-warning' }}">{{ $scheduleUser->schedule->status }}</span></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#shareWithModal{{$i}}">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="shareWithModal{{$i}}" tabindex="-1" aria-labelledby="shareWithModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="shareWithModalLabel">{{$scheduleUser->schedule->title}}</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            @if($scheduleUser->schedule->important)
                                                <span class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> IMPORTANT</span>
                                            @endif
                                            <div class="mb-3">Meeting Date - <strong>{{ \Carbon\Carbon::parse($scheduleUser->schedule->date)->format('Y-M-d (D)') }}</strong></div>
                                            <div class="mb-3">Meeting Time - <strong>{{ \Carbon\Carbon::parse($scheduleUser->schedule->time)->format('h:i A') }}</strong></div>
                                            <div class="mb-3">Address - <br>
                                                @if(filter_var($scheduleUser->schedule->location, FILTER_VALIDATE_URL))
                                                    <a href="{{ $scheduleUser->schedule->location }}" target="_blank">{{ $scheduleUser->schedule->location }}</a>
                                                @else
                                                    {{ $scheduleUser->schedule->location }}
                                                @endif
                                            </div> <hr>
                                            <div class="mb-3">
                                                @if($scheduleUser->schedule->expired)
                                                    The date was <span class="badge text-bg-danger">expired</span>
                                                @else
                                                    Schedule is in <span class="badge text-bg-info">waiting</span> stage.
                                                @endif
                                            </div>

                                            <div class="mb-3">
                                                @if($scheduleUser->schedule->status === 'pending')
                                                    Meeting is in <span class="badge text-bg-warning">pending</span> stage.
                                                @else
                                                    Meeting was <span class="badge text-bg-success">confirmed</span>.
                                                @endif
                                            </div><hr>
                                            <div class="mb-3 text-end">
                                                <em>Shared by - </em>{{ $scheduleUser->ownerUser->email }}<br>
                                                <em class="text-primary">{{ \Carbon\Carbon::parse($scheduleUser->created_at)}}</em>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{url('share/'.$scheduleUser->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" onclick="window.confirm('Are you sure? !!This schedule will completely delete from both side')">Delete</button>
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
