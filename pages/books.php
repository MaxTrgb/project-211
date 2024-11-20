<h1>Books</h1>

<?php

$stmt = $pdo->query("
SELECT 
    books.id, books.name, books.price, 
    authors.name AS author_name, 
    genres.name AS genre_name
FROM books
LEFT JOIN authors ON books.author_id = authors.id
LEFT JOIN genres ON books.genre_id = genres.id
");
$books = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    
    $stmt = $pdo->prepare('DELETE FROM books WHERE id = ?');
    $stmt->execute([$id]);

    
    header('Location: index.php?page=books');
    exit;
}
?>

<a href="index.php?page=add-book" class="btn btn-primary">Add Book</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= htmlspecialchars($book->name) ?></td>
                <td><?= htmlspecialchars($book->price) ?></td>
                <td><?= htmlspecialchars($book->author_name) ?></td>
                <td><?= htmlspecialchars($book->genre_name) ?></td>
                <td>
                    <a class="btn btn-primary" href="index.php?page=edit-book&id=<?= $book->id ?>">Edit</a>
                    <form action="index.php?page=books" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
                        <input type="hidden" name="id" value="<?= $book->id ?>">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
