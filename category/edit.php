<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Edit Category</h2>
                <?php
                require '../db.php';
                
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
                    $category_id = $_GET['id'];
                    $sql = "SELECT title FROM category WHERE id = $category_id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $category = $result->fetch_assoc();
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $category_id; ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $category['title']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    <?php
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Category not found.</div>';
                    }
                } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['id'])) {
                    $category_id = $_GET['id'];
                    $title = $_POST['title'];
                    $sql = "UPDATE category SET title='$title' WHERE id=$category_id";
                    
                    if ($conn->query($sql) === TRUE) {
                        echo '<div class="alert alert-success" role="alert">Category updated successfully! Please wait!!!</div>';
                        header("Refresh:1; url=index.php");
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Error updating category: ' . $conn->error . '</div>';
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
