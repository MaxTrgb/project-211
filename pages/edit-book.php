<h1>Edit Book</h1>

<?php

if (!isset($_GET['id'])) {
    echo "Invalid book ID!";
    exit;
}


$stmt = $pdo->prepare('SELECT * FROM books WHERE id = ?');
$stmt->execute([$_GET['id']]);
$book = $stmt->fetch(PDO::FETCH_OBJ);


if (!$book) {
    echo "Book not found!";
    exit;
}


$authors = $pdo->query("SELECT id, name FROM authors")->fetchAll(PDO::FETCH_OBJ);
$genres = $pdo->query("SELECT id, name FROM genres")->fetchAll(PDO::FETCH_OBJ);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $author_id = $_POST['author_id'];
    $genre_id = $_POST['genre_id'];
    $id = $_POST['id'];

  
    $stmt = $pdo->prepare('
        UPDATE books
        SET name = ?, price = ?, author_id = ?, genre_id = ?
        WHERE id = ?
    ');
    $stmt->execute([$name, $price, $author_id, $genre_id, $id]);

   
    header('Location: index.php?page=books');
    exit;
}
?>


<form action="index.php?page=edit-book&id=<?= $book->id ?>" method="post">
    <input type="hidden" name="id" value="<?= $book->id ?>">

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($book->name) ?>" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" id="price" name="price" value="<?= htmlspecialchars($book->price) ?>" required>
    </div>

    <div class="mb-3">
        <label for="author_id" class="form-label">Author</label>
        <select class="form-control" id="author_id" name="author_id" required>
            <?php foreach ($authors as $author): ?>
                <option value="<?= $author->id ?>" <?= $author->id == $book->author_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($author->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="genre_id" class="form-label">Genre</label>
        <select class="form-control" id="genre_id" name="genre_id" required>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= $genre->id ?>" <?= $genre->id == $book->genre_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($genre->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
