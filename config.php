<?php  require_once "database.php";
	switch ($_GET["method"]) {
		case "login":
			login();
			break;
		case "signup":
			signup();
			break;
		case "logout":
			logout();
			break;
		default:
			break;
	}

	function login(){  //如資料庫資料匹配即記下ID導向首頁
		$sql="SELECT * FROM `member`
				WHERE username = '$_POST[username]' && password = '$_POST[password]'";
		global $con;
		$result = mysqli_query($con , $sql) or die('MySQL query error');
	    $row = mysqli_fetch_array($result);
	    if($row==""){
			echo "<script type='text/javascript'>";
			echo "alert('帳密錯誤');";
			echo "location.href='login.php';";
			echo "</script>";
	    }else{
	    	session_start();
	    	$_SESSION["id"] = $row['id'];
	    	echo "<script type='text/javascript'>";
			echo "alert('登入成功');";
			echo "location.href='index.php';";
			echo "</script>";
	    }
	} 

	function signup(){

		//檢查username是否已經存在(不存在即傳回空值)，不是空值代表資料庫內已有資料
		$sql="SELECT * FROM `member`
				WHERE username = '$_POST[username]'";
		global $con;
	    $result = mysqli_query($con , $sql) or die('MySQL query error');
	    $row = mysqli_fetch_array($result);
		if($row!=""){
			echo "<script type='text/javascript'>";
			echo "alert('已經辦過帳號囉');";
			echo "location.href='login.php';";
			echo "</script>";
		}
		else{
			//插入資料，記下ID值
			$sql="INSERT INTO `member` (username, password, name)
					VALUES ('$_POST[username]','$_POST[password]','$_POST[name]')";
			global $con;
		    $result = mysqli_query($con , $sql) or die("MySQL query errors");
		    
			$sql="SELECT * FROM `member`
				WHERE username = '$_POST[username]' && password = '$_POST[password]'";
			global $con;
	    	$result = mysqli_query($con , $sql) or die('MySQL query error');
	    	$row = mysqli_fetch_array($result);		    
		    session_start();
	    	$_SESSION["id"] = $row["id"];
		 	echo "<script type='text/javascript'>";
			echo "alert('註冊成功');";
			echo "location.href='index.php';";
			echo "</script>";
		}
	} 

	function logout(){  
		//如ID有值，清空SESION後回到首頁
		session_start();
		if(isset($_SESSION["id"])){
			session_unset();
			echo "<script type='text/javascript'>";
			echo "alert('登出成功');";
			echo "location.href='index.php';";
			echo "</script>";
		}
	} 

?>
