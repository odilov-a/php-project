<?php
require '../db.php';

// Check if book ID is provided in URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch book data based on ID
    $sql = "SELECT * FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If book found, populate form fields with existing data
    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Book not found.</div></div>';
        exit(); // Exit script if book not found
    }
} else {
    $error_message = "Unknown error occurred.";
    if (isset($conn->error)) {
        $error_message = $conn->error;
    }
    error_log($error_message); // Log the error message
    echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error: ' . $error_message . '</div></div>';
    exit(); // Exit script if the request is invalid
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Edit Book</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $book_id); ?>" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required placeholder="Title" />
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea type="text" class="form-control" id="description" name="description" required><?php echo htmlspecialchars($book['description']); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pages" class="form-label">Pages quantity</label>
                        <input type="number" class="form-control" id="pages" name="pages" value="<?php echo htmlspecialchars($book['pages']); ?>" required placeholder="Pages" />
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" />
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required placeholder="Year" />
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="category" required>
                            <?php
                            $sql = "SELECT * FROM category";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = $book['category_id'] == $row['id'] ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['title'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="languages" class="form-label">Languages</label>
                        <select class="form-control" id="languages" name="languages" required>
                            <?php
                            $sql = "SELECT * FROM languages";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $selected = $book['language_id'] == $row['id'] ? 'selected' : '';
                                    echo '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $title = $_POST['title'];
        $description = $_POST['description'];
        $pages = $_POST['pages'];
        $year = $_POST['year'];
        $category = $_POST['category'];
        $languages = $_POST['languages'];

        // Check if a new image file is uploaded
        if ($_FILES['image']['size'] > 0) {
            $image = $_FILES['image']['name']; // Access uploaded file name via $_FILES

            // Prepare and execute SQL query for updating book with image
            $sql = "UPDATE books SET title=?, description=?, pages=?, image=?, year=?, category_id=?, language_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiisiii", $title, $description, $pages, $image, $year, $category, $languages, $book_id);
            if ($stmt->execute()) {
                $uploadDirectory = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDirectory . $_FILES["image"]["name"])) {
                    echo "File uploaded successfully!";
                } else {
                    echo "Error moving file.";
                }
                echo '<div class="container mt-3"><div class="alert alert-success" role="alert">Book updated successfully! Please wait!!!</div></div>';
                header("Refresh:1; url=index.php");
            } else {
                echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error updating book: ' . $conn->error . '</div></div>';
            }
        } else {
            // Prepare and execute SQL query for updating book without image
            $sql = "UPDATE books SET title=?, description=?, pages=?, year=?, category_id=?, language_id=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssiisii", $title, $description, $pages, $year, $category, $languages, $book_id);
            if ($stmt->execute()) {
                echo '<div class="container mt-3"><div class="alert alert-success" role="alert">Book updated successfully! Please wait!!!</div></div>';
                header("Refresh:1; url=index.php");
            } else {
                echo '<div class="container mt-3"><div class="alert alert-danger" role="alert">Error updating book: ' . $conn->error . '</div></div>';
            }
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
