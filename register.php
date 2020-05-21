	<?php
		@$po = $_POST['tijiao'];
		if($po){
			include_once './lib/fun.php';//读取数据库连接信息文件
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			//判断用户名输入是否为空
			if(!$username){
				echo "用户名密码不能为空!";
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
			//插入数据之前判断用户是否在数据表中存在！
			$sql = "select * from sw_user where user_name = '$username'";
			$obj = mysqli_query($con,$sql);
			$result = mysqli_fetch_assoc($obj);
			if($result>0||$result!=""){
				echo "用户名已存在".mysql_errno();
				//var_dump($obj);
				exit;
			}
			//密码加密
			$password = createPassword($password);
			//注销资源类型
			//unset($obj,$result,$sql);
			//注册--插入数据
			//echo "查询结果为空，可以注册";
			$id = rand(1,9999);
			$sql = "INSERT INTO sw_user(id,user_name,user_pwd,user_time) VALUES ('$id', '$username', '$password', '{$_SERVER['REQUEST_TIME']}')";
			$obj= mysqli_query($con,$sql);
			if($obj){
				echo "注册成功!";
				exit;
			}else {
				echo mysql_error();
				echo "注册失败！";
				exit;
				}
		}
	?>
	<!DOCTYPE html>
	<html>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<head>
	<meta charset="utf-8">
	<title>用户注册 - 散文吧</title>
	<link rel="stylesheet" href="css/log.css" />
	</head>
	<body>
	  <div id="content">
	    <form action="register.php" method="post">
	      <div>
	        	<label>用户名:</label>
	        	<input name="username" class="txt" /></div>
	        <div style="margin-top:15px;">
	        	<label>密&nbsp;&nbsp;&nbsp;码:</label>
	        	<input name="password" class="txt" type="password" />
	        </div>

	        <div style="margin-top:15px;margin-left: 75%;">
	          <input type="submit" value="注册" class="submit" name="tijiao"/>
	        </div>
	      </form>
	    </div>
	  </body>
	</html>
