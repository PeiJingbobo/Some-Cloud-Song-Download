<?php

//下载函数.
function down($save_dir,$filename,$music_name)
{
	
	$down_host = $_SERVER['HTTP_HOST'].'/'; //当前域名
	if(file_exists(__DIR__.'\\'.$save_dir.$filename))
	{	
  	//发送消息头,提供下载
	$file = __DIR__.'\\'.$save_dir.$filename;
	$filename = $music_name;
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header("Content-type:text/html;charset=utf-8");
	header('Content-Disposition: attachment; filename='. $filename);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	readfile($file);
	exit;
	}
	else
	{
    header('HTTP/1.1 404 Not Found');
	}
}


//如果本地有资源从本地查找,如果本地没有再去下载

if(!empty($_GET['id']) && !empty($_GET['music_name']))
{
	$id = $_GET['id'];
	$music_name = $_GET['music_name'];
	$url = "http://music.163.com/song/media/outer/url?id=".$id.'.mp3';
	
	$save_dir = 'mp3/';//保存的路径

	$filename = '';//默认文件名

	$type = 0;

	if(trim($filename) == '')
	{
		//ext 保存文件扩展名变量
		$ext = strrchr($url,'.'); //返回 '.' 字符最后一次数显的位置后面所有字符也就是文件扩展名
		
		if($ext != '.mp3')
		{
			echo '文件类型错误';
		}//用来检测网络上的文件是否为音乐文件

		$filename = substr($url,strripos($url,"?id=")+4); 
	}

	
echo 'HELLO';

if(file_exists(__DIR__.'\\'.$save_dir.$filename))
{
	//echo "存在!进行传递!".'<br>';
	down($save_dir,$filename,$music_name);
}
else
{
	//echo '不存在,正在进行下载!'.'<br>';
	
	ob_start();  //建立缓冲区
	@readfile($url); //获取文件到缓冲区
    $music = ob_get_contents();  //获取文件到变量
    ob_end_clean();  //关闭文件
//}
	//echo $filename;
	
	$fp2 = fopen($save_dir.$filename,'a');
//新建一个文件
	fwrite($fp2,$music);
//	将变量写入文件
	fclose($fp2);
//关闭文件
	down($save_dir,$filename,$music_name);
}
	


//echo '获取成功!'.'<br>'.$music_name;


}
else
{
	//如果没有传入参数或者传入参数不合法
	echo '参数错误!';
}





?>
