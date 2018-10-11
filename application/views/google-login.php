<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<style type="text/css">
	#btn {text-align: center; width: 200px; display: block; margin: 100px auto; border: 2px solid red; padding: 10px; background: red; color: #fff; cursor: pointer; text-decoration: none;
	}
</style>
</head>
<body>
	<?php
	$login_url = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode('https://www.googleapis.com/auth/calendar') . '&redirect_uri=' . urlencode(client_redirect_url) . '&response_type=code&client_id=' . client_id . '&access_type=online';
	?>
	<a id="btn" href="<?= $login_url ?>" >Login with Google</a>
</body>
</html>