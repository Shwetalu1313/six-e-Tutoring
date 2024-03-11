<article class="col-lg-8">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Create Schedule</div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check2-circle text-success"></i> {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div @class(['card','shadow'])>
        <div
            @class([
           'card-header',
           'text-center',
           'fs-3'
           ])

            @style([
            'background: linear-gradient(183deg, rgba(244,113,20,0.14058123249299714) 0%, rgba(0,212,255,0.19380252100840334) 100%)',
            ])>
            Choose Meeting Time
        </div>
        <form action="{{route('schedule.store')}}" method="post" @class(['card-body'])
        style="background: linear-gradient(360deg, rgba(244,113,20,0.09016106442577032) 0%, rgba(0,212,255,0.10416666666666663) 100%);">
            @csrf
            @method('POST')
            <div class="mb-3 col" id="titleInputDiv">
                <label for="titleInput" class="form-label">Title</label>
                <input type="text" class="form-control" id="titleInput" name="title" required>
            </div>
            <div @class(['row'])>
                <div class="mb-3 col">
                    <label for="Date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="Date" name="date" required>
                </div>
                <div class="mb-3 col">
                    <label for="Time" class="form-label">Time</label>
                    <input type="time" class="form-control" id="Time" name="time" required>
                </div>
                <span class="hidden text-warning mb-3" id="DatetimeSpan"></span>
                <hr>

            </div>
            <div class="row mb-3">
                <div class="mb-3 col">
                    <label for="selLocation" class="form-label" >Location</label>
                    <select class="form-select" aria-label="Location" name="locationType" id="selLocation">
                        <option disabled>Choose Location</option>
                        <option value="reality">Reality Meeting</option>
                        <option value="virtual">Virtual Meeting</option>
                        <option value="none" selected>none</option>
                    </select>
                </div>
                {{--        Reality        --}}
                <div class="mb-3 col" id="reality">
                    <label for="location-reality" class="form-label">Address</label>
                    <input type="text" class="form-control" id="location-reality" name="location_reality" placeholder="white center house">
                </div>
                {{--        Virtual        --}}
                <div class="mb-3 col" id="virtual">
                    <label for="location-virtual" class="form-label">Url</label>
                    <input type="text" class="form-control" id="location-virtual" name="location_virtual" placeholder="https://...">
                    <button type="button" class="btn btn-warning mt-3 float-end" id="paste"><i class="bi bi-clipboard-check me-3"></i>Paste</button>
                </div>
            </div>

            <div class="mb-3 col" id="description">
                <textarea class="form-control" rows="2" name="description" placeholder="Description"></textarea>
            </div>

            <div class="form-check col mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="important" name="important">
                <label class="form-check-label" for="important">
                    Save as <em>Important </em> <i class="ms-1 bi bi-exclamation-octagon text-danger"></i>
                </label><br>
            </div>
            <hr>

            <div class="form-check col mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="notifyMe" name="notify" checked>
                <label class="form-check-label" for="notifyMe">
                    Notify Me <i class="bi bi-bell-fill text-warning"></i>
                </label><br>
            </div>
            <figcaption class="blockquote-footer">
                We will notify you before <cite title="Source Title">One Hour</cite>
            </figcaption>

            <button type="submit" class="btn btn-primary float-end"><i class="bi bi-floppy2 me-3"></i> Save</button>

        </form>
    </div>
</article>
