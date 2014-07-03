<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ระบบบริหารงบประมาณเงินรายได้ คณะการแพทย์แผนไทย มอ.</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<!-- Apple devices fullscreen -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Apple devices fullscreen -->
	<meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>" />

	<!-- Bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
	<!-- Bootstrap responsive -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap-responsive.min.css');?>">
	<!-- jQuery UI remove by kengi -->
	
	<!-- Theme CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css');?>">
	<!-- Color CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/themes.css');?>">
        <!-- MyStyle CSS -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/MyStyle.css');?>">
 
	<!-- jQuery -->
	<script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
	
	
	<!-- MyFunction -->
	<script src="<?php echo base_url('assets/js/MyFunction.js');?>"></script>
	<!-- slimScroll remove by kengi -->
	
	<!-- Bootstrap -->
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>

	
</head>

<body class='login'>
	<div class="wrapper">
		<h1><a href="index.html"><img src="<?php echo base_url('assets/img/logo-big.png');?>" alt="" class='retina-ready' width="59" height="49">TTM-FMIS</a></h1>
		<div class="login-body">
			<h2>PSU-Passport (เวอร์ชั่น 1.1.0)</h2>
			<?php echo form_open('welcome/login'); ?>
				<div class="email">
					<input type="text" name='usr' placeholder="Username" class='input-block-level'>
				</div>
				<div class="pw">
					<input type="password" name="pwd" placeholder="Password" class='input-block-level'>
				</div>
				<div class="submit">
					<select name="budget_year">
					<?php foreach ($budget as $key => $value): ?>	
					   <option value="<?php echo $value["id"]; ?>"><?php echo $value["title"]; ?></option>
					<?php endforeach; ?>   
					</select>
					
					<input type="submit" value="เข้าสู่ระบบ" class='btn btn-primary'>
					
				</div>
			</form>
                  
					   <span style="color: green;font-weight: 900"> รายการและประวัติการอัพเดต >>></span>
                        <a href="<?php echo base_url('assets/update_log.txt');?>" target="_blank">คลิกที่นี่</a>

			<div class="forget">
				<a href="#"><span>ระบบบริหารงบประมาณเงินรายได้ คณะการแพทย์แผนไทย <br/>
					  &copy;ลิขสิทธิ์ 2013-2014 โทรศัพท์.2716 
				</span></a>
			</div>
		</div>
	</div>
	
<script type="text/javascript">


</script>
</body>

</html>