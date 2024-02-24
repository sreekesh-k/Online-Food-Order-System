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
            if (isset($_SESSION["subfood_ids"])) {
                // Loop through each stored subfood ID
                foreach ($_SESSION["subfood_ids"] as $subfood_id) {
                    $sql = "SELECT * FROM subfood WHERE id= $subfood_id";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    echo
                    " <div class='food-item'>
                    <img src='{$row["img_url"]}'>
                    <h2>{$row["name"]}</h2>
                    <h3>{$row["price"]}</h3>
                    <button class='remove-item-btn' data-item-id='{$subfood_id}'>Remove</button>
                  
                    
                
                </div>";
                }
            } else {
                echo "No subfood IDs stored in session.";
            }
            ?>

</div>
            <?php
            include("html/footer.html");
            ?>
        

    </body>
    <script>
    // JavaScript code for handling removal of items
            document.querySelectorAll('.remove-item-btn').forEach(button => {
                button.addEventListener('click', function() {
                    var item_id = this.getAttribute('data-item-id');

                    // Send AJAX request to remove the item
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "order.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Item successfully removed, update UI as needed
                                // For example, remove the item from the DOM
                                var itemElement = document.querySelector('.food-item[data-item-id="' + item_id + '"]');
                                if (itemElement) {
                                    itemElement.remove();
                                }
                            } else {
                                // Handle error
                                console.error(response.error);
                            }
                        }
                    };
                    xhr.send("action=removeItem&item_id=" + encodeURIComponent(item_id));
                });
            });
    </script>
</html>