<?php
require_once 'koneksi.php';
$sql=mysqli_query($koneksi, "SELECT * FROM users WHERE username='$_POST[username]' AND email='$_POST[email]'");
$jumlah=mysqli_num_rows($sql);
if($jumlah>0)
{
	$password=md5($_POST["password"]);
	$reset=mysqli_query($koneksi, "UPDATE tb_user SET password='$password' WHERE username='$_POST[username]' AND email='$_POST[email]'");
	if($reset)
	{
		?>
		<script type="text/javascript">
			alert("Password berhasil di reset");
			window.location.href="index.php";
		</script>
		<?php 
	}
}else{
	?>
	<script type="text/javascript">
		alert("Username atau email tidak ditemukan");
		window.location.href="index.php";
	</script>
	<?php 
}
?>


