<?php
      require_once('connection.php');
      session_start();
      $email  = $_SESSION['email'];

      $sql="select *from booking where EMAIL='$email' order by BOOK_ID DESC ";
      $cname = mysqli_query($con, $sql);
      $email = mysqli_fetch_assoc($cname);
      $bid = $email['BOOK_ID'];
      $_SESSION['bid'] = $bid;

      if (isset($_POST['pay'])) {
        $cardno = mysqli_real_escape_string($con, $_POST['cardno']);
        $exp = mysqli_real_escape_string($con, $_POST['exp']);
        $cvv = mysqli_real_escape_string($con, $_POST['cvv']);
        $price = $email['PRICE'];
        if (empty($cardno) || empty($exp) || empty($cvv)) {
          echo '<script>alert("please fill the place")</script>';
        } else {
          $sql2 = "insert into payment (BOOK_ID, CARD_NO, EXP_DATE, CVV, PRICE) values ($bid, '$cardno', '$exp', $cvv, $price)";
          $result = mysqli_query($con, $sql2);
          if ($result) {
            header("Location: psucess.php");
          }
        }
      }
    ?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css"
    />
    <link rel="stylesheet" href="css/pay.css" />
    <title>Payment Form</title>
    <script type="text/javascript">
        function preventBack() {
            window.history.forward(); 
        }
          
        setTimeout("preventBack()", 0);
          
        window.onunload = function () { null };
    </script>
    <style>
      @import url("https://fonts.googleapis.com/css?family=Poppins&display=swap");

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }

      body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background: orange url("images/paym.jpg") center/cover no-repeat;
        overflow: hidden;
      }


      .card {
        background: linear-gradient(
          to bottom right,
          rgba(255, 255, 255, 0.2),
          rgba(255, 255, 255, 0.05)
        );
        box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.5), -1px -1px 2px #aaa,
          1px 1px 2px #555;
        backdrop-filter: blur(0.8rem);
        padding: 1.5rem;
        border-radius: 1rem;
        animation: 1s cubic-bezier(0.16, 1, 0.3, 1) cardEnter;
        width: 90%;
        max-width: 500px;
        margin: 0 auto;
        height: 90%;
      }

      .card__row {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        padding-bottom: 2rem;
      }

      .card__title {
        font-weight: 600;
        font-size: 2rem;
        color: black;
        margin: 1rem 0 1.5rem;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
        text-align: center;
      }

      .card__col {
        padding-right: 0;
      }

      .card__input {
        background: none;
        border: none;
        border-bottom: dashed 0.2rem rgba(255, 255, 255, 0.15);
        font-size: 1rem;
        color: #fff;
        text-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
        width: 100%;
        box-sizing: border-box;
      }

      .card__input--large {
        font-size: 1.2rem;
      }

      .card__input::placeholder {
        color: rgba(255, 255, 255, 1);
        text-shadow: none;
      }

      .card__input:focus {
        outline: none;
        border-color: rgba(255, 255, 255, 0.6);
      }

      .card__label {
        display: block;
        color: #fff;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        font-weight: 400;
      }

      .card__chip {
        align-self: flex-end;
      }

      .card__chip img {
        width: 2rem;
      }

      .card__brand {
        font-size: 2rem;
        color: #fff;
        min-width: 80px;
        min-height: 60px;
        text-align: right;
        text-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
      }

      @keyframes cardEnter {
        from {
          transform: translateY(100vh);
          opacity: 0.1;
        }
        to {
          transform: translateY(0);
          opacity: 1;
        }
      }

      .btn {
        width: 100%;
        background: #ff7200;
        border: none;
        height: 40px;
        font-size: 1rem;
        border-radius: 5px;
        cursor: pointer;
        color: white;
        transition: 0.4s ease;
        margin-top: 10px;
      }

      .btn a {
        text-decoration: none;
        color: white;
        font-weight: bold;
      }
      
      .pay{
        justify-content: center;
        margin: 0;
        width: 100%;
      }

       .btn:hover {
        background: #fff;
        color: #ff7200;
      }

      .payment {
        text-align: center;
        margin-bottom: 1rem;
        color: #fff;
        font-size: 1.2rem;
      }

    </style>
  </head>
  <body>
    
    <h2 class="payment">TOTAL PAYMENT : ₹<?php echo $email['PRICE']?>/-</h2>

    <div class="card">
      <form method="POST">
        <h1 class="card__title">Enter Payment Information</h1>
        <div class="card__row">
          <div class="card__col">
            <label for="cardNumber" class="card__label">Card Number</label>
            <input
              type="text"
              class="card__input card__input--large"
              id="cardNumber"
              placeholder="xxxx-xxxx-xxxx-xxxx"
              required="required"
              name="cardno"
              maxlength="19"
            />
          </div>
          <div class="card__col card__chip">
            <img src="images/chip.svg" alt="chip" />
          </div>
        </div>
        <div class="card__row">
          <div class="card__col">
            <label for="cardExpiry" class="card__label">Expiry Date</label>
            <input
              type="text"
              class="card__input"
              id="cardExpiry"
              placeholder="xx/xx"
              required="required"
              name="exp"
              maxlength="5"
            />
          </div>
          <div class="card__col">
            <label for="cardCcv" class="card__label">CCV</label>
            <input
              type="password"
              class="card__input"
              id="cardCcv"
              placeholder="xxx"
              required="required"
              name="cvv"
              maxlength="3"
            />
          </div>
        </div>
        <input type="submit" value="PAY NOW" class="pay" name="pay">
        <button class="btn"><a href="cancelbooking.php">CANCEL</a></button>
      </form>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
  <script src="main.js"></script>
</html>
