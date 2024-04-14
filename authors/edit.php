<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Edit Author</h2>
                <?php
                require '../db.php';
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                    $author_id = $_GET['id'];
                    $sql = "SELECT name FROM authors WHERE id = $author_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $author = $result->fetch_assoc();
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $author_id; ?>">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $author['name']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    <?php
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Author not found.</div>';
                    }
                } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $author_id = $_GET['id'];
                    $name = $_POST['name'];
                    $sql = "UPDATE authors SET name='$name' WHERE id=$author_id";
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Author updated successfully! Please wait!!!</div>';
                        header("Refresh:1; url=index.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error updating author: ' . $conn->error . '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert">Invalid request.</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
