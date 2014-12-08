<h3><?php echo $productName ?></h3>
<img src="<?php echo $imageURL ?>" width="10%">
<h5>Category: <?php echo $productCategory ?></h5>
<h5>Rating: <?php echo $productRating ?></h5>
<form action="account/changeRating" method="post">
 <select name="rating">
  <option value="0">0</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
</select>
<input type="hidden" name="productID" value="<?php echo $productID ?>">
<input type="hidden" name="accNumber" value="<?php echo $accNumber ?>">
<input type="submit" value="Modify rating">
</form>
<hr>