@props(['currentUserId'])

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>E-Commerce Dashboard</title>

    <meta name="description" content="" />

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        a.disabled {
            pointer-events: none;
        }

        .product_category_data {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .form-label {
            color: #0d6efd;
        }


        .my-tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
            font-family: "Arial", sans-serif;

            display: none;
        }

        .my-tooltip:hover .my-tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .my-tooltiptext {
            visibility: hidden;
            width: 230px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 10px;
            position: absolute;
            z-index: 1;
            top: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .my-tooltiptext::after {
            content: "";
            position: absolute;
            top: -10px;
            left: 50%;
            margin-left: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent #333 transparent;
        }

        .my-tooltip .icon {
            display: inline-block;
            width: 20px;
            height: 20px;
            background-color: red;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
        }



        * {
            box-sizing: border-box;
        }

        .datetimepicker {
            display: inline-flex;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 8px;
        }

        .datetimepicker:focus-within {
            border-color: teal;
        }

        .datetimepicker input {
            font: inherit;
            color: inherit;
            appearance: none;
            outline: none;
            border: 0;
            background-color: transparent;
        }

        .datetimepicker input[type="date"] {
            width: 10rem;
            padding: 0.25rem 0 0.25rem 0.5rem;
            border-right-width: 0;
        }

        .datetimepicker input[type="time"] {
            width: 5.5rem;
            padding: 0.25rem 0.5rem 0.25rem 0;
            border-left-width: 0;
        }

        .datetimepicker span {
            height: 1rem;
            margin-right: 0.25rem;
            margin-left: 0.25rem;
            border-right: 1px solid #ddd;
        }
    </style>

</head>

<body class="sb-nav-fixed">

    <x-dashboard.partials.nav />

    <div id="layoutSidenav">
        <x-dashboard.partials.aside />

        <div id="layoutSidenav_content">

            <x-messages.flashbag />

            {{ $slot }}

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

    </div>





    <!-- endbuild -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables-simple-demo.js') }}"></script>

    {{-- <script src="{{ asset('js/myScripts/script.js') }}"></script> --}}

    {{ $js }}

</body>

</html>
