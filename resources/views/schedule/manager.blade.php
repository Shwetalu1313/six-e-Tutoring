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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-ban-fill"></i> {{session('error')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Schedule Manager</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:80px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    @include('schedule.managerPg.filter')
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-listing-tab" data-bs-toggle="tab" data-bs-target="#nav-listing"
                    type="button" role="tab" aria-controls="nav-listing" aria-selected="true">Listing
            </button>
            <button class="nav-link" id="nav-calendar-tab" data-bs-toggle="tab" data-bs-target="#nav-calendar"
                    type="button" role="tab" aria-controls="nav-calendar" aria-selected="false">Calendar
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active p-3" id="nav-listing" role="tabpanel" aria-labelledby="nav-listing-tab"
             tabindex="0">
            @include('schedule.managerPg.listing')
        </div>
        <div class="tab-pane fade" id="nav-calendar" role="tabpanel" aria-labelledby="nav-calendar-tab" tabindex="0">
            @include('schedule.managerPg.calendar')
        </div>
    </div>
</x-layout>


