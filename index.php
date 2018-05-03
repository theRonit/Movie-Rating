<?php
session_start();

if ( isset( $_SESSION['user_id'] ) ) {
   
} else {
   
    header("Location: /rsd/login.php");
}
require_once './config.php';
include './header.php';
?>

<div class="row">

  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Welcome <?php echo $_SESSION['user_name']; ?>!</h3>
    </div>
    <div class="panel-body">
     
      <p>Click the movie poster to be able to rate it, this is allowed only once per user. </p>
     
      
    </div>
  </div>


  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Upcoming Movies</h3>
    </div>
    <div class="panel-body">

      <?php
      $sql = "SELECT `product_id`, `product_name`, `product_date` FROM `tbl_products` WHERE 1";
      try {
        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $products = $stmt->fetchAll();
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

      
      $ratings_sql = "SELECT count(*) as count, AVG(ratings_score) as score FROM `tbl_products_ratings` WHERE 1 AND product_id = :pid";
      $stmt2 = $DB->prepare($ratings_sql);

      for ($i = 0; $i < count($products); $i++) {

        try {
          $stmt2->bindValue(":pid", $products[$i]["product_id"]);
          $stmt2->execute();
          $product_rating = $stmt2->fetchAll();
        } catch (Exception $ex) {
         
          echo $ex->getMessage();
        }
        ?>
        <div class="col-sm-3 adjustdiv">
          <a href="products.php?pid=<?php echo $products[$i]["product_id"] ?>">
            <img src="images/<?php echo $products[$i]["product_id"] ?>.jpg" class="img-thumbnail" width="200px" height="200px">
          </a>
          <div class="textContainer caption" >
            <div class="row">
              <div class="col-lg-12 prdname"><?php echo $products[$i]["product_name"] ?><span style="color: #000;"> - </span><span class="prdprice"><?php echo $products[$i]["product_date"] ?></span></div>
            </div>
            <div class="row padding5 nlp nrp">
              <div class="col-lg-12">
                <?php
                if ($product_rating[0]["count"] > 0) {
                  echo "Average rating <strong>" . round($product_rating[0]["score"], 2) . "</strong> based on <strong>" . $product_rating[0]["count"] . "</strong> users";
                } else {
                  echo 'No ratings for this product';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>     

    </div>
  </div>


</div>
<?php
include './footer.php';
?>