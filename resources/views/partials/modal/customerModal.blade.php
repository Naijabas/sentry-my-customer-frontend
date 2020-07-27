

@section("javascript")
<script>
    jQuery(function ($) {
        var token = "{{Cookie::get('api_token')}}"
        $('select[name="store"]').on('change', function () {
            var storeID = $(this).val();
            if (storeID) {
                jQuery.ajax({
                    url: "https://dev.api.customerpay.me/store/" + encodeURI(storeID),
                    type: "GET",
                    dataType: "json",
                    contentType: 'json',
                    headers: {
                        'x-access-token': token
                    },
                    success: function (data) {
                        var new_data = data.data.store.customers;
                        var i;
                        for (i = 0; i < 1; i++) {
                            $('select[name="customer"]').empty();
                            $('select[name="customer"]').append('<option value="' + data
                                .data.store.customers[i]._id + '">' +
                                data.data.store.customers[i].name + '</option>');
                        }
                    },
                    error: function(data){
                        alert('error');
                    }
                });
            } else {
                $('select[name="store"]').empty();
            }
        });
    });

</script>
@stop
