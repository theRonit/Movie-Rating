<?php

session_start();

if ( isset( $_SESSION['user_id'] ) ) {
   
} else {
   
    header("Location: /rsd/login.php");
}
require_once './config.php';
include './header.php';
?>
<script src="raty/jquery.raty.js" type="text/javascript"></script>

<div class="row">
  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3 class="panel-title">Welcome <?php echo $user_name; ?>!</h3>
    </div>
   
  </div>


  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Product Details</h3>
    </div>
    <div class="panel-body">

      <?php
     
      $sql = "SELECT `product_id`, `product_name`, `product_date` FROM `tbl_products` WHERE 1 AND product_id = :pid";
      try {

        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":pid", intval($_GET["pid"]));
        $stmt->execute();
       
        $products = $stmt->fetchAll();
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }

    
      $ratings_sql = "SELECT count(*) as count, AVG(ratings_score) as score FROM `tbl_products_ratings` WHERE 1 AND product_id = :pid";
      $stmt2 = $DB->prepare($ratings_sql);

      try {
        $stmt2->bindValue(":pid", $_GET["pid"]);
        $stmt2->execute();
        $product_rating = $stmt2->fetchAll();
      } catch (Exception $ex) {
       
        echo $ex->getMessage();
      }

      if (isset($USER_ID)) {
        
        $user_rating_sql = "SELECT count(*) as count FROM `tbl_products_ratings` WHERE 1 AND product_id = :pid AND user_id= :uid";
        $stmt3 = $DB->prepare($user_rating_sql);

        try {
          $stmt3->bindValue(":pid", $_GET["pid"]);
          $stmt3->bindValue(":uid", $USER_ID);
          $stmt3->execute();
          $user_product_rating = $stmt3->fetchAll();
        } catch (Exception $ex) {
          echo $ex->getMessage();
        }
      }
      ?>

      <div class="col-sm-12">
        <div class="row">

          <?php
          if (count($products) > 0) {
            ?>
            <div class="col-sm-4">
              <a href="products.php?pid=<?php echo $products[0]["product_id"] ?>">
                <img src="images/<?php echo $products[0]["product_id"] ?>.jpg" class="img-thumbnail" width="500px" height="500px">
              </a>
            </div>
            <div class="col-sm-8">
              <div class="padding10 ntp">
                <h3 class="ntm"><?php echo $products[0]["product_name"] ?></h3>
                <h3>
                  <?php echo $products[0]["product_date"] ?></h3>

                <div id="avg_ratings">
                  <?php
                  if ($product_rating[0]["count"] > 0) {
                    echo "Average rating <strong>" . round($product_rating[0]["score"], 2) . "</strong> based on <strong>" . $product_rating[0]["count"] . "</strong> users";
                  } else {
                    echo 'No ratings for this product';
                  }
                  ?>
                </div>

                <?php
                if ($user_product_rating[0]["count"] == 0) {
                  ?>  
                  <div class=" padding10 clearfix"></div>
                  <div id="rating_zone">

                    <div class="pull-left">
                      <div id="prd"></div>
                    </div>
                    <div class="pull-left">
                      <button class="btn btn-primary btn-sm" id="submit" type="button">submit</button>
                    </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php
                } else {
                  echo '<div class="padding20 nlp"><p><strike>You have already rated this product</strike></p></div>';
                }
                ?>
                <div class="padding10 clearfix"></div>
                <a class="btn btn-info" href="index.php"><span class="glyphicon glyphicon-chevron-left"></span> back to listing</a>
              </div>
            </div>
          <?php } else { ?>
            <div class="col-sm-12">
              <div class="padding20 nlp"><p><strike>No products found</strike></p></div>
            </div>
          <?php } ?>

        </div>

      </div>

    </div>
  </div>
</div>

<script>
  $(function() {
    $('#prd').raty({
      number: 5, starOff: 'raty/img/star-off-big.png', starOn: 'raty/img/star-on-big.png', width: 180, scoreName: "score",
    });
  });
</script>

<script>
  $(document).on('click', '#submit', function() {
<?php
if (!isset($USER_ID)) {
  ?>
      alert("You need to have a account to rate this product?");
      return false;
<?php } else { ?>

      var score = $("#score").val();
      if (score.length > 0) {
        $("#rating_zone").html('processing...');
        $.post("update_ratings.php", {
          pid: "<?php echo $_GET["pid"]; ?>",
          uid: "<?php echo $USER_ID; ?>",
          score: score
        }, function(data) {
          if (!data.error) {
            $("#avg_ratings").html(data.updated_rating);
            $("#rating_zone").html(data.message).show();
          } else {
            $("#rating_zone").html(data.message).show();
          }
        }, 'json'
                );
      } else {
        alert("select the ratings.");
      }

<?php } ?>
  });
</script>
<?php
include './footer.php';
?>