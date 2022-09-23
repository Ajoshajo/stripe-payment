<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>Stripe</title>
</head>
<body>
    <div class="text-center">
        <h1>Pay Now</h1>
        <h3>100Rs</h3>
        <form action="pay.php">
            <button type="submit">
                Pay Now
            </button>
            <?php if (isset($_GET['error_msg'])) {
    ?>
            <span style="color:red"><?=$_GET['error_msg']?></span>
                <?php
}?>
        </form>
    </div>
</body>
</html>
