<!doctype html>
<html lang="en">

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
      <a class="navbar-brand" href="./index.php" style="color:white; margin-left:4%">Library system</a>
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
  <div class="container mt-5">
    <h2>Search Books</h2>
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="container mt-3">
        <label for="search">Search with title:</label>
        <input type="text" id="search" name="search" class="form-control"
          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
      </div>
      <div class="container mt-3">
        <label for="year">Search by year:</label>
        <input type="number" id="year" name="year" class="form-control"
          value="<?php echo isset($_GET['year']) ? htmlspecialchars($_GET['year']) : ''; ?>">
      </div>
      <div class="container mt-3">
        <button type="submit" class="btn btn-primary" name="submit">Search</button>
      </div>
    </form>
    <?php
    require 'db.php';
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
      $search = $_GET['search'];
      $year = $_GET['year'];
      // Construct SQL query to search for books
      $sql = "SELECT * FROM books WHERE 1=1"; // Starting query
      // Add conditions for search parameters if they are not empty
      if (!empty($search)) {
        $sql .= " AND title LIKE ?";
        $searchParam = "%{$search}%";
      }
      if (!empty($year)) {
        $sql .= " AND year = ?";
      }
      // Add sorting
      $sql .= " ORDER BY title ASC";
      // Prepare and execute the SQL query
      $stmt = $conn->prepare($sql);
      // Bind parameters if they are not empty
      if (!empty($search)) {
        $stmt->bind_param("s", $searchParam);
      }
      if (!empty($year)) {
        $stmt->bind_param("i", $year);
      }
      $stmt->execute();
      $result = $stmt->get_result();
      // Display search results
      if ($result->num_rows > 0) {
        echo "<br><h3>Search Results:</h3>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead class='thead-dark'>";
        echo "<tr><th>Title</th><th>Year</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr><td>{$row['title']}</td><td>{$row['year']}</td></tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
      } else {
        echo "<p>No results found.</p>";
      }
    }
    ?>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>