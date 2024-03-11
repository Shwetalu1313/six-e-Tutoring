<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? env('APP_NAME', 'Six E-Tutoring') }}</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <!-- Option 1: Include in HTML -->
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"> --}}
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css"
        integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{--    JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Quill Text Editor --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    @vite(['resources/js/schedule.js'])

    {{-- calendar --}}
    {{--    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>




    <style>
        .blog {
            background-color: rgb(245, 250, 254);
        }

        .openModalBtn:hover {
            text-decoration: underline;
        }

        .clickable {
            background: black;
        }
        .clickable:hover {
            background-color: rgb(255, 255, 255);
            cursor: pointer;
        }
        .bingo:hover {
            margin: 5px 0;
        }
        .clickable:hover::after {

        }

        .clickable:active {
            background-color: #e3e3e3;
        }

        #calendar {
            max-width: 900px;
            margin: 0 auto;
        }
        .font-weight-bold{
            font-weight: 600;
        }
    </style>
</head>

<body>
    <x-navbar />
    <div class="container min-vh-100 pt-3">
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session()->get('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-success">{{ session()->get('error') }}</div>
        @endif
            {{ $slot }}
        </div>
        <footer class="text-light text-center py-4" style="margin-top: auto; background: linear-gradient(40deg, rgba(36,3,19,1) 0%, rgba(0,2,60,1) 53%, rgba(40,7,74,1) 100%);">
            <div class="container text-center text-md-left">
                <div class="fs-3 fw-bold text-uppercase text-center mb-1">Creative Builders</div>
                <hr style="width: 10rem" class="mx-auto">
                <div class="row text-center text-md-left">
                    <div class="colmx-auto my-3">
                        <div class="fs-4 fw-bold text-uppercase mb-1 text-info">Group Members</div>
                        <div class="fs-6 fw-normal mb-1">Khant Nyein Naing</div>
                        <div class="fs-6 fw-normal mb-1">Shwe Lin Lae Kyaw</div>
                        <div class="fs-6 fw-normal mb-1">Phyo Min Paing</div>
                        <div class="fs-6 fw-normal mb-1">Hnin Nandar Aung</div>
                        <div class="fs-6 fw-normal mb-1">Htoo Pyae Aung</div>
                        <div class="fs-6 fw-normal mb-1">Loon Pann Phyu</div>
                        <div class="fs-6 fw-normal mb-1">Pyae Sone</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container text-center text-md-left">
                <p>&copy; {{ Date('Y') }} <span class="text-warning">Creative Builder</span>. All rights reserved.</p>
            </div>
        </footer>
    @stack('scripts')
</body>

</html>
