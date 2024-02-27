<?php
include("headder.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Style/styleshome.css">
    <link rel="icon" type="image/png" href="Images/Logos/yum.png">
    <title>Food</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        nav {
            height: 60px;
        }

        #overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2em;
            text-align: center;
        }

        .logo {
            max-width: 250px;
            /* Adjust the maximum width of the logo */
            height: auto;
            margin-right: 10px;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            padding: 50px;

        }

        .food-item {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            max-height: 200px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .food-item img {
            height: auto;
            max-width: 100px;
            border-radius: 50%;
            flex: 1;
        }

        .desc {
            height: auto;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .desc2 {
            height: auto;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .desc3 {
            height: auto;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3px;
        }

        .quantity-button {
            background-color: rgba(79, 199, 79, 0.658);
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            height: 25px;
            width: 30px;
            text-align: center;
        }

        .quantity-button:hover {
            background-color: rgba(79, 199, 79, 0.958);
        }

        /* Styling for the total price bar */
        .total-price-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: rgba(79, 199, 79, 0.8);
            color: #fff;
            text-align: center;
            padding: 10px 0;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="main-content">
        <?php
        if (isset($_SESSION["subfood_ids"])) {
            // Initialize total price variable
            $totalPrice = 0;

            // Loop through each stored subfood ID
            foreach ($_SESSION["subfood_ids"] as $subfood_id) {
                $sql = "SELECT * FROM subfood WHERE id= $subfood_id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                // Update total price based on the price of each item
                $totalPrice += $row["price"];

                // Output each food item
                echo "<div class='food-item'>
                        <div class='desc'>
                            <img src='{$row["img_url"]}'>
                        </div>
                        <div class='desc2'><h2>{$row["name"]}</h2></div>
                        <div class='desc3'>
                            <button class='quantity-button' onclick='updateQuantity(this, -1)'>-</button>
                            <span id='quantity_$subfood_id'>1</span>
                            <button class='quantity-button' onclick='updateQuantity(this, 1)'>+</button>
                        </div>
                    </div>";
            }
        } else {
            echo "No subfood IDs stored in session.";
        }
        ?>

        <!-- Total Price Bar -->
        <div class="total-price-bar">
            Total Price: $<span id="total-price"><?php echo $totalPrice; ?></span>
        </div>
    </div>

    <?php
    include("html/footer.html");
    ?>

    <script>
        // Function to decrease quantity
        function decreaseQuantity(button) {
            var span = button.nextElementSibling;
            var currentQuantity = parseInt(span.innerText);
            if (currentQuantity > 1) {
                span.innerText = currentQuantity - 1;
                updateTotalPrice();
            }
        }

        // Function to increase quantity
        function increaseQuantity(button) {
            var span = button.previousElementSibling;
            var currentQuantity = parseInt(span.innerText);
            span.innerText = currentQuantity + 1;
            updateTotalPrice();
        }

        // Function to update total price
        function updateTotalPrice() {
            var total = 0;
            // Loop through all quantity spans
            var quantitySpans = document.querySelectorAll('.desc3 span');
            quantitySpans.forEach(function(span) {
                var quantity = parseInt(span.innerText);
                var price = parseFloat(span.getAttribute('data-price'));
                total += quantity * price;
            });
            // Update the total price displayed
            document.getElementById('total-price').innerText = total.toFixed(2);
        }
    </script>
    <script>
        // Function to update quantity and total price
        function updateQuantity(button, change) {
            var span = button.parentElement.querySelector('span');
            var currentQuantity = parseInt(span.innerText);
            var newQuantity = currentQuantity + change;

            if (newQuantity >= 1) {
                span.innerText = newQuantity;

                // Calculate and update total price
                var price = parseFloat('<?php echo $row["price"]; ?>');
                var totalPrice = parseFloat(document.getElementById('total-price').innerText);
                var newTotalPrice = totalPrice + (change * price);
                document.getElementById('total-price').innerText = newTotalPrice.toFixed(2);
            }
        }
    </script>

</body>

</html>