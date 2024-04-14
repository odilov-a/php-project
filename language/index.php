<!doctype html>
<html lang="en">
<?php
  require "../db.php"
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Library system</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="../index.php" style="color:white; margin-left:4%">Library system</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown" style="margin-left:57%">
        <ul class="navbar-nav">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              style="color:white;">
              Authors
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../authors/index.php">Authors List</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              style="color:white;">
              Categories
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../category/index.php">Categories List</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              style="color:white;">
              Languages
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../language/index.php">Languages List</a></li>
              <li><a class="dropdown-item" href="../language/create.php">Create Language</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
              style="color:white;">
              Books
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../books/index.php">Books List</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container"></br/>
  <h3>languages list</h3>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <?php
        $sql = "SELECT id, name FROM languages";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<th scope="row">' . $row["id"] . '</th>';
                echo '<td>' . $row["name"] . '</td>';
                echo '<td><a href="edit.php?id=' . $row["id"] . '">Edit</a> | <a href="delete.php?id=' . $row["id"] . '">Delete</a></td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="3">0 results</td></tr>';
        }
      ?>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>