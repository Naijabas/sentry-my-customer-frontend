<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>myCustomer</title>

    <link rel="stylesheet" href="public/frontend/css/pay.css" />
  </head>
  <body>
    <header>
      <img src="public/frontend/images/myCustomer.png" alt="" />
      <h3>myCustomer</h3>
      <span>.</span>
    </header>

    <main id="main">
      <div class="title">
        Payment
      </div>
      <div class="total">
        <span>Total:</span>
        <span>$6,700</span>
      </div>
      <div class="payBox">
        <div class="switchBox">
          <div class="cardSwitch active">
            <img class="wallet" src="./images/wallet.png"></img>
            Pay with card
          </div>
          <div class="transferSwitch">Pay with transfer</div>
        </div>
        <div class="forms">
          <form name="card" class="card" action="z.y" method="post">
            <div class="inputBox">
              <label for="number">Card Number</label>
              <input
                type="text"
                class="number"
                name="number"
                placeholder="0000 0000 0000 0000"
              />
            </div>
            <div class="inputBox">
              <label for="name">Card Holder's Name</label>
              <input type="text" class="name" name="name" placeholder="" />
            </div>
            <div class="inputGroup">
              <div class="inputBox expiry">
                <label for="">Expiry Date</label>
                <select name="month" id="month">
                  <option :value="month" v-for='month in months'>{{month}}</option>
                </select>
                <select name="year" id="year">
                  <option :value="year" v-for="year in years">{{year}}</option>
                </select>
              </div>
              <div class="inputBox cvv">
                <label for="cvv">CVV <i class="circle">?</i></label>
                <input type="password" name="cvv" placeholder="***" />
              </div>
            </div>
          </form>
        </div>
      </div>
      <button class="submit">Pay $6,700</button>
    </main>
  </body>
  <script src="./libs/Vue/vue.min.js"></script>
  <script>
  new Vue({
    el: '#main',
    data: {
      months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      years: (() => {
        let x = [...Array(10)].map((v, i) => {
          return 2019+(Number(i));
        })
        return x;
      })()
    }
  })
  </script>
</html>
