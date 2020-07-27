
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCustomer Business Card</title>
    <link rel="stylesheet" href={{public_path('backend/assets/css/buscard2.css')}}>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Bad+Script&display=swap" rel="stylesheet"> --}}
</head>

<style>
@font-face {
    font-family: Gilroy-Bold;
    src: url("{{public_path()}}/backend/assets/fonts/Gilroy-Bold.ttf");
}
@font-face {
    font-family: Gilroy;
    src: url("{{public_path()}}/backend/assets/fonts/Gilroy-Regular.ttf");
}
@font-face {
    font-family: Gilroy-Medium;
    src: url("{{public_path()}}/backend/assets/fonts/Gilroy-Medium.ttf");
}
</style>

<body>
    <div class="container">
        <div class="text">
            <img src="{{public_path('backend/assets/images/bg-left.png')}}" alt="" class="img-left">
             <img src="{{public_path('backend/assets/images/bg-right.png')}}" alt="" class="img-right">
            <h4 class="hh1">{{$store_details->store_name}}</h4>
            <h4 class="hh2">{{$store_details->tagline}}</h4>


            <h1 class="hh3">{{Cookie::get('first_name') ." ". Cookie::get('last_name') }}</h1>
            <h5 class="hh4">{{Cookie::get('user_role')}}</h5>

            <h4 class="hh5">{{$store_details->phone_number}}</h4>
            <h4 class="hh6">{{$store_details->email}}</h4>

            <h4 class="hh7">{{$store_details->shop_address}}</h4>
        </div>
            
    </div>
</body>
</html>