<x-layout title="Dashboard">
    <div class="container-fluid d-flex align-items-center fs-1 fw-bolder my-3">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" class="bi bi-house-door-fill" viewBox="0 0 16 16">
        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
        </svg>
        Dashboard
    </div>
    <div class="container-fluid my-5">
        <div class="fs-3 fw-bold mb-1 d-flex" style="color:rgb(103, 103, 101);">Hello {{ Auth::user()->name }},</div>
        <div class="fs-4 fw-normal mb-1 d-flex align-items-center">
                <div class="container-fuild" style="width: 160px; color:rgb(103, 103, 101);">Welcome back</div>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="rgb(103, 103, 101)" class="bi bi-emoji-wink-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M7 6.5C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5M4.285 9.567a.5.5 0 0 0-.183.683A4.5 4.5 0 0 0 8 12.5a4.5 4.5 0 0 0 3.898-2.25.5.5 0 1 0-.866-.5A3.5 3.5 0 0 1 8 11.5a3.5 3.5 0 0 1-3.032-1.75.5.5 0 0 0-.683-.183m5.152-3.31a.5.5 0 0 0-.874.486c.33.595.958 1.007 1.687 1.007s1.356-.412 1.687-1.007a.5.5 0 0 0-.874-.486.93.93 0 0 1-.813.493.93.93 0 0 1-.813-.493"/>
                </svg>
        </div>
    </div>
    <div class="container pt-4 my-5">
        <div class="row justify-content-center mt-5">
                <div class="col" style="width: auto;">
                    <div class="border border-2 rounded p-3 text-center"
                    style="background: linear-gradient(221deg, rgba(20,32,244,1) 0%, rgba(57,0,181,1) 69%, rgba(75,0,147,1) 100%);">
                        <div class="fs-4 h6 text-light">Students With No Tutor</div>
                        <div><strong class="fs-1 text-danger">{{ $students->count() }}</strong></div>
                        <a href="{{ route('reports.students-with-no-tutor') }}" class="btn btn-dark btn-sm" 
                        style="background: linear-gradient(33deg, rgba(47,48,73,1) 0%, rgba(6,0,12,1) 100%);">
                        See All--></a>
                    </div>
                </div>
                <div class="col mb-5" style="width: auto;">
                    <div class="border border-2 rounded p-3 text-center"
                    style="background: linear-gradient(53deg, rgba(20,32,244,1) 0%, rgba(57,0,181,1) 69%, rgba(75,0,147,1) 100%);">
                        <div class="fs-4 h6 text-light">Inactive Students <span class="text-warning">(28 days)</span></div>
                        <div><strong class="fs-1 text-danger">{{ $inactiveStudents->count() }}</strong></div>
                        <a href="{{ route('reports.all-inactive-students') }}" class="btn btn-dark btn-sm"
                        style="background: linear-gradient(33deg, rgba(47,48,73,1) 0%, rgba(6,0,12,1) 100%);">See
                            All--></a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h1>Main Browser Counts</h1>
                        <!-- Div that will hold the pie chart -->
                        <div id="chart_div" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>

                <div class="table-responsive my-5 ">
                    <h3>The Most Active Users List for This Month ({{ Date('M-Y') }})</h3>
                    <small class="text-black">Staff roles are not counting.</small>
                    <small class="text-danger">Top 10 List.</small>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NO.</th>
                                <th>Name</th>
                                <th>Activity Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $counter = 1;
                            @endphp
                            @foreach ($activeUsersWithNames as $user)
                                
                                <tr>
                                    <td>{{ $counter }}</td>
                                    <td>
                                        <a href="{{ route('user-profile', ['user' => $user['user_id']]) }}"
                                        class="text-decoration-none">
                                        {{ $user['name'] }}
                                        </a></td>
                                    <td>{{ $user['activity_count'] }}</td>
                                </tr>
                                @php
                                    $counter++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                

                <!-- Load the AJAX API -->
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});

                    // Set a callback to run when the Google Visualization API is loaded.
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        // Create the data table dynamically from PHP array
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Browser');
                        data.addColumn('number', 'Count');
                        data.addRows([
                            // Replace the example data with your aggregated browser counts
                            @foreach($browserCounts as $browser => $count)
                                ['{{ $browser }}', {{ $count }}],
                            @endforeach
                        ]);

                        // Set chart options
                        var options = {
                            title: 'Browsers used by users to connect this system',
                            width: '100%',
                            height: 500
                        };

                        // Instantiate and draw the pie chart
                        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                        chart.draw(data, options);
                    }
                </script>
                        
                
        </div>
    </div>
</x-layout>
