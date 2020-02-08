<?php
 
	$dsn = '';
	$user = '';
	$password = '';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql = "CREATE TABLE IF NOT EXISTS datas3"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "created DATETIME,"
	. "pass char(4)"
	.");";
	$stmt = $pdo->query($sql);



    if ( isset( $_POST['send'] ) === true ) {
 
       
 		$name = $_POST['name'];
		$comment = $_POST['comment']; 
		$created = date('Y-m-d H:i:s');
		$pass = $_POST['pass'];
        if ( $name !== '' && $comment !== '' && $pass !=='' ) {
 		$sql = $pdo -> prepare("INSERT INTO datas3 (name, comment, created, pass) VALUES (:name, :comment, :created, :pass)");
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':created', $created, PDO::PARAM_STR);
		$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);	
		$sql -> execute();
        
	}else{
		echo "入力事項が足りません";
	}
	
	
    }
//削除機能

    if( isset($_POST['deletesub']) === true and $_POST['pass']!==''){
    		$pass = $_POST['pass'];
		$delete = $_POST['delete'];

	if($delete !==""){
		$stmt =$pdo -> prepare("DELETE FROM datas3 WHERE id = :delete AND pass = :pass");
		$stmt -> bindParam(':delete', $delete, PDO::PARAM_STR);
		$stmt -> bindParam(':pass', $pass , PDO::PARAM_STR);
		$stmt -> execute();
	}else{
		echo "削除したい番号を入れてね";
	}
    }elseif( isset($_POST['deletesub']) === true and $_POST['pass']==''){
    	echo"パスワードを入れて！";
    }

	
    
    if( isset($_POST['hensyusub'])===true and $_POST['pass']!==''){

    	if($_POST['name'] !== "" and $_POST['comment'] !== ""){
	    	$hensyu=$_POST['hensyu'];
	    	$name = $_POST['name'];
	    	$comment = $_POST['comment'];
	    	$created=date('Y-m-d H:i:s');
	    	$pass = $_POST['pass'];
	    	
	    		$sql = 'update datas3 set name=:name,comment=:comment, created=:created WHERE id=:hensyu AND pass=:pass';
			$stmt = $pdo ->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':created',$created,PDO::PARAM_STR);
			$stmt->bindParam(':hensyu', $hensyu, PDO::PARAM_STR);
			$stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
			$stmt->execute();
	
		
	}else{
		echo "名前とコメントを入力して下さい";
	}
    }elseif( isset($_POST['hensyusub'])===true and $_POST['pass']==''){
    	echo "パスワードを入力して！";
    }
		




	
    	//入力したデータをselectで表示する。
	//$rowの添字（[ ]内）は4-2でどんな名前のカラムを設定したかで変える必要がある。
	$sql = 'SELECT * FROM datas3';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();

            
?>
 
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form method="post" action="">
            パスワード<input type = "text" name = "pass" value = ""><br>
            名前　　<input type="text" name="name" value="" /><br>
            コメント<textarea name="comment" rows="4" cols="20"></textarea>
           <input type="submit" name="send" value="書き込む" /><br>
           
	   削除番号<input type="text" name="delete" value="">
	   <input type="submit" name="deletesub" value="削除"><br>
	
	編集番号<input type  = "text" name = "hensyu" value="">
	<input type = "submit" name = "hensyusub" value="編集"><hr>
	<input type= "hidden" name= "password" value = "<?php echo $_POST['pass'] ?>"
	
        </form>
<?php
   
    foreach( $results as $row ){
    	echo $row['id'] .' 　 ';
        echo $row['name'] .' 　 ';
        echo $row['comment'] .' 　 ';
	echo $row['created'].'<hr>';
        
    }
?>
    </body>
</html>