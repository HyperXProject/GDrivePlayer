<?php
$username = "admin";
$password = "0145440762";
$nonsense = "supercalifragilisticexpialidocious";

if (isset($_COOKIE['PrivatePageLogin'])) {
   if ($_COOKIE['PrivatePageLogin'] == md5($password.$nonsense)) {
?>

<?php
	error_reporting(0);
	include "curl_gd.php";

	if($_POST['submit'] != ""){
		$url = $_POST['url'];
		$gid = get_drive_id($url);
		$iframeid = my_simple_crypt($gid);
		$linkdown = Drive($url);
		$file = '[{"type": "video/mp4", "label": "HD", "file": "'.$linkdown.'"}]';
	}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
	<title>GDrivePlayer - Priv8 Embed</title>
</head>
<body>

  <!-- Docs styles -->
  <link rel="stylesheet" href="https://cdn.plyr.io/2.0.13/demo.css">
	<style>
		.container {
		  max-width: 800px;
		  margin: 0 auto;
		}
	</style>

	<div class="container">
		<center><h1>GDrivePlayer - Priv8 Embed</h1></center>
		<br />
		<form action="" method="POST">
			<input type="text" size="80" name="url" value="https://drive.google.com/file/d/0ByaRd0R0Qyatcmw2dVhQS0NDU0U/view"/>
			<input type="submit" value="Generate" name="submit" />
		</form>
		<br/>

		<div id="myElement">Paste the url and click the generate button.</div>

		<div><?php if($iframeid){echo '<textarea style="margin:10px;width: 97%;height: 80px;">http://gdriveplayer.herokuapp.com/embed.php?url='.$iframeid.'</textarea>';}?></div>

	</div>

	<script src="https://content.jwplatform.com/libraries/DbXZPMBQ.js"></script>
	<script type="text/javascript">
		jwplayer("myElement").setup({
			playlist: [{
				"sources":<?php echo $file?>
			}],
			allowfullscreen: true,
			autostart: false,	
			width: '100%',
			aspectratio: '16:9',			
		});
		
		player.addButton(
                //This portion is what designates the graphic used for the button
                "//icons.jwplayer.com/icons/white/download.svg",
                //This portion determines the text that appears as a tooltip
                "Download Video",
                //This portion designates the functionality of the button itself
                function() {
                //With the below code, we're grabbing the file that's currently playing
                window.location.href = player.getPlaylistItem()['sources'];
                },
                //And finally, here we set the unique ID of the button itself.
                "download"
                );		   
				   
	</script>
        <br><br>
	<center><h4>By Haznini Armita | Since 2017</h4></center>
	<center><h4>We Do Not Host And Upload Any Video</h4></center>
</body>
</html>


<?php
      exit;
   } else {
      echo "Bad Cookie.";
      exit;
   }
}

if (isset($_GET['p']) && $_GET['p'] == "login") {
   if ($_POST['user'] != $username) {
      echo "Sorry, that username does not match.";
      exit;
   } else if ($_POST['keypass'] != $password) {
      echo "Sorry, that password does not match.";
      exit;
   } else if ($_POST['user'] == $username && $_POST['keypass'] == $password) {
      setcookie('PrivatePageLogin', md5($_POST['keypass'].$nonsense));
      header("Location: $_SERVER[PHP_SELF]");
   } else {
      echo "Sorry, you could not be logged in at this time.";
   }
}
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>?p=login" method="post">
<label><input type="text" name="user" id="user" /> UserName</label><br />
<label><input type="password" name="keypass" id="keypass" /> Password</label><br />
<input type="submit" id="submit" value="Login" />
</form>
