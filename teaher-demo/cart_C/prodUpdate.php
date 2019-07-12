<?php
$psn = $_REQUEST["psn"];
$errMsg = "";
//連線資料庫
try{
  require_once("connectBooks.php");
  $sql = "select * from products where psn = :psn";
  $products = $pdo->prepare($sql);
  $products->bindValue(":psn", $psn);
  $products->execute();
}catch(PDOException $e){
  $errMsg .= "錯誤原因 : ".$e -> getMessage(). "<br>";
  $errMsg .= "錯誤行號 : ".$e -> getLine(). "<br>";
}
?>  
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>查詢商品資料</title>
<style>
th {
  background:#bfbfef;
}
td {
  border-bottom:1px deeppink dotted;
}
</style>
</head>

<body>
<?php 
if( $errMsg != ""){ //例外
  echo "<div><center>$errMsg</center></div>";
}elseif($products->rowCount()==0){
      echo "<div><center>查無此商品資料</center></div>";
}else{
      $prodRow = $products->fetchObject();
?>
<br>
<h2 style="text-align:center;color:deeppink">書籍基本資料</h2>
  <table align="center" width="300" >
    <form action="prodUpdateToDb.php">
      <input type="hidden" name="psn" value="<?php echo $prodRow->psn;?>">
    <tr><th>書號</th><td><?php echo $prodRow->psn;?></td></tr>
    <tr><th>書名</th><td><input type="text" name="pname" value="<?php echo $prodRow->pname;?>"></td></tr>
    <tr><th>價格</th><td><input type="text" name="price" value="<?php echo $prodRow->price;?>"></td></tr>
    <tr><th>作者</th><td><input type="text" name="author" value="<?php echo $prodRow->author;?>"></td></tr>
    <tr><th>頁數</th><td><input type="text" name="pages" value="<?php echo $prodRow->pages;?>"></td></tr>
    <tr><th>圖檔</th><td><input type="text" name="image" value="<?php echo $prodRow->image;?>"></td></tr>
    <tr><td colspan="2" align="center"><input type="submit" value="確定修改"></td></tr>
    </form>
  </table>
  <?php

}
?>
</body>
</html>
