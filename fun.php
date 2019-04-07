<?php

function get_id($url)//获取歌曲id并返回字符串
{
	global $state;
	
	if(strpos($url,'?id='))//如果链接内存在id
	{
		if(strpos($url,'&userid='))//获取id和userid之间的数据
		{

		$music_id = substr($url,29,39);

		$id_temp = substr($url,strripos($url,"?id=")+4);

		$music_id = substr($id_temp,0, strripos($id_temp,'&userid='));
		
	//	echo "存在userid:";
		}
		else	//如果不存在
		{
			
			$music_id = substr($url,strripos($url,'?id=')+4);
		//	echo "不存在userid:";
		}
	}
	else
	{
		
		$id_temp = substr($url,strpos($url,"song/")+5);

		$music_id = substr($id_temp,0, strripos($id_temp,'/?userid='));
		
		//echo($music_id);
	}
	return $music_id;
}


function gte_artists($artists,$artists_num)	//获取全部歌手用"/"分割返回字符串
{
	global $state;
	
	$artists_name = "";//初始化名称变量
	for($num = 0; $num< $artists_num; $num ++)//循环歌手个数次数
	{
		if($num != $artists_num - 1)//如果是最后一位歌手就不在名字后面加上"/"
		{
			$artists_name = $artists_name.$artists[$num]["name"]."/";
		}
		else
		{
			$artists_name = $artists_name.$artists[$num]["name"];
		}
	}
	return($artists_name);
}

function get_music($id)	//获取url上的信息
{
	global $state,$sure,$music_name;
	
	$url = "http://music.163.com/api/song/detail/?id=".$id."&"."ids=%5B".$id."%5D";
	//id后不知道为什么有个ids用 [] 括起来
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch,CURLOPT_HEADER,0);
	
	
	
	$music = curl_exec($ch);

	//获取完成
	curl_close($ch);//关闭链接
	if($music === FALSE)//检测是否返回内容
	{

		$state = "歌曲链接不正确请检查";
		//echo $state;
	}
	else
	{
		$music = json_decode($music,true);
		
		//json解析为数组
		
		if(array_key_exists("msg",$music))
		{
			$state = "歌曲链接暂时找不到内容!";
			//检测是否为错误信息
			
		}
		else
		{
			if(array_key_exists("songs",$music))
			{
				//检测是否存在songs对象
				$songs = $music["songs"];
				
				if(count($songs) != 0)//检测歌曲信息是否为空
				{
					//获取已经存在的歌曲内容
				$songs = $music["songs"][0];
					
				$artists_list = $songs['artists'];//获取歌手列表
				
				$artists_num = count($artists_list);//获取歌手位数
					
				//传入歌手列表和数量获取组合的歌手信息
				$artists = gte_artists($artists_list,$artists_num);
				$music_name = $songs["name"]."-".$artists.".mp3";
				
					$sure = 1;//控制下载按钮是否可用
					
				$state = "获取成功!"." 歌曲: ".$music_name;
					
				$music_name = $songs["name"]."-".$artists.".mp3";
				
				//return($music_name);
	
				}
				else
				{
					$state = "该链接不存在歌曲内容!";

					//echo $state;
				}
			}
			else
			{
				$state = '该链接不存在歌曲内容';
				//获取失败
			}

		}
		//	print_r($songs);
	}	
	//关闭连接
}
//echo $temp;

//检测是否可以激活下载按钮 更改下载按钮的css
function download_status()

{
	global $sure,$download;
	
	if($sure == 1)
	{

		$download =	"btn btn-success btn-lg btn-block ";
	}
	else
	{
		$download =	"btn btn-secondary btn-lg btn-block disabled";
	}
}

//get_id($url);


?>