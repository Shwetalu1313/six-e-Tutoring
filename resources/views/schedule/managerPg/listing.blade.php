<div class="table-responsive-sm">
    <table class="table table-hover">
        <caption>My Schedule List <span class="badge text-bg-secondary">{{$schedules->count()}}</span></caption>
        <thead class="table-success">
        <tr>
            <td>No.</td>
            <td>Title</td>
            <td>Date</td>
            <td>Time</td>
            <td>Location Type</td>
            <td>Status</td>
            <td>Expired</td>
            <td>Notify</td>
            <td>Share</td>
            <td>Action</td>
        </tr>
        </thead>
            @foreach($schedules as $i => $schedule)
                <tr @if($schedule->important)
                        title="This is the important Schedule."
                @endif>
                    <td>{{$i+1}}</td>
                    <td class="hover-name" data-toggle="tooltip" title="Click to see detail" onclick="window.location='{{ route('schedule.show', $schedule) }}';">
                        @if($schedule->important)
                            <i class="bi bi-exclamation-circle-fill text-danger"></i>
                        @endif
                            {{$schedule->title}}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('Y-M-d (D)') }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}</td>
                    <td>
                        @if($schedule->locationType === 'virtual')
                            <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#myModal{{$i}}" data-bs-whatever="Confirm">Virtual</button>
                        @elseif($schedule->locationType === 'reality')
                            <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#myModal{{$i}}" data-bs-whatever="Pending">Reality</button>
                        @else
                            none
                        @endif
                        <!-- Modal -->
                        <div class="modal fade" id="myModal{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <span @class(['mb-3','text-info'])>Address--</span><br>
                                        @if(filter_var($schedule->location, FILTER_VALIDATE_URL))
                                            <a href="{{ $schedule->location }}" target="_blank">{{ $schedule->location }}</a>
                                        @else
                                            {{ $schedule->location }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($schedule->status === 'confirmed')
                            <form method="POST" action="{{ url('/schedule/status/'. $schedule->id) }}" class="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit" class="btn btn-sm btn-success" title="Click to rechange"><i class="bi bi-check-circle-fill"></i> Confirm</button>
                            </form>
                        @else
                            <form method="POST" action="{{ url('/schedule/status/'. $schedule->id) }}" class="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn btn-sm btn-warning" title="Click to Confirm."><i class="bi bi-clock-history"></i> Pending</button>
                            </form>
                        @endif
                    </td>
                    <td>
                        @if($schedule->expired)
                            <span class="badge text-bg-danger">expired</span>
                        @else
                            <span class="badge text-bg-primary">waiting</span>
                        @endif
                    </td>
                    <td>
                        @if($schedule->notify)
                            <form method="POST" action="{{ route('schedule.updateNotification', ['id' => $schedule->id]) }}" class="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="notify" value="0">
                                <button type="submit" class=""><i class="bi bi-bell-fill text-warning" title="Click Turn off Notification"></i></button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('schedule.updateNotification', ['id' => $schedule->id]) }}" class="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="notify" value="1">
                                <button type="submit" class=""><i class="bi bi-bell-slash-fill text-danger" title="Click Turn on Notification"></i></button>
                            </form>
                        @endif
                    </td>
                    <td>
                        <button title="share to others" data-bs-toggle="modal" data-bs-target="#share{{$i}}" data-bs-whatever="share"><i class="bi bi-share-fill"></i></button>
                        <!-- Modal -->
                        <div class="modal fade" id="share{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="post" action="{{route('share.store')}}">
                                            @csrf
                                            @method('POST')
                                            <div class="row mb-3">
                                                <input type="hidden" value="{{$schedule->id}}" name="schedule_id">
                                                <input type="email" placeholder="m@gmail.com" name="email" class="form-control">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="mb-3">
                                                    <i class="bi bi-share-fill"></i> Share <span class="badge text-bg-primary">{{ $schedule->scheduleUsers()->count() }}</span>
                                                </button>
                                            </div>
                                        </form>

                                        {{--list of users who get access this to view--}}
                                        <ul class="list-group text-start">
                                            @foreach($schedule->scheduleUsers as $j => $scheduleUser)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{$j+1 .". ". $scheduleUser->user->name . " (" . $scheduleUser->user->email . ")"}}
                                                    <form action="{{route('share.destroy', $scheduleUser->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure? This schedule will be completely deleted.')"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="border-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-light" title="Delete this schedule." style="background-color: #ff2121" onclick="window.confirm('Are you sure to delete this schedule.')"><i class="bi bi-trash me-3"></i>Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
    </table>
</div>

