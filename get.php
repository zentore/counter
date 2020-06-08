<?php
/**
 * アクセスカウンターAPI
 * 
 * @author M.Katsube <katsubemakito@gmail.com>
 * @version 1.0.0
 */

// デバッグ時にエラーを画面に表示したい場合は以下をコメントアウトする
// ini_set('display_errors', "On");

//-----------------------------------
// 定数
//-----------------------------------
define('DATA_FILE', 'data.txt');

//-----------------------------------
// メイン処理
//-----------------------------------
// 現在の値を取得(カウントアップする)
$count = getCounter(DATA_FILE);

// 現在の値を返却する
header('Content-type: application/json');
echo json_encode([
      'status' => true
    , 'count'  => $count
]);


/**
 * カウンターの値を取得
 * 
 * @param  string $file
 * @return integer
 */
function getCounter($file){
    // データを取得する
    $fp = fopen($file, 'r+'); // ファイルを読み込み+書き込みモードで開く
    flock($fp, LOCK_EX);      // ファイルをロックする
    $buff = (int)fgets($fp);  // ファイルから1行読み込み

    // ファイルを空にする
    ftruncate($fp, 0);    // ファイルサイズをゼロにする
    fseek($fp, 0);        // ファイルポインタを先頭に戻す

    // +1した数値を書き込む
    fwrite($fp, $buff+1);

    // ファイルを閉じる
    flock($fp, LOCK_UN);  // ファイルのロックを解除
    fclose($fp);          // ファイルを閉じる

    return($buff);
}

