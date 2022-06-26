<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続関数：db_conn()
function db_conn(){
    try {
        //localhostの場合
        $db_name = "db_hunting";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト

        //localhost以外＊＊自分で書き直してください！！＊＊
        if($_SERVER["HTTP_HOST"] != 'localhost'){
            $db_name = "yokoyuichi_db_hunting";  //データベース名
            $db_id   = "yokoyuichi";  //アカウント名（さくらコントロールパネルに表示されています）
            $db_pw   = "bo-bass61";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
            $db_host = "mysql57.yokoyuichi.sakura.ne.jp"; //例）mysql**db.ne.jp...
        }
        return new PDO('mysql:dbname='.$db_name.';charset=utf8;host='.$db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:'.$e->getMessage());
    }
}

//SQLエラー関数：sql_error($stmt)

function sql_error($stmt){
        $error = $stmt->errorInfo();
        exit("SQLError:".$error[2]);    
}


//リダイレクト関数: redirect($file_name)

function redirect ($file_name){
    header("Location: ".$file_name);
    exit();
}




