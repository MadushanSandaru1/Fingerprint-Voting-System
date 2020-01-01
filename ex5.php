<?php

	for($i=0;$i<5;$i++)
	{
		$arr[$i]=rand(1,500);
		echo $arr[$i];
		echo "<br>";
	}

	$maxi=max($arr);
	$mini=min($arr);

	echo "<br><br>Maximum number: ".$maxi;
	echo "<br>Minimum number: ".$mini;

	echo "<br> <br>";

	function volume($h,$r)
	{
		$PI=22/7;

		$cone=round((($PI*$r*$r)/3),2);

		echo "Volume is: ".$cone;
	}
	volume(2,3);

	echo "<br><br>";

	echo "<table border='1px' style='border-collapse:collapse;height:100px;width:100px;'>";
		echo "<tr>
				<th> Angle </th>
				<th> Sin </th>
				<th> Cos </th>
				<th> Tan </th>
			</tr>";
		echo "<tr>
				<td>0<td>
				<td>".sin(0)."<td>
				<td>".cos(0)."<td>
				<td>".tan(0)."<td>
			</tr>";
		echo "<tr>
				<td>30<td>
				<td>".round(sin(deg2rad(30)),2)."<td>
				<td>".round(cos(deg2rad(30)),2)."<td>
				<td>".round(tan(deg2rad(30)),2)."<td>
			</tr>";
		echo "<tr>
				<td>45<td>
				<td>".round(sin(deg2rad(45)),2)."<td>
				<td>".round(sin(deg2rad(45)),2)."<td>
				<td>".round(sin(deg2rad(45)),2)."<td>
			</tr>";
		echo "<tr>
				<td>60<td>
				<td>".round(sin(deg2rad(60)),2)."<td>
				<td>".round(sin(deg2rad(60)),2)."<td>
				<td>".round(sin(deg2rad(60)),2)."<td>
			</tr>";
		echo "<tr>
				<td>90<td>
				<td>".round(sin(deg2rad(90)),2)."<td>
				<td>".round(sin(deg2rad(90)),2)."<td>
				<td>".round(sin(deg2rad(90)),2)."<td>
			</tr>";
	echo "</table>";
?>
