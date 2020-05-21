	<?php
		//一个完整的登录需要开启session
		//开启session
		session_start();
		//判断存在session则跳过登录页面直接进入首页否则输入用户名密码登录
		if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
			header('Location:index.php');
			exit;
		}else{
		@$po = $_POST['tijiao'];
		if($po){
			include_once './lib/fun.php';//读取数据库连接信息文件
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			//判断用户名输入是否为空
			if(!$username){
				echo "用户名不能为空!";
				exit;
			}
			if(!$password){
				echo "密码不能为空!";
				exit;
			}
			//数据库连接
			$con= mysqlIit('127.0.0.1','root','123456','xiaoan_swb');
			if(!$con){
				echo "加".mysql_errno();
				exit;
			}
			$sql = "select * from sw_user where user_name = '{$username}' LIMIT 1";
			$obj = mysqli_query($con,$sql);
			$result = mysqli_fetch_assoc($obj);
			if(is_array($result)&&!empty($result)){
				//var_dump ($result);//数据库中有$user_name这个用户名并不为空时执行登录
				//echo $result['user_pwd'];
				//echo createPassword($password);
				if(createPassword($password) === $result['user_pwd']){
					$_SESSION['user'] = $result;//把用户信息存进session
					//echo '登录成功！';
					//登录成功后直接跳转到首页
					header('Location:index.php');
				}else{
					echo '密码错误！';
				}
				exit;
			}else{
				echo '用户不存在，请检查后重新输入！';
				exit;
			}
		}
	}
	?>
	<!DOCTYPE html>
	<html>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<head>
	<meta charset="utf-8">
	<title>用户登录 - 散文吧</title>
	<link rel="stylesheet" href="css/log.css" />
	</head>
	<body>
	  <div id="content">
	    <form action="long.php" method="post">
	      <div>
	        	<label>用户名:</label>
	        	<input name="username" class="txt" /></div>
	        <div style="margin-top:15px;">
	        	<label>密&nbsp;&nbsp;&nbsp;码:</label>
	        	<input name="password" class="txt" type="password" />
	        </div>
	        <div style="margin-top:15px;margin-left: 75%;">
	          <input type="submit" value="登录" class="submit" name="tijiao"/>
	        </div>
	      </form>
	    </div>

	  </body>
	</html>
