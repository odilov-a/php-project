<?php
    require '../db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Add book</h2>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="title" name="title" required placeholder="title" />
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description"
                            placeholder="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pages" class="form-label">Pages quantity</label>
                        <input type="number" class="form-control" id="pages" name="pages" placeholder="pages"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">image</label>
                        <input type="file" class="form-control" id="image" name="image" required />
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" placeholder="year" required />
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <?php
                                $sql = "SELECT * FROM category";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '" >' . $row['title'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">languages</label>
                        <select class="form-control" id="languages" name="languages" required>
                            <?php
                                $sql = "SELECT * FROM languages";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $pages = $_POST['pages'];
            $image = $_FILES['image']['name']; // Access uploaded file name via $_FILES
            $year = $_POST['year'];
            $category = $_POST['category'];
            $languages = $_POST['languages'];
            $sql = "INSERT INTO books (title, description, pages, image, year, category_id, language_id) VALUES ('$title', '$description', '$pages', '$image', '$year', '$category', '$languages')";
            if ($conn->query($sql) === TRUE) {
                $uploadDirectory = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
                if (move_uploaded_file( $_FILES [ "image" ][ "tmp_name" ], $uploadDirectory . $_FILES [ "image" ][ "name" ] )) {
                    echo "File uploaded successfully!" ;
                } else {
                    echo "Error moving file." ;
                } 
                echo '<div class="container mt-3"><div class="alert alert-success" role="alert">New record created successfully! Please wait!!!</div></div>';
                header("Refresh:1; url=index.php");
            } else {
                echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div></div>';
            }
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>