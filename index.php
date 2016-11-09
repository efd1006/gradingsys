<?php 
include_once 'connection.php';
?>

<html>
    <head>
        <title>Grading System</title>
    </head>
    <body>
        <a href="index.php">New</a> | <a href="index.php?view">View</a><br><br>
        <?php
        if(isset($_GET['view'])){
        ?>
            <table border="1">
                <tr>
                    <th>Student Name</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Finals</th>
					<th>Average</th>
                </tr>
                <?php
                $datas = $c->query("SELECT * FROM datas");
                while($row = $datas->fetch_assoc())
                {
					$prelim = $row['prelim'];
					$midterm = $row['midterm'];
					$finals = $row['finals'];
                ?>
                    <tr>
                        <td><?php echo $row['sname'] ?></td>
                        <td><?php echo $row['prelim'] ?></td>
                        <td><?php echo $row['midterm'] ?></td>
                        <td><?php echo $row['finals'] ?></td>
						<td><?php echo (($prelim*.3)+($midterm*.3)+($finals*.4));?></td>
                    </tr>
                <?php } $c->close(); ?>
            </table>
        <?php }else{ ?>
<?php
if(isset($_GET['save'])){
    $sname = $_GET['sname'];
    $prelim = $_GET['prelim'];
    $midterm = $_GET['midterm'];
    $finals = $_GET['finals'];
    
	if($prelim < 0 || $prelim > 100 || $midterm < 0 || $midterm > 100 || $finals < 0 || $finals > 100)
	{
?>
	    <form method="GET">
			Student Name: <input type="text" name="sname" value="<?php echo $sname; ?>"><br>
			Prelim: <input type="number" name="prelim" value="<?php echo $prelim; ?>"><?php if($prelim < 0 || $prelim > 100){ echo '<--- Error'; } ?><br>    
			Midterm: <input type="number" name="midterm" value="<?php echo $midterm; ?>"><?php if($midterm < 0 || $midterm > 100){ echo '<--- Error';}?><br>
			Finals: <input type="number" name="finals" value="<?php echo $finals; ?>"><?php if($finals < 0 || $finals > 100){ echo '<--- Error';}?><br>
			<input type="submit" name="save" value="Save">
		</form>	
<?php		
	}
	else{
		$s = "Select * FROM datas WHERE sname='$sname'";
		$result = $c->query($s);
		
		if($result->num_rows > 0)
		{
			echo 'Name already exist';
		}
		else
		{
			$sql = "INSERT INTO datas (sname,prelim,midterm,finals) VALUES ('$sname','$prelim','$midterm','$finals')";
			
			if($c->query($sql) === TRUE){
				
				header("Location: index.php");
				echo "Successfully saved";
			} else {
			  echo "Error";
			}
		}
		$c->close();   
	}
}else{
?>
            <form method="GET">
                Student Name: <input type="text" name="sname"><br>
                Prelim: <input type="number" name="prelim"><br>    
                Midterm: <input type="number" name="midterm"><br>
                Finals: <input type="number" name="finals"><br>
                <input type="submit" name="save" value="Save">
            </form>
<?php } ?>
        <?php } ?>
    </body>
</html>

