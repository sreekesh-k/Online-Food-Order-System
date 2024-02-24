<?php
include("headder.php");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $food_id = $_POST["fid"];
    $user_id = $_POST["userid"];
    $quantity = $_POST["quantity"];

    // Check if the item is already in the cart for this user
    $sql = "SELECT * FROM cart WHERE userid = $userid AND fid = $fid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Update the quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row["quantity"] + $quantity;
        $sql = "UPDATE cart SET quantity = $new_quantity WHERE userid = $userid AND fid = $fid";
    } else {
        // Insert new item into cart
        $sql = "INSERT INTO cart (user_id, fid, quantity) VALUES ($userid, $fid, $quantity)";
    }
}
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

        .button {
            border: none;

            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: white;

            color: black;
            border: 2px solid #04AA6D;
            border-radius: 50px;
        }

        .button1:hover {
            background-color: #04AA6D;
            color: white;
        }

        .logo {
            max-width: 250px;
            /* Adjust the maximum width of the logo */
            height: auto;
            margin-right: 10px;
        }

        .main-content {
            display: flex;

            justify-content: space-around;
            flex-wrap: wrap;
            padding: 50px;
        }

        .food-item {
            width: 300px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .food-item img {
            max-width: 100%;
            height: auto;
            max-width: 90%;
            border-radius: 50%;
        }

        .food-description {
            margin-top: 10px;
        }

        p {
            font-family: 'Arial', sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 20px;
        }

        h3 {
            color: grey;
        }

        .button {
            display: block;
            margin: 0 auto;
            /* Centers the button horizontally */
            border: none;
            padding: 10px 20px;
            width: 220px;
            text-align: center;
            text-decoration: none;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
            color: #04AA6D;
            background-color: #333;
            border-radius: 50px;
        }

        .button:hover {
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>

<body>

    <body>
        <div class="main-content">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["fid"])) {
                $fid = $_GET["fid"];
                $sql = "SELECT * FROM subfood WHERE fid= $fid";;
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        " <div class='food-item'>
                        <img src='{$row["img_url"]}'>
                        <h2>{$row["name"]}</h2>
                        <h3>{$row["price"]}</h3>
                        <p>{$row["description"]}</p>
                        <button type='button' name='add_to_plate' class='button' data-id='{$row["id"]}' onclick='toggleAddToPlate(this);'>add to plate
                        </button>
                    
                    </div>";
                    }
                }
            }
            ?>
        </div>





        <?php
        include("html/footer.html");
        ?>

    </body>

    <script>
        function toggleAddToPlate(button) {
            var subfoodId = button.getAttribute('data-id');
            addToPlate(subfoodId);
            button.innerText = "Added";
        }

        function addToPlate(subfoodId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Response received, do any further processing if needed
                }
            };
            xhttp.open("GET", "store_subfood_in_session.php?id=" + subfoodId, true);
            xhttp.send();
        }
    </script>

</html>