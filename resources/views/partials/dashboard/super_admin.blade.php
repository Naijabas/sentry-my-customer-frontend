<!-- content -->
<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Store Admin</span>
                        <h2 class="mb-0 store-admins">
                            @if ($response != null)
                                {{ $response[0]->data->storeAdminCount }}
                            @else
                                0
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Stores</span>
                        <h2 class="mb-0 my-stores">
                            @if ($response != null)
                                {{ $response[0]->data->storesCount }}
                            @else
                                0
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Assistants</span>
                        <h2 class="mb-0 my-assistants">
                            @if ($response != null)
                                {{ $response[0]->data->assistantsCount }}
                            @else
                                0
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Customers</span>
                        <h2 class="mb-0 my-customers">
                            @if ($response != null)
                                {{ $response[0]->data->customerCount }}
                            @else
                                0
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">Users</span>
                        <h2 class="mb-0 my-users">
                            @if ($response != null)
                                {{ $response[0]->data->usersCount }}
                            @else
                                0
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- products -->
<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mt-0 mb-0 header-title">Recent Transactions</h5>

                <div class="table-responsive mt-4">
                    <table class="table table-hover table-nowrap mb-0">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Type</th>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>

                        <tbody class="my-transactions">

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

                {{-- @if ($response != null)
                        @if (count($response[2]->data->debts) > 0)
                            @if (count($response[2]->data->debts) > 7)
                                @for ($i = 0; $i < 7; $i++) --}}
                {{-- <div class="media mt-1 border-top pt-3">
                                        <div class="media-body">
                                            <h6 class="mt-1 mb-0 font-size-15">{{ $response[2]->data->debts[$i]->pay_date }}
                </h6>
                <h6 class="text-muted font-weight-normal mt-1 mb-3">{{ $response[2]->data->debts[$i]->pay_date }}
                </h6>
            </div>
            <div class="dropdown align-self-center float-right">
                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown"
                    aria-expanded="false">
                    <i class="uil uil-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" class="dropdown-item"><i
                            class="uil uil-edit-alt mr-2"></i>View</a>
                </div>
            </div>
        </div> --}}
                {{-- @endfor
                                    @else
                                        {{ $i = 0 }}
                @foreach ($response[2]->data->debts as $transaction) --}}
                {{-- <div class="media mt-1 border-top pt-3">
                                                <div class="media-body">
                                                    <h6 class="mt-1 mb-0 font-size-15">Some Title</h6>
                                                    <h6 class="text-muted font-weight-normal mt-1 mb-3">{{ $response[2]->data->debts[$i]->pay_date }}
                </h6>
            </div>
            <div class="dropdown align-self-center float-right">
                <a href="#" class="dropdown-toggle arrow-none text-muted" data-toggle="dropdown" aria-expanded="false">
                    <i class="uil uil-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:void(0);" class="dropdown-item"><i class="uil uil-edit-alt mr-2"></i>View</a>
                </div>
            </div>
        </div> --}}
                {{-- {{ $i++ }}
                @endforeach
                @endif
                @else
                <h5>No recent debtors</h5>
                @endif
                @else
                <h5>Error while fetching data. <a href="">Refresh Page</a></td>
                    @endif --}}
            </div>
        </div>
    </div>
</div>
<!-- end row -->

@section("javascript")
    {{-- <script src="/backend/assets/js/pages/dashboard.js"></script> --}}


    <script>
        document.addEventListener('DOMContentLoaded', getDashboard);

        async function getDashboard() {

            let apiToken = "{{\Illuminate\Support\Facades\Cookie::get('api_token')}}";

            const res = await fetch(`https://dev.api.customerpay.me/dashboard/all?token=${apiToken}`);
            const dash = await res.json();

            // let storeAdmin = document.querySelector('.store-admins');
            // let myStores = document.querySelector('.my-stores');
            // let myAssistants = document.querySelector('.my-assistants');
            // let myUsers = document.querySelector('.my-users');
            // let myCustomers = document.querySelector('.my-customers');

            // storeAdmin.innerText = dash.data.storeAdminCount;
            // myStores.innerText = dash.data.storeCount;
            // myAssistants.innerText = dash.data.assistantsCount;
            // myUsers.innerText = dash.data.usersCount;
            // myCustomers.innerText = dash.data.customerCount;

            if (true) {
                document.querySelector('.table-responsive').innerHTML =
                    `
                <div style="display:flex; justify-content:center; border-top: 1px solid #eee; padding-top: 25px">
                <h5 style="text-align:center; margin-top: 5px">Opps, no transactions yet</h5>
                </div>
            `
            } else {
                dash.transactions.forEach(item => {
                    myTransactions.innerHTML +=
                        `
                <tr>
                    <td>Input</td>
                    <td>Input</td>
                    <td>Input</td>
                    <td>
                        <a href=""><span class="badge badge-soft-warning py-1">View</span></a>
                    </td>
                </tr>
                `
                });
            }
            console.log(dash)
        }


    </script>

    {{-- @if (\Illuminate\Support\Facades\Cookie::get('is_first_time_user') == true) --}}
    <!--    <script>
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
                    text: "First thing you do is create a store",
                    attachTo: { element: ".second", on: "right" },
                    buttons: [
                        {
                            text: "Next",
                            action: tour.next
                        }
                    ],
                    beforeShowPromise: function() {
                        document.body.className += ' sidebar-enable';
                        document.getElementById('sidebar-menu').style.height = 'auto';
                    },
                });
                tour.start();
                localStorage.setItem('dashboard_intro_shown', 1);
            }
        </script> -->
    {{-- @else --}}
@endsection
