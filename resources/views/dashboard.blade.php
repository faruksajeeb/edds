<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    @push('styles')
        <style>
            .card-box .card .numbers {
                font-size: 405px !important;
            }

            #svgDistrictWiseMap {
                width: 940px;
                height: 1270px;
            }
        </style>
    @endpush
    @can('dashboard.view')
        {{-- <div class="card-box p-1">
            <div class="card mx-1">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers">0</div>
                        <div class="card-name">Total Poultry Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-kiwi-bird display-6 "></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Total Bird Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-dove display-6"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Today Poultry Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-kiwi-bird display-6 "></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="numbers"> 0</div>
                        <div class="card-name">Today Bird Infected</div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center border-start">
                        <div class="iconBox">
                            <i class="fa-solid fa-dove display-6"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <hr> --}}
        <form action="" method="POST" class="mt-2 chart_form">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select name="chart_type" id="chart_type" class="form-select">
                        <option value="">--Select Chart Type--</option>
                        <option value="bar" {{ $chart_type == 'bar' ? 'selected' : '' }}>Bar</option>
                        <option value="pie" {{ $chart_type == 'pie' ? 'selected' : '' }}>Pie</option>
                        <option value="line" {{ $chart_type == 'line' ? 'selected' : '' }}>Line</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_from" id="date_from" placeholder="Date From"
                        class="datepicker form-control" value="{{ $date_from }}" required />
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_to" id="date_to" placeholder="Date To"
                        class="datepicker form-control" value="{{ $date_to }}" required />
                </div>
                <div class="col-md-3">
                    <button class="form-control btn btn-secondary generate_btn" type="submit" name="submit_btn"
                        value="submit_btn">Generate</button>
                </div>
            </div>
        </form>
        <div class="row chart_report mx-1 my-3">
            @if ($chart_type == 'pie')
                <h5 class="text-center bg-white p-3">Division Wise Response Data</h5>
                @foreach ($categories as $category)
                    <div class="col-md-4 chart_container h-100 bg-white py-3">
                        <canvas id="myPieChart{{ $category->id }}" height="150px"></canvas>
                    </div>
                @endforeach
            @else
                <div class="col-md-12 chart_container h-100 bg-white">
                    <canvas id="myChart" height="120px"></canvas>
                </div>
            @endif

        </div>


        {{-- <div class="row align-items-md-stretch">
            <div class="col-md-3">
                <div class="h-100 p-5 text-dark bg-white rounded-3 text-center">
                    <h2>5000+</h2>
                    <p>Daily Views</p>
                    <div class="iconBox">
                        <i class="fa fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="h-100 p-5 text-dark bg-white rounded-3 text-center">
                    <h2>1200</h2>
                    <p>Sales</p>
                    <div class="iconBox">
                        <i class="fa fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="h-100 p-5 text-dark bg-white rounded-3 text-center">
                    <h2>2000</h2>
                    <p>Purchase</p>
                    <div class="iconBox">
                        <i class="fa fa-eye"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="h-100 p-5 text-dark bg-white rounded-3 text-center">
                    <h2>100</h2>
                    <p>Comments</p>
                    <div class="iconBox">
                        <i class="fa fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="mt-4">Gutters</h2>
        <div class="row row-cols-1 row-cols-md-3 gx-4 m-1">
            <div class="col themed-grid-col text-center">
                <div class="iconBox">
                    <i class="fa fa-eye"></i>
                </div>
                <div>
                    <div class="numbers">1,024</div>
                    <div class="card-name">Comments</div>
                </div>

            </div>
            <div class="col themed-grid-col"><code>.col</code> with <code>.gx-4</code> gutters</div>
            <div class="col themed-grid-col"><code>.col</code> with <code>.gx-4</code> gutters</div>
            <div class="col themed-grid-col"><code>.col</code> with <code>.gx-4</code> gutters</div>
            <div class="col themed-grid-col"><code>.col</code> with <code>.gx-4</code> gutters</div>
            <div class="col themed-grid-col"><code>.col</code> with <code>.gx-4</code> gutters</div>
        </div>
        <hr />
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> 
        
        --}}

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
                var labels = {{ Js::from($labels) }};
                var responses = {{ Js::from($data) }};
                @if ($chart_type == 'pie')
                    @foreach ($categories as $category)
                        const data{{ $category->id }} = {
                            labels: labels,
                            datasets: [{
                                label: '{{ $category->option_value }} Total',
                                data: responses[{{ $category->id }}],
                                // data: [0,2,3,4,5,6,7,8],
                                backgroundColor: [
                                    'rgb(255, 99, 132)',
                                    'rgb(54, 162, 235)',
                                    'rgb(255, 132, 0)',
                                    'rgb(209, 77, 114)',
                                    'rgb(255, 217, 90)',
                                    'rgb(164, 89, 209)',
                                    'rgb(44, 211, 225)',
                                    'rgb(153, 169, 143)',
                                    'rgb(82, 109, 130)',
                                ],
                                hoverOffset: 4
                            }]
                        };
                        const config{{ $category->id }} = {
                            type: 'pie',
                            data: data{{ $category->id }},
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: '{{ $category->option_value }}'
                                    }
                                }
                            },
                        };
                        const myChart{{ $category->id }} = new Chart(
                            document.getElementById("myPieChart{{ $category->id }}"),
                            config{{ $category->id }}
                        );
                    @endforeach
                @else

                    const data = {
                        labels: labels,
                        datasets: [
                            @foreach ($categories as $key => $category)

                                {
                                    label: "{{ $category->option_value }}",
                                    // backgroundColor: [
                                    //     'rgba(255, 99, 132, 0.2)',
                                    //     'rgba(255, 159, 64, 0.2)',
                                    //     'rgba(255, 205, 86, 0.2)',
                                    //     'rgba(75, 192, 192, 0.2)',
                                    //     'rgba(54, 162, 235, 0.2)',
                                    //     'rgba(153, 102, 255, 0.2)',
                                    //     'rgba(201, 203, 207, 0.2)'
                                    // ],
                                    // borderColor: [
                                    //     'rgb(255, 99, 132)',
                                    //     'rgb(255, 159, 64)',
                                    //     'rgb(255, 205, 86)',
                                    //     'rgb(75, 192, 192)',
                                    //     'rgb(54, 162, 235)',
                                    //     'rgb(153, 102, 255)',
                                    //     'rgb(201, 203, 207)'
                                    // ],
                                    borderWidth: 1,
                                    data: responses[{{ $category->id }}]
                                },
                            @endforeach
                        ]
                    };

                    const config = {
                        type: '{{ $chart_type }}',
                        data: data,
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Division Wise Response Data'
                                }
                            }
                        }
                    };
                    const myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
                @endif


                $(document).on('click', ".generate_btn", function() {
                    $('.generate_btn').html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generating...'
                    );
                });
            </script>
        @endpush
    @endcan
</x-app-layout>
