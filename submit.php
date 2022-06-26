<?php
//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ
$name = $_POST['name'];
$trap = $_POST['trap'];
$animal = $_POST['animal'];
$number = $_POST['number'];
$memo = $_POST['memo'];
$date = $_POST['date'];
$date = str_replace(',', '', $date);
$lat = $_POST['lat'];
$lon = $_POST['lon'];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=db_hunting;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DBConnection Error:'.$e->getMessage());
}


//３．データ登録SQL作成
$stmt = $pdo->prepare("insert into hunter_map(date, name, lon, lat, animal, number, trap, memo) values(:date, :name, :lon, :lat, :animal, :number, :trap, :memo)");
$stmt->bindValue(':date', $date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lon', $lon, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lat', $lat, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':animal', $animal, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':number', $number, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':trap', $trap, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

 //４．データ登録処理後
 if($status==false){
   //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
   $error = $stmt->errorInfo();
   exit("SQL_ERROR:".$error[2]);
 }else{
   //５．index.phpへリダイレクト
   header("Location: index3.php");
   exit();
 }
?>