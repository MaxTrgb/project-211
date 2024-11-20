<h1>Contact Page</h1>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $image = $_FILES['image'];

    //dump($image);

    if($image['error'] !== 0) {
        $_SESSION['error'] = 'File not uploaded';
        redirect('contact');
    }

    $allowedTypes = ['image/png', 'image/jpeg', 'image/gif', 'image/webp'];

    if (!in_array($image['type'], $allowedTypes)) {
        $_SESSION['error'] = 'File type not allowed';
        redirect('contact');
    }

    $fName = time() . '-' . $image['name'];

   if(!move_uploaded_file($image['tmp_name'], 'uploads/' . $fName)) {
       $_SESSION['error'] = 'File not uploaded';
       redirect('contact');
   }

    redirect('contact');
}


// mkdir('uploads/1');
// rmdir('uploads/1');

?>



<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


<form action="index.php?page=contact" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
    </div>

    <button class="btn btn-primary">Send</button>
</form>


