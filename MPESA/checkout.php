<?php
include('express-stk.php');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .price h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .card img {
            width: 100px;
            margin: 0 auto;
            display: block;
        }

        .card p {
            font-size: 14px;
            color: #666;
            text-align: center;
            line-height: 1.5;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .row {
            margin-bottom: 20px;
        }

        .info label {
            font-size: 14px;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .info input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .button {
            text-align: center;
        }

        .button button {
            background-color: #18C2C0;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .button button:hover {
            background-color: #15aeac;
        }

        .button button:active {
            background-color: #139b99;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="price">
        <?php if(isset($_POST['paymentAmount'])): ?>
            <h1>Awesome, that's KES <?php echo htmlspecialchars($_POST['paymentAmount']); ?></h1>
        <?php else: ?>
            <h1>Awesome, that's KES</h1>
        <?php endif; ?>
    </div>
    <div class="card">
        <img src="mpesa.png" alt="Mpesa Icon">
        <p>1. Enter the <b>phone number</b> and press "<b>Confirm and Pay</b>"<br>2. You will receive a popup on your phone. Enter your <b>MPESA PIN</b></p>
        <?php if ($errmsg != ''): ?>
            <p style="background: #cc2a24;padding: .8rem;color: #ffffff;"><?php echo $errmsg; ?></p>
        <?php endif; ?>
    </div>
    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        <div class="row number">
            <div class="info">
                <label for="cardnumber">Phone number</label>
                <input id="cardnumber" type="text" name="phone_number" maxlength="10" placeholder="0700000000">
            </div>
        </div>
        <div class="button">
            <button type="submit">Pay</button>
        </div>
    </form>
</div>
</body>
</html>
