<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCustomer Business Card</title>
    <link rel="stylesheet" href="{{asset('backend/assets/css/buscard.css')}}">
</head>

<style>
           @font-face {
    font-family: Gilroy-Bold;
    src: url("{{asset('backend/assets/fonts/Gilroy-Bold.ttf')}}");
}
@font-face {
    font-family: Gilroy;
    src: url("{{asset('backend/assets/fonts/Gilroy-Regular.ttf')}}");
}
@font-face {
    font-family: Gilroy-Medium;
    src: url("{{asset('backend/assets/fonts/Gilroy-Medium.ttf')}}");
}
</style>

<body>

    <div class="container">
        <img class="img1" src="{{asset('backend/assets/images/pattern1.png')}}" alt="">
        <img class="img2" src="{{asset('backend/assets/images/Rectangle_31.png')}}" alt="">
 
        <div class="div2">
            <h1 class="hh1">Emie Farms</h1>
            <p class="hh2">Tagline</p>
            <img src="{{asset('backend/assets/images/vector_3.png')}}" alt="" class="img10">
            <p class="hh3">Name</p> <br>
            <p class="hh4">Position</p>
            <img src="{{asset('backend/assets/images/vector_4.png')}}" alt="" class="img11">
            <p class="hh5">Phone Number</p><br>
            <div class="div3">
                <img src="{{asset('backend/assets/images/vector_5.png')}}" alt="" class="img12"> 
                <p class="hh6">emailplaceholder@.com</p>
            </div>
            <div class="div4">
                <img src="{{asset('backend/assets/images/vector_6.png')}}" alt="" class="img13"> 
                <p class="hh7">No 10, placeholder address placeholder street, Abuja, Nigeria.</p>
            </div>

        </div>
    </div>

        
</body>
</html>