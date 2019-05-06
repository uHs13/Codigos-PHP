<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
<head>
	<title>Simple template</title>
        <link rel="stylesheet" href="<?php echo static::$conf['base_url']; ?>templates/simple/style.css" type="text/css" />

</head>
<body>

	<h2>Notices</h2>
	<p> Hi <b><?php echo htmlspecialchars( $name, ENT_COMPAT, 'UTF-8', FALSE ); ?></b>, this is a beautiful day for a walk! </p>
	<p> <b><?php echo htmlspecialchars( $age, ENT_COMPAT, 'UTF-8', FALSE ); ?></b>, you are growing older </p>
	<p> <b><?php echo htmlspecialchars( $birth, ENT_COMPAT, 'UTF-8', FALSE ); ?></b>, 2 months for birthday </p> 

	<br>
	<br>

	<h2>Random things</h2>
	<ul>
		<?php $counter1=-1;  if( isset($random) && ( is_array($random) || $random instanceof Traversable ) && sizeof($random) ) foreach( $random as $key1 => $value1 ){ $counter1++; ?>
		<li>
			<?php echo htmlspecialchars( $value1, ENT_COMPAT, 'UTF-8', FALSE ); ?>
		</li>
		<?php } ?>
	</ul>

</body>
</html>