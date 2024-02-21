<?php
include("headder.php");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="Style/styleshome.css">
    <link rel="icon" type="image/png" href="Images/Logos/yum.png">
    <title>Yum Street</title>
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

        a {
            text-decoration: none;
        }

        p {
            text-align: center;
            color: black;
            font-size: 50px;
            font-family: " Times New Roman", Times, serif;

        }

        @keyframes fadeInOut {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        /* Apply fadeInOut animation to each paragraph with a delay */
        p {
            animation: fadeInOut 3s ease-in-out infinite;
            display: none;
        }
    </style>
</head>

<body>
    <p>Chaaya'k Kadi aayaalo?</p>
    <p>Hungry? How about a Pothichoru?</p>
    <p> Craving for pizza? Time to indulge in some cheesy goodness!</p>
    <p>Order in deliciously juicy and grilled Shawarmas to curb your cravings!</p>

    <?php
    $sql = "SELECT * FROM food ORDER BY RAND()";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo
            "<div class='main-content'>
                    <a href='sub-food.php?fid={$row["foodid"]}'>
                        <div class='food-item'>
                            <img src='{$row["img_url"]}' alt='Delicious Dish'>
                            <h2>{$row["foodname"]}</h2>
                        </div>
                    </a>
                </div";
        }
    }
    ?>
    <?php
    include("html/footer.html");
    ?>
</body>
<script>
    // JavaScript to display paragraphs one after the other
    const paragraphs = document.querySelectorAll('p');

    let index = 0;

    function displayParagraph() {
        paragraphs.forEach((paragraph, i) => {
            paragraph.style.display = i === index ? 'block' : 'none';
        });

        index = (index + 1) % paragraphs.length;
    }

    // Initial display
    displayParagraph();

    // Set interval for continuous loop
    setInterval(displayParagraph, 3000); // Change the interval (in milliseconds) as needed
</script>

</html>