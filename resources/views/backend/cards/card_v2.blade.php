<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCustomer Business Card</title>
    <link rel="stylesheet" href="{{asset('backend/assets/css/buscard2.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Bad+Script&display=swap" rel="stylesheet">
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
.container{
        background-image: url("{{asset('backend/assets/images/bg-left.png')}}"), url("{{asset('backend/assets/images/bg-right.png')}}");
    }
</style>

<body>
    <div class="container">
        <div class="text">
            <h4 class="hh1">Le' Fashionista.</h4>
            <h4 class="hh2">Value for style</h4>


            <h1 class="hh3">Eke Adenike</h1>
            <h5 class="hh4">CEO, Le' fashionista</h5>

            <h4 class="hh5">+234704466371</h4>
            <h4 class="hh6">lefashionista@zmail.com</h4>

            <h4 class="hh7">No 10 Garki road, Old bus-stop, Industrial layout, Abuja, Nigeria</h4>
        </div>
            
    </div>
</body>
</html>