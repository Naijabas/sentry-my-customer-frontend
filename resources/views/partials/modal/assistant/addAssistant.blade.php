<div id="addAssistantModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addAssistantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAssistantModalLabel">Add New Assistant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action=" {{ route('assistants.store') }}" method="POST" class="form-horizontal" id="submitForm">
                    @csrf

                    <div class="form-group row mb-2">
                        <label for="name" class="col-2 col-sm-3 col-form-label my-label">Name:</label>
                        <br>
                        <div class="col-10 col-sm-7">
                            <input name="name" type="text" class="form-control" id="name" placeholder="Enter name here"
                                value="{{old('name')}}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="address" class="col-2 col-sm-3 col-form-label my-label">Email:</label>
                        <br>
                        <div class="col-10 col-sm-7">
                            <input name="email" type="email" class="form-control" id="email" placeholder="Enter Address"
                                value="{{old('email')}}">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="inputphone" class="col-2 col-sm-3 col-form-label my-label">Phone Number:</label>
                        <br>
                        <div class="col-10 col-sm-7">
                            <input type="tel" class="form-control" id="phone" placeholder="Phone Number"
                                aria-describedby="helpPhone" name="" required pattern=".{6,16}"
                                title="Phone number must be between 6 to 16 characters">
                            <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                            <small id="helpPhone" class="form-text text-muted">Enter your number without the starting 0,
                                eg 813012345</small>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="number" class="col-2 col-sm-3 col-form-label my-label">Store:</label>
                        <br>
                        <div class="col-10 col-sm-7">
                            <select name="store_id" id="store_id" class="form-control">
                                <option value=""> Select Store</option>
                                @foreach($stores as $store)
                                @if(is_array($store))
                                <option value="{{$store[0]->_id}}">{{$store[0]->store_name}}</option>
                                @else
                                <option value="{{$store->_id}}">{{$store->store_name}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="email" class="col-2 col-sm-3 col-form-label my-label">Password:</label>
                        <br>
                        <div class="col-10 col-sm-7">
                            <input name="password" type="password" class="form-control" id="fullname"
                                placeholder="Enter password">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <label for="email" class="col-2 col-sm-3 col-form-label my-label"></label>
                        <br />
                        <div class="col-10 col-sm-7">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-button btn-block">Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
