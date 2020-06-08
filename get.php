<?php
/**
 * アクセスカウンターAPI (DB版)
 * 
 * @author M.Katsube <katsubemakito@gmail.com>
 * @version 1.0.0
 */

// デバッグ時にエラーを画面に表示したい場合は以下をコメントアウトする
// ini_set('display_errors', "On");

//-----------------------------------
// 定数
//-----------------------------------
define('DB_DSN',  'mysql:dbname=access;host=127.0.0.1');  // 接続先
define('DB_USER', 'senpai');    // MySQLのID
define('DB_PW',   'indocurry'); // MySQLのパスワード

//-----------------------------------
// メイン処理
//-----------------------------------
// DBに接続する
$dbh = connectDB(DB_DSN, DB_USER, DB_PW);

// DBに1レコード追加する
addCounter($dbh);

// 現在のレコード数をカウントする
$count = getCounter($dbh);

// 現在のレコード数を返却する
header('Content-type: application/json');
echo json_encode([
      'status' => true
    , 'count'  => $count
]);


/**
 * DBサーバへ接続
 * 
 * @param  string $dsn  接続先の情報(IPアドレス、DB名など)
 * @param  string $user ユーザーID
 * @param  string $pw   パスワード
 * @return object
 */
function connectDB($dsn, $user, $pw){
    $dbh = new PDO($dsn, $user, $pw);   //接続
    return($dbh);
}

/**
 * 1レコード追加する
 * 
 * @param  object $dbh
 * @return boolean
 */
function addCounter($dbh){
    // SQLを準備
    $sql = 'INSERT INTO access_log(accesstime) VALUES(now())';

    // 実行する
    $sth = $dbh->prepare($sql);   // SQLを解析
    $ret = $sth->execute();       // 実行

    return($ret);
}

/**
 * 現在のレコード数を集計する
 * 
 * @param  object $dbh
 * @return integer|boolean
 */
function getCounter($dbh){
    // SQLを準備
    $sql = 'SELECT count(*) as count FROM access_log';

    // 実行する
    $sth = $dbh->prepare($sql);    // SQLを解析
    $sth->execute();               // 実行

    // 実行結果を取得
    $buff = $sth->fetch(PDO::FETCH_ASSOC);
    if( $buff === false){
        return(false);
    }
    else{
        return( $buff['count'] );
    }
}