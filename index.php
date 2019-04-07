<?php
include('fun.php');
global $state,$sure,$music_name;
$sure = 0;
$state = "请放入链接。";

//echo $file_name; 
$download = "btn btn-outline-success btn-lg btn-block disabled";


$mp3url = "http://music.163.com/song/media/outer/url?id=";



if(!empty($_GET['url']))
{
	
	$url = $_GET['url'];
	
	$id = get_id($url);//链接转id


	get_music($id);//获取音乐	


//	echo $music_name;

}
else
{
	$state = "没有获取正确的歌曲链接!";	
}



download_status();

?>

<html>
<head>
<meta charset="utf-8">
  <title>某云歌曲下载</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>

<body>

		<div class="jumbotron jumbotron-fluid">
			<div class="container">
  		<h5>某云音乐下载<span class="badge badge-info badge-pill">1.0 Bate</span></h5> 
  		<p>将链接粘贴到文本框进行查找</p> 
		
				<div id="alert" class="alert alert-primary">
				<?php echo $state;?>
					
				</div>
				<form onsubmit="setcookle();" action="" method = "get">
			  	
				<input name="url" type="text" id="inputurl" class="form-control" placeholder="请输入链接地址">

				<br>  
				<button  onClick=""  type="submit"  class="btn btn-primary btn-lg btn-block">提交</button>

				
			  
				</form>
				
<form action = "download.php" method = "get">
	<input value="<?php if(!empty($music_name) && !empty($id))
	{
		echo $id;
	}?>" name="id" type="text" id="" style="display: none">
	
	<input id="music_name" value="<?php if(!empty($music_name) && !empty($id))
	{
		echo $music_name;
	}?>" name="music_name" type="text" id="" style="display: none">
			
	<button onClick="loading();" type="submit" class="<?php echo $download; ?>" id="download" >
				下载	
	</button>
</form>
		</div>
			
		  <div style="visibility: hidden" class="loader" id="loading">
    <svg class="circular" viewBox="25 25 50 50">
      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
    </svg>
  </div>	
			
			
		</div>

	<script>
		
	function loading()
		{
			document.getElementById('loading').style.visibility = "visible";
		}
		
		
	document.getElementById("inputurl").value = "<?php echo $_GET['url']; ?>";
	
	window.onblur = function(){
		document.getElementById('loading').style.visibility = "hidden";
	// alert(msg);
	}
	
	
	</script>
	
	<script  src="js/index.js"></script>
</body>

</html>
