<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">{{$data->storeName}}</h5>
                            <p>{{$data->storeAddress}}</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{$data->customerCount}}</h5>
                                    <p class="text-muted mb-0">Customers</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">${{$data->revenueAmount}}</h5>
                                    <p class="text-muted mb-0">Revenue</p>
                                </div>
                            </div>
                            @if(\Cookie::get('user_role') != 'store_assistant')
                                <div class="mt-4">
                                    <a href="#" class="btn btn-primary waves-effect waves-light btn-sm"
                                       data-toggle="modal"
                                       data-target="#DeleteModal">Delete
                                        Assistant
                                    </a>
                                </div>
                                <div id="DeleteModal" class="modal fade bd-example-modal-sm"
                                     tabindex="-2" role="dialog" aria-labelledby="DeleteModal"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="Title">
                                                    Delete Assistant </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Do you want to delete {{$data->name}}?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('assistants.destroy', $data->_id) }}"
                                                      method="POST" id="form">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No,
                                                    I changed my mind
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->

        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Personal Information</h6>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                        <tr>
                            <th scope="row">Full Name :</th>
                            <td>{{$data->name}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Mobile :</th>
                            <td>{{$data->phone_number}}</td>
                        </tr>
                        <tr>
                            <th scope="row">E-mail :</th>
                            <td>{{$data->email}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end card -->

    </div>

    <div class="col-xl-8">

        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Revenue</p>
                                <h4 class="mb-0">$ {{$data->revenueAmount}}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Debt</p>
                                <h4 class="mb-0">${{$data->debtAmount}}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Receivables</p>
                                <h4 class="mb-0">${{$data->receivablesAmount}}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Total Transactions</h6>
                <div id="transactionchart"></div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#Ref ID</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($data->recentTransactions) == 0)
                            <tr>
                                <td colspan="4" class="text-center"> No Recent Transactions</td>
                            </tr>
                        @else
                            @foreach($data->recentTransactions as $transaction)

                                <tr>
                                    <th scope="row">{{$transaction->_id}}</th>
                                    <td>Customer Name <br> <span class="font-size-14">
                                            {{$transaction->customer_ref_id}}</span></td>
                                    <td>{{$transaction->total_amount}}</td>
                                    <td>Debt</td>
                                    <td>
                                        <div class="btn-group mt-2 mr-1">
                                            <button type="button" class="btn btn-info dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Actions<i class="icon"><span
                                                            data-feather="chevron-down"></span></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="">Send debt reminder</a>
                                                <a class="dropdown-item" href="">View Transaction</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section("javascript")
    {{-- <script src="/backend/assets/js/pages/dashboard.js"></script> --}}
    <script>
        $(document).ready(function () {
            // start of transaction charts
            var options = {
                series: [{
                    name: 'Transaction',
                    data: {{json_encode($data->chart)}},
                }],
                chart: {
                    height: 350,
                    type: 'line',
                },
                stroke: {
                    width: 7,
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'text',
                    categories: ['JAN', 'FEB', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUG',
                        'SEPT', 'OCT', 'NOV', 'DEC'],
                },
                title: {
                    text: '',
                    align: 'left',
                    style: {
                        fontSize: "16px",
                        color: '#666'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ['#FDD835'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                markers: {
                    size: 4,
                    colors: ["#FFA41B"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    //min: -10,
                    // max: 40,
                    title: {
                        text: 'Transaction',
                    },
                }
            };

            var chart = new ApexCharts(document.querySelector("#transactionchart"), options);
            chart.render();


        });

    </script>
@endsection

