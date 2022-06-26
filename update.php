<?php
//1. POSTデータ取得
$id = $_POST['id'];
$name = $_POST['name'];
$trap = $_POST['trap'];
$animal = $_POST['animal'];
$number = $_POST['number'];
$memo = $_POST['memo'];
$date = $_POST['date'];
$lat = $_POST['lat'];
$lon = $_POST['lon'];

//2. DB接続します
include("funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数


//３．データ登録SQL作成
$stmt = $pdo->prepare("update hunter_map set date=:date, name=:name, lon=:lon, lat=:lat, animal=:animal, number=:number, trap=:trap, memo=:memo where id=:id");
$stmt->bindValue(':date', $date, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lon', $lon, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lat', $lat, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':animal', $animal, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':number', $number, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':trap', $trap, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':memo', $memo, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id,  PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();


//４．データ登録処理後
if($status==false){
    sql_error($stmt);
}else{
    redirect("index3.php");
}

?>
