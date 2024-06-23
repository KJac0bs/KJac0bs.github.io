<?php

$conn = mysqli_connect("localhost", "root", "", "pear_pools_db");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_POST['add_product'])){
    $p_name = $_POST['name'];
    $p_price = $_POST['price'];
    $p_image = $_FILES['image']['name'];
    $p_image_tmp_name = $_FILES['image']['tmp_name'];
    $p_image_folder = 'images\product_page_images\New2/'.$p_image;
 
    $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die('query failed');
 
    if($insert_query){
       move_uploaded_file($p_image_tmp_name, $p_image_folder);
       $message[] = 'Product added succesfully';
    }else{
       $message[] = 'Could not add product';
    }
 };
 
 if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id ") or die('query failed');
    if($delete_query){
       header('location:admin.php');
       $message[] = 'product has been deleted';
    }else{
       header('location:admin.php');
       $message[] = 'product could not be deleted';
    };
 };
 
 if(isset($_POST['update_product'])){
    $update_p_id = $_POST['update_p_id'];
    $update_p_name = $_POST['update_p_name'];
    $update_p_price = $_POST['update_p_price'];
    $update_p_image = $_FILES['update_p_image']['name'];
    $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
    $update_p_image_folder = 'images\product_page_images\New2/'.$update_p_image;
 
    $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', image = '$update_p_image' WHERE id = '$update_p_id'");
 
    if($update_query){
       move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
       $message[] = 'product updated succesfully';
       header('location:admin.php');
    }else{
       $message[] = 'product could not be updated';
       header('location:admin.php');
    }
 
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin</title>

   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<div class="container">

<section>

<form action="" method="post" class="add-product-form" enctype="multipart/form-data">
   <h3>Add new products</h3>
   <input type="text" name="name" placeholder="Enter product name" class="box" required>
   <input type="number" name="price" min="0" placeholder="Enter product price" class="box" required>
   <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" class="box" required>
   <input type="submit" value="Add product" name="add_product" class="btn">
</form>

</section>

<section class="display_product_table">

   <table>

      <thead>
         <th>Product image</th>
         <th>Product name</th>
         <th>Product price</th>
      </thead>

      <tbody>
         <?php
         
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>

         <tr>
            <td><img src="images\product_page_images\New2/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>R<?php echo $row['price']; ?></td>
         </tr>

         <?php
            };    
            }else{
               echo "<div class='empty'>no product added</div>";
            };
         ?>
      </tbody>
   </table>

</section>

<section class="edit_form_container">

   <?php
   
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>

   <form action="" method="post">
      <img src="images\product_page_images\New2/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="number" min="0" class="box" required name="update_price" value="<?php echo $fetch_edit['price']; ?>">
      <input type="file" class="box" required name="update_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="update the product" name="update_product" class="btn">
      <input type="reset" value="cancel" id="close_edit" class="option_btn">
   </form>

   <?php
            };
         };
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      };
   ?>

</section>

</div>

</body>
</html>