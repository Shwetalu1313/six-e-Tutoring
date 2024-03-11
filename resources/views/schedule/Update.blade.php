<x-layout>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check2-circle text-success"></i> {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Update Schedule</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:80px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>

    <div @class(['card','shadow', 'mb-5'])>
        <div
            @class([
           'card-header',
           'text-center',
           'fs-3'
           ])

            @style([
            'background: linear-gradient(183deg, rgba(244,113,20,0.14058123249299714) 0%, rgba(0,212,255,0.19380252100840334) 100%)',
            ])>
            Meeting Review
        </div>
        <form action="{{url('schedule/'. $schedule->id)}}" method="post" @class(['card-body'])
        style="background: linear-gradient(360deg, rgba(244,113,20,0.09016106442577032) 0%, rgba(0,212,255,0.10416666666666663) 100%);">
            @csrf
            @method('PUT')
            <div class="mb-3 col" id="titleInputDiv">
                <label for="titleInput" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleInput" name="title" required value="{{$schedule->title}}">
            </div>
            <div @class(['row'])>
                <div class="mb-3 col">
                    <label for="Date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="Date" name="date" value="{{$schedule->date}}" required>
                </div>
                <div class="mb-3 col">
                    <label for="Time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="Time" value="{{$schedule->time}}" name="time" required>
                </div>
                <span class="hidden text-warning mb-3" id="DatetimeSpan"></span>
                <hr>

            </div>
            <div class="row mb-3">
                <div class="mb-3 col">
                    <label for="selLocation" class="form-label" >Location</label>
                    <select class="form-select" aria-label="Location" name="locationType" id="selLocation">
                        <option disabled>Choose Location</option>

                        <option value="reality" {{$schedule->locationType === 'reality' ? 'selected' : ''}}>Reality Meeting</option>
                        <option value="virtual" {{$schedule->locationType === 'virtual' ? 'selected' : ''}}>Virtual Meeting</option>
                        <option value="none" {{$schedule->locationType === 'none' ? 'selected' : ''}}>none</option>
                    </select>
                </div>
                {{--        Reality        --}}
                <div class="mb-3 col" id="reality">
                    <label for="location-reality" class="form-label">Address</label>
                    <input type="text" class="form-control" id="location-reality" name="location_reality" placeholder="white center house" value="{{$schedule->location}}">
                </div>
                {{--        Virtual        --}}
                <div class="mb-3 col" id="virtual">
                    <label for="location-virtual" class="form-label">Url</label>
                    <input type="text" class="form-control" id="location-virtual" name="location_virtual" placeholder="https://..." value="{{$schedule->locationType === 'virtual' ? $schedule->location : ''}}">
                    <button type="button" class="btn btn-warning mt-3 float-end" id="paste"><i class="bi bi-clipboard-check me-3"></i>Paste</button>
                </div>
            </div>

            <div class="mb-3 col" id="description">
                <textarea class="form-control" rows="2" name="description" placeholder="Description"> {{$schedule->description}}</textarea>
            </div>

            <div class="form-check col mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="important" name="important" {{$schedule->important ? 'checked' : ''}}>
                <label class="form-check-label" for="important">
                    Save as <em>Important </em> <i class="ms-1 bi bi-exclamation-octagon text-danger"></i>
                </label><br>
            </div>
            <hr>

            <div class="form-check col mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="notifyMe" name="notify" {{$schedule->notify ? 'checked' : ''}}>
                <label class="form-check-label" for="notifyMe">
                    Notify Me <i class="bi bi-bell-fill text-warning"></i>
                </label><br>
            </div>

            <figcaption class="blockquote-footer">
                We will notify you before <cite title="Source Title">One Hour</cite>
            </figcaption>

            <button type="submit" class="btn btn-primary float-end" onclick="window.confirm('Are you sure to update?')"><i class="bi bi-floppy2 me-3"></i> Update</button>

        </form>
    </div>

    <div @class(['card'])>

    </div>
</x-layout>
