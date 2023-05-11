<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    @push('style')
        <style>
            .card-box .card .numbers {
                font-size: 405px !important;
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
        <form action="" method="POST" class="mt-2">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <select name="chart_type" id="chart_type" class="form-select">
                        <option value="">--Select Chart Type--</option>
                        <option value="column">Column</option>
                        <option value="bar">Bar</option>
                        <option value="pie">Pie</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_from" id="date_from" placeholder="Date From"
                        class="datepicker form-control" required />
                </div>
                <div class="col-md-3">
                    <input type="text" name="date_to" id="date_to" placeholder="Date To"
                        class="datepicker form-control" required />
                </div>
                <div class="col-md-3">
                    <button class="form-control btn btn-secondary">Generate</button>
                </div>
            </div>
        </form>
        <div class="row chart_report mx-1 my-3">
            <div class="col-md-12 chart_container h-100 bg-white">
                <canvas id="myChart" height="120px"></canvas>
            </div>
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
        </button> --}}

        <!-- Modal -->
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div> --}}
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script type="text/javascript">
             var labels =  {{ Js::from($labels) }};
             var users =  {{ Js::from($data) }};
  
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1,
                        data: users
                    }]
                };

                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                };

                const myChart = new Chart(
                    document.getElementById('myChart'),
                    config
                );
            </script>
        @endpush
    @endcan
</x-app-layout>
