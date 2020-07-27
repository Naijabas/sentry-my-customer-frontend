@extends('layout.base')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/css/all_users.css')}}">
@stop
    @section('content')
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-md-12">
                        <nav aria-label="breadcrumb" class="float-right mt-1">
                            <a href="/admin/transaction" class="btn btn-primary">Go Back</a>
                        </nav>
                        <h4 class="mt-2">Edit Transaction</h4>
                    </div>
                </div>
                
                @include('partials.alert.message')
                
                <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                            <div class="card-body">
                                    <form action="" method="POST">
                                      @csrf
                                      @method('PUT')
                                      <div class="form-group row mb-3">
                                        <label for="amount" class="col-3 col-form-label">Amount</label>
                                        <div class="col-9">
                                            <input type="number" class="form-control" id="amount" name="amount" value=""
                                                placeholder="Amount">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="interest" class="col-3 col-form-label">Interest</label>
                                        <div class="col-9">
                                            <input type="number" class="form-control" id="interest" name="interest" value="" placeholder="Interest" >
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="total_amount" class="col-3 col-form-label">Total amount</label>
                                        <div class="col-9">
                                            <input type="number" class="form-control" id="total_amount" name="total_amount" value="" placeholder="Total amount">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="description" class="col-3 col-form-label">Description</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="description" name="description" value="" placeholder="Description">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="transaction_name" class="col-3 col-form-label">Transaction Name</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="transaction_name" name="transaction_name" value="" placeholder="Transaction Name">
                                        </div>
                                    </div>
                                     <div class="form-group row mb-3">
                                        <label for="transaction_role" class="col-3 col-form-label">Transaction role</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="transaction_role" name="transaction_role" value="" placeholder="Transaction Role">
                                        </div>
                                    </div>
                                     <div class="form-group row mb-3">
                                        <label for="store_name" class="col-3 col-form-label">Store Name</label>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="store_name" name="store_name" value="" placeholder="Store Name">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-3">
                                        <label for="transaction_type" class="col-3 col-form-label">Transaction Type</label>
                                        <div class="col-9">
                                            <select id="transaction_type" name="transaction_type" class="form-control">
                                                
                                                <option value=""></option>
                                                <option value="Receivables">Receivables</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Debt">Debt</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    
                                        <button type="submit" class="btn btn-success">
                                            Update Changes
                                        </button>
                                    </form>
                                </div>
                             </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        
              </div>
            </div>
          </div>
@endsection

@section("javascript")
   <script src="/backend/assets/build/js/intlTelInput.js"></script>
   <script>
   var input = document.querySelector("#phone");
   window.intlTelInput(input, {
       // any initialisation options go here
   });
   </script>
@stop
