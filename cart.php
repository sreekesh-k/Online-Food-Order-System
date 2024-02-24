<?php
include("header.php");

// Assuming database connection is already established and stored in $conn variable

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page or display a message
    header("Location: login.php");
    exit(); // Stop further execution
}

// Retrieve user ID from session
$user_name= $_SESSION["username"];

// Handle remove item from cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_item"])) {
    $cart_id = $_POST["cart_id"];
    // Delete item from cart
    $sql = "DELETE FROM cart WHERE cart_id = $cart_id AND user_id = $user_";
    mysqli_query($conn, $sql);
}

// Handle update cart action
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_cart"])) {
    foreach ($_POST["quantity"] as $cart_id => $quantity) {
        // Update quantity for each item in cart
        $sql = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cart_id AND user_id = $user_id";
        mysqli_query($conn, $sql);
    }
}

// Retrieve cart items for the current user
$sql = "SELECT c.cart_id, c.food_id, c.quantity, f.foodname, f.price, f.image FROM cart c JOIN food f ON c.food_id = f.fid WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $sql);

?>

<div class="cart-container">
    <h2>Your Cart</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
    <form method="post">
        <table>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td>
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['foodname']; ?>" width="50">
                    <?php echo $row['foodname']; ?>
                </td>
                <td><?php echo $row['price']; ?></td>
                <td>
                    <input type="number" name="quantity[<?php echo $row['cart_id']; ?>]" value="<?php echo $row['quantity']; ?>" min="1">
                </td>
                <td><?php echo $row['price'] * $row['quantity']; ?></td>
                <td>
                    <button type="submit" name="update_cart">Update</button>
                    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
                    <button type="submit" name="remove_item">Remove</button>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </form>
    <?php else: ?>
    <p>Your cart is empty.</p>
    <?php endif; ?>
</div>

<?php include("footer.php"); ?>
