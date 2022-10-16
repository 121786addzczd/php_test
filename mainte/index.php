<?php

require 'db_connection.php';

// ユーザー入力ある場合 query
// $sql = 'select * from contacts where id = 4'; // sql
// $stmt = $pdo->query($sql); // sql文実行 ステートメント

// $result = $stmt->fetchall(); // fetchallメソッドはslqの結果を表示

// echo '<pre>';
// var_dump($result);
// echo '</pre>';

// ユーザー入力あり prepare, bind, execute 悪意のあるユーザー delete * SQLインジェクション
$sql = 'select * from contacts where id = :id'; //名前つきプレースホルダ
$stmt = $pdo->prepare($sql);//プリペアードステートメント
$stmt->bindValue('id', 4, PDO::PARAM_INT); //紐付け
$stmt->execute(); //実行

$result = $stmt->fetchall(); // fetchallメソッドはslqの結果を表示

echo '<pre>';
var_dump($result);
echo '</pre>';

// トランザクション まとまって処理 beginTransaction, commit, rollback
// ex)銀行 残高を確認->Aさんから引き落とし->Bさんに引き落とし->Bさんに振り込み

$pdo->beginTransaction();

try{

//sql処理
$stmt = $pdo->prepare($sql);//プリペアードステートメント
$stmt->bindValue('id', 4, PDO::PARAM_INT); //紐付け
$stmt->execute(); //実行

$pdo->commit();

}catch(PDOException $e){

$pdo->rollback();//更新のキャンセル
}
