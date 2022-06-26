<?php
//１．PHP
//select.phpの[PHPコードだけ！]をマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET["id"];

include("funcs.php");  //funcs.phpを読み込む（関数群）
$pdo = db_conn();      //DB接続関数

//２．データ登録SQL作成
$stmt   = $pdo->prepare("SELECT * FROM hunter_map WHERE id = :id"); //SQLをセット
$stmt->bindValue(':id',   $id,    PDO::PARAM_INT);
$status = $stmt->execute(); //SQLを実行→エラーの場合falseを$statusに代入

//３．データ表示
$view=""; //HTML文字列作り、入れる変数
if($status==false) {
  //SQLエラーの場合
  sql_error($stmt);
}else{
  //SQL成功の場合
  $row = $stmt->fetch(); //1つのデータを取り出して$rowに格納
  $pin = "let pin = map.pinText({$row['lat']}, {$row['lon']}, '{$row['animal']}', '{$row['date']}', '{$row['id']}'); ";
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="sample_detail.css" rel="stylesheet">

</head>
<body>

<!-- Main[Start] -->
    <h1>データ更新画面</h1>
    <form method = "post" action="update.php" class="form">
    <div class="jumbotron">
    <fieldset>
        <legend>狩猟入力フォーム</legend>
        <div class="item">
            <label class="label_left">名前：（任意）<input type="text" name="name" id="name" value="<?=$row["name"]?>"></label><br>
        </div>
        <div class="item">
        <label class="label_left">猟の種類：<select name="trap" id="trap"　>
        <option hidden selected>猟の種類を選択</option>
            <option value = "銃猟">銃猟</option>
            <option value = "箱罠">箱罠</option>
            <option value = "くくり罠">くくり罠</option>
            <option value = "囲い罠">囲い罠</option>
            <option value = "その他">その他</option>
        </select>  
        （変更前：<?=$row["trap"]?>）
        </label><br>
        </div>
        <div class="item">
        <label class="label_left">動物：<select name="animal" id="animal" value="<?=$row["animal"]?>">
        <option hidden selected>動物の種類を選択</option>
            <option value = "イノシシ">イノシシ</option>
            <option value = "シカ">シカ</option>
            <option value = "キョン">キョン</option>
            <option value = "アライグマ">アライグマ</option>
            <option value = "ハクビシン">ハクビシン</option>
            <option value = "その他">その他</option>
        </select>  
        （変更前：<?=$row["animal"]?>）    
        </label><br>     
        </div>
        <div class="item">
        <label class="label_left">捕獲数：<select name="number" id="number">
        <option hidden selected>捕獲数を選択</option>
            <option value = "1">1</option>
            <option value = "2">2</option>
            <option value = "3">3</option>
            <option value = "4">4</option>
            <option value = "5">5</option>
            <option value = "6">6</option>
            <option value = "7">7</option>
            <option value = "8">8</option>
            <option value = "9">9</option>
        </select>  
        （変更前：<?=$row["number"]?>）
        </label><br>
        </div>
        <div class="item">
        <label class="label_left">メモ：<br><textArea name="memo" id="memo" value="<?=$row["memo"]?>"></textArea></label><br>
        </div>
        <div class="item"><label class="label_left">日時：<input type='text' name='date' id='date' value = "<?=$row["date"]?>"></label><br></div>
        <div class="item"><label class="label_left">緯度：<input type='text' name='lat' id='lat' value = "<?=$row["lat"]?>"></label><br></div>
        <div class="item"><label class="label_left">経度：<input type='text' name='lon' id='lon' value = "<?=$row["lon"]?>"></label><br></div>
        <input type='hidden' name='id'  value = "<?=$row["id"]?>">
        <button type="submit" id="button">更新</button>
        </fieldset>
    </div>
    </form>
    <div id="myMap" style='width:70%;height:70%;'></div>
    </body>

    <!-- マップ表示 -->
    <!-- jQuery&GoogleMapsAPI -->
    <script src='https://code.jquery.com/jquery-2.1.4.min.js' type='text/javascript'></script>
    <!-- javascript -->

    <!-- /jQuery&GoogleMapsAPI -->
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApXo3--EVXEFu9rGcEVMM4EUg-v5AMG6vSaMpEq4Olb7pEKJuBdbjyemGeq3AFVd' async defer></script>
    <script type='text/javascript' src="BmapQuery.js"></script>
    
    <script type="text/javascript" defer>
//map表示


function GetMap(){
     //------------------------------------------------------------------------
     //1. Instance
     //------------------------------------------------------------------------
     map = new Bmap("#myMap");
     //Main:位置情報を取得する処理 //getCurrentPosition :or: watchPosition
     navigator.geolocation.getCurrentPosition(mapsInit, mapsError, set);
 }
 function mapsInit(position) {
    //lat=緯度、lon=経度 を取得
    lat = position.coords.latitude;
    lon = position.coords.longitude;
    console.log(lat)
    console.log(lon)
        map.startMap(lat, lon, "load", 20); 
        <?php echo $pin; ?>; // 捕獲位置を表示

        //クリックした位置の緯度経度を記録
        map.onGeocode("click", function(data){
        console.log(data);                   //Get Geocode ObjectData
        const latclick = data.location.latitude;  //Get latitude
        const lonclick = data.location.longitude; //Get longitude
        console.log(latclick)
        console.log(lonclick)
        $("#lat").val() = latclick
        $("#lon").val() = lonclick
    });
    }
      
  function mapsError(error){
    if(error.code==1){
      alert("位置情報の取得が許可されていない")
    }
    else if(error.code==2){
      alert("位置情報の取得が利用できない")
    }
    if(error.code==3){
      alert("タイムアウト")
    }
  }
  var set ={
    enableHighAccuracy: true, //より高精度な位置を求める
    maximumAge: 20000,        //最後の現在地情報取得が20秒以内であればその情報を再利用する設定
    timeout: 10000            //10秒以内に現在地情報を取得できなければ、処理を終了
  };

//ここまでMap
</select>
    
</html>