<body>
<form method="POST" action="t.php">
 <input type="button" value="THIS IS THE VALUE I WANT TO GET" name="MyBUTTON">This button calls a javascript that changes its VALUE

<input type="submit" value="SEND MyBUTTON VALUES">

</form>
</body>

<?
   echo $_POST['MyBUTTON'];
?>