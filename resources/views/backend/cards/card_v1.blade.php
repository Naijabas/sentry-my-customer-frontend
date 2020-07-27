

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCustomer Business Card</title>
    <link rel="stylesheet" href="{{public_path('backend/assets/css/buscard.css')}}">
</head>

<style type="text/css">
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
        <img class="img1" src="{{public_path('backend/assets/images/pattern1.png')}}" alt="">
        <img class="img2" src="{{public_path('backend/assets/images/Rectangle_31.png')}}" alt="">
 
        <div class="div2">
            <h1 class="hh1">{{$store_details->store_name}}</h1>
        <p class="hh2">{{$store_details->tagline}}</p>
            <img src="{{public_path('backend/assets/images/vector_3.png')}}" alt="" class="img10">
            <p class="hh3">{{Cookie::get('first_name') ." ". Cookie::get('last_name') }}</p> <br>
        <p class="hh4">{{Cookie::get('user_role')}}</p>
            <img src="{{public_path('backend/assets/images/vector_4.png')}}" alt="" class="img11">
            <p class="hh5">{{$store_details->phone_number}}</p><br>
            <div class="div3">
                <img src="{{public_path('backend/assets/images/vector_5.png')}}" alt="" class="img12"> 
                <p class="hh6">{{$store_details->email}}</p>
            </div>
            <div class="div4">
                <img src="{{public_path('backend/assets/images/vecto_6.png')}}" alt="" class="img13"> 
                <p class="hh7">{{$store_details->shop_address}}</p>
            </div>

        </div>
    </div>

        
</body>
</html>