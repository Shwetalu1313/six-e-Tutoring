<aside class="col-lg-4 mb-5">
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:70px; margin-bottom:50px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    <div class="card">
        <div class="card-header fs-5 text-center">
            Waiting List
        </div>
        <div class="card-body">
            @foreach(Auth::user()->WaitingSchedules as $schedule)
                <section class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <p style="margin: 0;">
                            @if($schedule->important)
                                <a tabindex="0" role="button" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="Important Meeting" class="popover-dismiss"><i class="bi bi-exclamation-circle-fill text-danger"></i></a>
                            @endif
                            {{$schedule->title}}
                        </p>
                        <!-- Delete Button -->
                        <form action="{{ route('schedule.destroy', $schedule->id) }}" method="POST" class="border-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0" title="Delete this schedule."><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <div class="card-body schedule-item-1" id="schedule-item-1" style="background: linear-gradient(72deg, rgba(0,255,137,0.1092086492800245) 23%, rgba(49,128,168,0.09520304703912819) 97%);">
                        <div class="row">
                            <div class="col-lg-6">
                                <strong>Date:</strong> {{ $schedule->date }}<br>
                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->time)->format('h:i A') }}<br>
                                <button type="button" class="btn btn-outline-primary mt-3" onclick="window.location='{{ route('schedule.show', $schedule) }}';">Detail</button>
                            </div>
                            <div class="col-lg-6">
                                @if(filter_var($schedule->location, FILTER_VALIDATE_URL))
                                    <a href="{{ $schedule->location }}" target="_blank">{{ $schedule->location }}</a>
                                @else
                                    {{ $schedule->location }}
                                @endif
                                <br>
                                    @if($schedule->status === 'confirmed')
                                        <form method="POST" action="{{ url('/schedule/status/'. $schedule->id) }}" class="my-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ url('/schedule/status/'. $schedule->id) }}" class="my-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-warning">Pending</button>
                                        </form>
                                    @endif

                                    @if($schedule->notify)
                                        <form method="POST" action="{{ route('schedule.updateNotification', ['id' => $schedule->id]) }}" class="my-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="notify" value="0">
                                            <button type="submit" class=""><i class="bi bi-bell-fill text-warning"></i></button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('schedule.updateNotification', ['id' => $schedule->id]) }}" class="my-3">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="notify" value="1">
                                            <button type="submit" class=""><i class="bi bi-bell-slash-fill text-danger"></i></button>
                                        </form>
                                    @endif

                            </div>
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </div>
</aside>



{{--<button class="notification-btn" data-schedule-id="{{ $schedule->id }}" data-notify-status="{{ $schedule->notify ? 1 : 0 }}">--}}
{{--    @if($schedule->notify)--}}
{{--        <i class="bi bi-bell-fill text-warning"></i>--}}
{{--    @else--}}
{{--        <i class="bi bi-bell-slash-fill text-danger"></i>--}}
{{--@endif--}}
