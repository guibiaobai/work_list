<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<?php

function echohtml()
{
	echo "<form action='/phpenglish/aotuagain.php' method='post'>
	<input type='submit' name='next' value='next'>
	<input type='submit' name='pre' value='pre'>
	<input type='submit' name='auto' value='auto' >
	<input type='submit' name='stop' value='stop' >
	</form>";
}

	$next = isset($_POST['next']) ? 1 : 0;
	$pre = isset($_POST['pre']) ? 1 : 0;
	$auto = isset($_POST['auto']) ? 1 : 0;
	$stop = isset($_POST['stop']) ? 1 : 0;

	$array = unserialize(file_get_contents('add.txt'));
	$count = count($array);
	$keyset = array_keys($array);
	
	echo "一共有 $count 个单词"."<br>";
	
	//根据提供的参数来反映
	if($next)
	{
		optnext($array,$keyset,$count);
		echohtml();
	}else if($pre)
	{
		optpre($array,$keyset,$count);
		echohtml();
	}else if($auto)
	{
		optauto($array,$keyset,$count);
		echohtml();
	}else if($stop)
	{
		echo "stop";
		echohtml();
	}else
	{
		echo "默认模式.<br>";
		optauto($array,$keyset,$count);
		echohtml();
	}	
		
		
		
		//voice
	function optallecho($key,$value,$num)
	{
		echo $num."->".$key ."<br><br><br>".$value;
		echo "<embed src=\"wma/{$key}.mp3\" loop=\"0\" autostart=\"true\" hidden=\"true\"></embed>";
		echo "<br><br><br><br>";
	}
	
	
	function optnext($array,$keyset,$count)
	{
		$url = unserialize(file_get_contents('url.txt'));
		if($url>=count($array))
		{
			$url=0;
		}
		$temp = $url + 1;
		file_put_contents('url.txt', serialize($temp));
		$key = $keyset[$url];//index
		$value = $array[$key];
		optallecho($key,$value,$url);
	}
	
	function optpre($array,$keyset,$count)
	{
		$url = unserialize(file_get_contents('url.txt'));
		$url-=2;
		if ($url==-1) {
			$url =1788;
		}
		$temp = $url + 1;
		file_put_contents('url.txt', serialize($temp));
		$key = $keyset[$url];//index
		$value = $array[$key];
		optallecho($key,$value,$url);
	}
	
	function optauto($array,$keyset,$count)
	{
		echo "<meta http-equiv=\"refresh\" content=\"2\">";
		$array = unserialize(file_get_contents('add.txt'));
		$count = count($array);
		$keyset = array_keys($array);
		
		$url = unserialize(file_get_contents('url.txt'));
		$url = $url % count($array);
		$temp = $url + 1;
		file_put_contents('url.txt', serialize($temp));
		$key = $keyset[$url];
		$value = $array[$key];
		optallecho($key,$value,$url);
	}
	
	


?>