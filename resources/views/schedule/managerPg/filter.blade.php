<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasForm">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasFormLabel">Schedule Filter</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" title="It only filter your schedules."></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('schedule.filter') }}" method="get" class="form-group">
            @csrf
            @method('GET')
            <div class="row">
                <!-- Title Input -->
                <div class="col-lg-12">
                    <label class="form-label">
                        Title:
                        <input class="form-control" name="title" type="text" placeholder="Enter title...">
                    </label>
                </div>
            </div>
            <hr>
            <!-- Date and Time Inputs -->
            <div class="row g-3">
                <div class="col">
                    <label class="form-label">
                        Date:
                        <input class="form-control" name="date" type="date">
                    </label>
                </div>
                <div class="col">
                    <label class="form-label">
                        Time:
                        <input class="form-control" name="time" type="time">
                    </label>
                </div>
            </div>
            <hr>
            <!-- Location Select -->
            <select class="form-select" name="selectLocation" aria-label="Location Type">
                <option disabled selected>Location Type</option>
                <option value="virtual">Virtual Meeting</option>
                <option value="reality">Reality Meeting</option>
                <option value="none">None of Them</option>
            </select>
            <hr>
            <!-- Importance Checkboxes -->
            <div class="col-md-12 mt-3">
                <label class="form-check">
                    <input class="form-check-input" name="important" type="checkbox" value="1">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    Is important?
                </label>
            </div>
            <div class="col-md-12 mt-3">
                <label class="form-check">
                    <input class="form-check-input" name="important_not" type="checkbox" value="1">
                    🤏🏻 Is not important?
                </label>
            </div>
            <hr>
            <!-- Notification Checkboxes -->
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="notify_accept" type="checkbox" value="1">
                    <i class="bi bi-bell-fill "></i>
                    Notify Accept?
                </label>
            </div>
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="notify_dis" type="checkbox" value="1">
                    <i class="bi bi-bell-slash-fill"></i>
                    Notify Disable?
                </label>
            </div>
            <hr>
            <!-- Confirmation and Pending Checkboxes -->
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="confirm" type="checkbox" value="1">
                    <i class="bi bi-bookmark-check-fill "></i>
                    Meeting confirmed?
                </label>
            </div>
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="pending" type="checkbox" value="1">
                    <i class="bi bi-clock-history"></i>
                    Meeting pending?
                </label>
            </div>
            <hr>
            <!-- Expired and Waiting Checkboxes -->
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="expired" type="checkbox" value="1">
                    <i class="bi bi-hourglass-bottom"></i>
                    Expired?
                </label>
            </div>
            <div class="col-md-12">
                <label class="form-check">
                    <input class="form-check-input" name="waiting" type="checkbox" value="1">
                    <i class="bi bi-hourglass-split"></i>
                    Waiting
                </label>
            </div>
            <hr>
            <!-- Filter Button -->
            <div class="text-center">
                <button type="submit" class=""><i class="bi bi-funnel-fill"></i> Filter</button>
            </div>
        </form>
    </div>
</div>

<button type="button" class="mb-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvasForm" aria-controls="offcanvasForm">
    <i class="bi bi-filter"></i> Filter
</button>
