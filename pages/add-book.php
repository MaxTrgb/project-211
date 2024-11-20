<h1>Create Book</h1>

<?php

$authors = $pdo->query("SELECT id, name FROM authors")->fetchAll(PDO::FETCH_OBJ);
$genres = $pdo->query("SELECT id, name FROM genres")->fetchAll(PDO::FETCH_OBJ);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $author_id = $_POST['author_id'];
    $new_author = $_POST['new_author'];
    $genre_id = $_POST['genre_id'];

    if (!empty($new_author)) {

        $stmt = $pdo->prepare('INSERT INTO authors (name) VALUES (:authorName)');
        $stmt->execute(['authorName' => $new_author]);
        
    
        $author_id = $pdo->lastInsertId();
    }

    $stmt = $pdo->prepare('INSERT INTO books (name, price, author_id, genre_id) VALUES (:bookName, :bookPrice, :authorId, :genreId)');
    $stmt->execute([
        'bookName' => $name,
        'bookPrice' => $price,
        'authorId' => $author_id,
        'genreId' => $genre_id,
    ]);


    header('Location: index.php?page=books');
    exit;
}
?>

<form action="index.php?page=add-book" method="post">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" id="price" name="price" required>
    </div>
    <div class="mb-3">
        <label for="author_id" class="form-label">Author</label>
        <select class="form-control" id="author_id" name="author_id">
            <option value="">Select an existing author</option>
            <?php foreach ($authors as $author): ?>
                <option value="<?= htmlspecialchars($author->id) ?>">
                    <?= htmlspecialchars($author->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="new_author" class="form-label">OR Enter a New Author</label>
        <input type="text" class="form-control" id="new_author" name="new_author" placeholder="New author name">
    </div>
    <div class="mb-3">
        <label for="genre_id" class="form-label">Genre</label>
        <select class="form-control" id="genre_id" name="genre_id" required>
            <option value="">Select a genre</option>
            <?php foreach ($genres as $genre): ?>
                <option value="<?= htmlspecialchars($genre->id) ?>">
                    <?= htmlspecialchars($genre->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
</form>
