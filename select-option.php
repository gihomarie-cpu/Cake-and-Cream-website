<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer information</title>
    <link rel="stylesheet" href="select-option.css">
</head>
<body>
    <div class="introduction">
    <img src="https://cakesandcream.ng/wp-content/uploads/2023/07/Cakes_and_Cream_logo_2.png" width="250" height="200" alt="business logo">
    <header>
        <nav>
            <ul class="nav-bar">
              <li> <a href="index.html#home">Home</a></li>
                 <li><a href="index.html#about">About</a></li>
                 <li class="dropdown"> 
                    <a href="#produts">Products</a>
                <ul class="dropdown-content">
                    <li><a href="children.html">Children cakes</a></li>
                    <li><a href="birthday.html">Birthday cakes</a></li>
                    <li><a href="wedding.html">Wedding cakes</a></li>
                    <li><a href="butter.html">Butter creams</a></li>
                </ul>
                </li>

                 <li><a href="orders.html">Orders</a> </li>
                 <li><a href="index.html#contact">Contact</a></li>
            </ul>
        </nav>
    </header>
    </div>
<div class="form-container">
      <h2>Customer information</h2> 

  <form action="select-option2.php" method="POST">
    <div class="form-group">
    <label for="size">Select cake size</label>
    <select name="cake_size" id="size-option">
      <option value="small">Small</option>
      <option value="small-twolayers">small with two layers</option>
      <option value="medium">medium</option>
      <option value="medium-twolayers">medium with two layers</option>
      <option value="larger">large</option>
      <option value="larger-twolayers">large with two layers</option>
    </select><br>
    </div>
    <div class="form-group">
    <label for="flavor">select your flavor value</label>
    <select name="cake_flavor" id="flavor-option">
      <option value="coconut">coconut</option>
      <option value="chocolate">chocolate</option>
      <option value="Banana">banana</option>
      <option value="pineaple">pineaple</option>
      <option value="mango">pineaple</option>
    </select><br>
    </div>
    <div class="form-group">
    <label for="cakename">Which name would like to use?</label> <br>
    <textarea name="cake_name" id="cakename" rows="6" cols="70" placeholder="write name do you need to your cake"></textarea><br>
    </div>
     <div class="form-group">
    <label for="cake_number">How many cakes do you need?</label>
    <input type="number" name="cake_number" id="number" placeholder="fill cake numbers">
    </div>
    <div class="form-group">
    <label for="email">Write your email </label>
    <input type="email" name="email" id="email" placeholder="eg: john@gmil.com" required><br>
    </div>
    <div class="form-group">
    <label for="telephone">Fill your phone number</label>
    <input type="tel" name="telephone" id="telephone" required><br>
    </div>
    <div class="form-group">
    <label for="location">Which location deliver goes into?</label>
    <input type="text" name="location" id="location" placeholder="write your location"><br>
    </div>
    <div class="form-group">
    <label>Which the payment methods you will use?</label>
    <select name="payment_method">
    <option value="paypal">Paypal</option>
    <option value="mastercard">Mastercard</option>
    <option value="visa">Visa</option>
    <option value="verve">Verve</option>
    <option value="mobilemoney">Mobile money</option>
    </select>
    </div>
    <div class="form-group">
    <label for="delivery_time">When you will need your products be arrived?</label>
    <input type="datetime" name="delivery_time" id="time" placeholder="eg: 21/04/2026"><br>
    </div>
    <div class="form-group">
    <input type="submit" class="submit" name="submit">
  </form>
  </div>
<footer>
        <div class="payment-section">
            <p>we accept</p>
            <div class="payment-methods">
        <img src="https://th.bing.com/th/id/OIP.Q4Gvv08Y0nPdSa8jJF5l-QHaDt?w=324&h=175&c=7&r=0&o=7&dpr=1.3&pid=1.7&rm=3" width="120" alt="flutterwave">
        <img src="https://th.bing.com/th/id/OIP.UeczNhTb1NyoDJur9gUTPgHaFr?w=212&h=180&c=7&r=0&o=7&dpr=1.3&pid=1.7&rm=3"width="120" alt="master card">
        <img src="https://tse2.mm.bing.net/th/id/OIP.xL03XjjZ7shCuc0VYH4jOwHaCR?rs=1&pid=ImgDetMain&o=7&rm=3" width="120" alt="visa">
        <img src="https://tse4.mm.bing.net/th/id/OIP.imXeeuMnxFyHtKDoM0nseAHaHa?rs=1&pid=ImgDetMain&o=7&rm=3"width="120" alt="verve">
     </div>
      </div>
     </footer> 
</body>
</html>