<html>

 <head>
  <title>mission_4</title>
  <meta charset="utf-8">
 <head/>

 <body>

<?php

//データベース接続
$dsn='mysql:dbname=データベース名;host=localhost';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>
PDO::ERRMODE_WARNING));

//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission4_table"
."("
."id INT,"
."name char(32),"
."comment TEXT,"
."date TEXT,"
."password TEXT"
.");";

$stmt=$pdo->query($sql);

//入力
if(empty($_POST["id"])&&!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["cpassword"])){

$name=$_POST["name"];
$comment=$_POST["comment"];
$password=$_POST["cpassword"];
$id=1;
$date=date("Y/m/d H:i:s", time());


$sql='SELECT * FROM mission4_table';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
 ++$id;
}

 $sql=$pdo->prepare("INSERT INTO mission4_table (id,name,comment,date,password)VALUES(:id,:name,:comment,:date,:password)");
 $sql->bindParam(':id',$id,PDO::PARAM_INT);
 $sql->bindParam(':name',$name,PDO::PARAM_STR);
 $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
 $sql->bindParam(':date',$date,PDO::PARAM_STR);
 $sql->bindParam(':password',$password,PDO::PARAM_STR);
 $sql->execute();
}

//編集対象選択
if(!empty($_POST["edit"]) && !empty($_POST["epassword"])){//編集対象番号とパスワード入ってたら

$id=$_POST["edit"];
$password=$_POST["epassword"];

$sql='SELECT * FROM mission4_table';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();

 foreach($results as $row){
  if($row['id']==$id && $row['password']==$password){//投稿番号と編集番号、パスワードが一致したら

   $edinum=$row['id'];
   $ediname=$row['name'];
   $edicomment=$row['comment'];
   $edipass=$row['password'];

   break;
   }//一致したら、閉じ


   if($row['id']==$id && $row['password']!==$password){//投稿番号と編集番号、パスワードが一致しなかったら
   echo"パスワードが違います。";
   }//一致しなかったら閉じ

 }//foreach閉じ
}

//編集実行
if(!empty($_POST["id"])&&!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["cpassword"])){//hiddenに番号入ってたら

 $id=$_POST["id"];
 $name=$_POST["name"];
 $comment=$_POST["comment"];
 $password=$_POST["cpassword"];
 $date=date("Y/m/d H:i:s", time());

 $sql="update mission4_table set name=:name,comment=:comment,date=:date,password=:password where id=:id";
 $stmt=$pdo->prepare($sql);
 $stmt->bindParam(':name',$name,PDO::PARAM_STR);
 $stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
 $stmt->bindParam(':id',$id,PDO::PARAM_INT);
 $stmt->bindParam(':date',$date,PDO::PARAM_INT);
 $stmt->bindParam(':password',$password,PDO::PARAM_STR);
 $stmt->execute();

}//hiddenに番号入ってたら、閉じ

//削除
if(!empty($_POST["delete"])&&!empty($_POST["dpassword"])){//削除対象番号に番号入ってたら

   $id=$_POST["delete"];
   $password=$_POST["dpassword"];


 $sql='SELECT * FROM mission4_table';
 $stmt=$pdo->query($sql);
 $results=$stmt->fetchAll();

  foreach($results as $row){
   if($row['id']==$id && $row['password']==$password){//投稿番号と削除対象番号、パスワードが一致したら

   $id=$_POST["delete"];
   $sql='delete from mission4_table where id=:id';
   $stmt=$pdo->prepare($sql);
   $stmt->bindParam(':id',$id,PDO::PARAM_INT);
   $stmt->execute();


    break;

    }
   }
    if($row['password']!==$password){//投稿番号と削除対象番号、パスワードが一致しなかったら
    echo"パスワードが違います。";
    }//閉じ

}
?>

 <form method="POST" action="mission_4.php">
   <input type="text" name="name" placeholder="名前" value="<?php echo $ediname;?>"><br/>
   <input type="text" name="comment" placeholder="コメント" value="<?php echo $edicomment;?>"><br/>
   <input type="text" name="cpassword" placeholder="パスワード">
   <input type="hidden" name="id" value="<?php echo $edinum;?>">
   <input type="submit" name="btn" value="送信"><br/>
    <br/>
   <input type="text" name="delete" placeholder="削除対象番号"><br/>
   <input type="text" name="dpassword" placeholder="パスワード">
   <input type="submit" name="btn" value="削除"><br/>
    <br/>
   <input type="text" name="edit" placeholder="編集対象番号"><br/>
   <input type="text" name="epassword" placeholder="パスワード">
   <input type="submit" name="btn" value="編集">

 </form>

<?php
//表示機能
$sql='SELECT * FROM mission4_table';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){

echo $row['id'].' ';
echo $row['name']." ";
echo $row['comment']." ";
echo $row['date'].'<br>';
}
?>

</body>
</html>