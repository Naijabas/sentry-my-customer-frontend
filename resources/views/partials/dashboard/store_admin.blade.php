<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back !</h5>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="/backend/assets/images/users/avatar-1.jpg" alt=""
                                 class="img-thumbnail rounded-circle">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ Cookie::get('first_name') }}</h5>
                        <p class="text-muted mb-0 text-truncate">Store Admin</p>
                    </div>

                    <div class="col-sm-8">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $data->customerCount }}</h5>
                                    <p class="text-muted mb-0">Customers</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $data->storeCount }}</h5>
                                    <p class="text-muted mb-0">Store(s)</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{route('setting')}}" class="btn btn-primary waves-effect waves-light btn-sm">View
                                    Profile
                                    <i class="uil-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end --}}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Monthly Earnings</h5>
                <div class="row">
                    <div class="col-sm-6">
                        <p class="text-muted">This month</p>
                        <h3>${{$data->amountForCurrentMonth}}</h3>
                        <p class="text-muted"><span class="text-{{$profit['profit']? 'success':'danger'}} mr-2"> {{$profit['percentage']}}
                                % <i class="mdi mdi-arrow-down"></i>
                                </span> From
                            previous month</p>

                        <div class="mt-4">
                            <a href="{{route('transaction.index')}}"
                               class="btn btn-primary waves-effect waves-light btn-sm">
                                View More <i class="uil-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Debt</p>
                                <h4 class="mb-0">${{$data->debtAmount}}</h4>
                            </div>

                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
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
                                <p class="text-muted font-weight-medium">Revenue</p>
                                <h4 class="mb-0">${{$data->revenueAmount}}</h4>
                            </div>

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
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

                            <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                                    <span class="avatar-title rounded-circle bg-primary">
                                        <i class="uil-atm-card font-size-14"></i>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Transaction Overview {{date('Y')}}</h6>
                <div class="clearfix"></div>
                <div id="transactionchart"></div>
            </div>
        </div>
    </div>
</div>

<!-- products -->
<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body pt-2">
                <h5 class="mb-4 header-title">Recent Transactions</h5>
                <div style="display:flex; justify-content:center; text-align:center; width:100%"
                     class='mt-2 mb-3 trans-error'>

                </div>

                <div class="table-responsive mt-4 trans-table">

                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                        <tr>
                            <th scope="col">Store Name</th>

                            <th scope="col">Type</th>
                            <th scope="col">Amount</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>

                        <tbody class="my-transactionsb">
                        @if(count($data->recentTransactions) > 0)
                            @foreach($data->recentTransactions as $recentTransaction)
                                <tr>
                                    <td>{{$recentTransaction->storeName}}</td>
                                    <td>{{$recentTransaction->transaction->type}}</td>
                                    <td>{{$recentTransaction->transaction->amount}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('transaction.show', $recentTransaction->transaction->_id.'-'.$recentTransaction->transaction->store_ref_id.'-'.$recentTransaction->transaction->customer_ref_id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No Recent Transaction</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive-->
            </div>
            <!-- end card-body-->
        </div>
        <!-- end card-->
    </div>
    <!-- end col-->

    <div class="col-xl-5">
        <div class="card">
            <div class="card-body pt-2">
                <h5 class="mb-4 header-title">Latest Debts</h5>
                <div style="display:flex; justify-content:center; text-align:center; width:100%"
                     class='mt-2 mb-3 debts-error'>
                </div>

                <div class="debts-table">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                        <tr>
                            <th scope="col">Store Name</th>
                            <th scope="col">Status</th>
                            <th scope="col">Amount</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>

                        <tbody class="my-transactionsb">
                        @if(count($data->recentDebts) > 0)
                            @foreach($data->recentDebts as $recentDebt)
                                <tr>
                                    <td>{{$recentDebt->storeName}}</td>
                                    <td>
                                        @if($recentDebt->debt->status)
                                            <span class="badge badge-success">Paid</span>
                                        @else
                                            <span class="badge badge-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>{{$recentDebt->debt->amount}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('debtor.show', $recentDebt->debt->_id) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No Recent Debts</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

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

    {{-- @if ( Cookie::get('is_first_time_user') == true) --}}
    <script>
        var dashboard_intro_shown = localStorage.getItem('dashboard_intro_shown');

        if (!dashboard_intro_shown) {

            const tour = new Shepherd.Tour({
                defaults: {
                    classes: "shepherd-theme-arrows"
                }
            });

            tour.addStep("step", {
                text: "Welcome to mycustomer web app.",
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ]
            });

            tour.addStep("step2", {
                text: "first, create a store",
                attachTo: {element: ".second", on: "left"},
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ],

                beforeShowPromise: function () {
                    document.body.className += ' sidebar-enable';
                    document.getElementById('sidebar-menu').style.height = 'auto';
                },
            });
            tour.addStep("step3", {
                text: "Then create a customer",
                attachTo: {element: ".third", on: "left"},
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ]
            });
            tour.addStep("step4", {
                text: "create your transaction",
                attachTo: {element: ".fourth", on: "left"},
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ]
            });
            tour.addStep("step5", {
                text: "Send broadcast messages here",
                attachTo: {element: ".fifth", on: "left"},
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ]
            });
            tour.addStep("step6", {
                text: "make your complaints here",
                attachTo: {element: ".sixth", on: "left"},
                buttons: [
                    {
                        text: "Next",
                        action: tour.next
                    }
                ]
            });

            // tour.addStep("step7", {
            //     text: "manage your stores",
            //     attachTo: {element: ".seventh", on: "right"},
            //     buttons: [
            //         {
            //             text: "Next",
            //             action: tour.next
            //         }
            //     ]
            // });

            tour.start();
            localStorage.setItem('dashboard_intro_shown', 1);
        }
    </script>
    {{-- @endif --}}

@endsection
