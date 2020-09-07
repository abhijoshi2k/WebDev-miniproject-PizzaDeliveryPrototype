<?php

require 'core_login.php';
require 'database_connect.php';

if(loggedin() && isset($_GET['req']) && $_GET['req'] == '1')
{
	$query = "SELECT order_id, order_total, status, order_time FROM `orders` WHERE user_id=".$_SESSION['user_id']." ORDER BY order_id DESC";
	$query_run = mysqli_query($connect,$query);

	while($row = mysqli_fetch_assoc($query_run))
	{
		if($row['status']=='0')
		{
			$status = 'Order Received';
		}
		else if($row['status']=='1')
		{
			$status = 'Preparing';
		}
		else if($row['status']=='2')
		{
			$status = 'Awaiting Delivery';
		}
		else if($row['status']=='3')
		{
			$status = 'Out for Delivery';
		}
		else if($row['status']=='4')
		{
			$status = 'Delivered';
		}
		else if($row['status']=='5' || $row['status']=='6')
		{
			$status = 'Cancelled';
		}
		?>
		<li>
			<b>Order ID: </b><?php echo $row['order_id']; ?> | 
			<b>Status: </b><?php echo $status; ?>
			<br><br>
			<b>Bill Amount: </b>₹<?php echo $row['order_total']; ?> | 
			<b>Order Time: </b><?php echo $row['order_time']; ?>
			<br><br>
			
			<form style="display: inline-block;" action="order_details.php" id="<?php echo $row['order_id']; ?>" method="POST">
				<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
				<input type="submit" value="Order Details" form="<?php echo $row['order_id']; ?>">
			</form>

			<?php

			if($status == 'Order Received')
			{
				?>
				<form style="display: inline-block;" action="order_cancel.php" id="<?php echo $row['order_id'].'_c'; ?>" method="POST" onsubmit="return confirm('Are you sure you want to cancel your order?');">
					<input type="hidden" name="order" value="<?php echo $row['order_id']; ?>">
					<input type="submit" value="Cancel Order">
				</form>
				<?php
			}

			?>
			
			<hr>
			<br>
		</li>
		<?php
	}
}

else if(loggedin() && isset($_GET['req']) && $_GET['req'] == '2' && isset($_SESSION['order_id']))
{
	$query = "SELECT status FROM `orders` WHERE order_id=".$_SESSION['order_id'];
	$query_run = mysqli_query($connect,$query);

	while($row = mysqli_fetch_assoc($query_run))
	{
		if($row['status']=='0')
		{
			$status = 'Order Received';
		}
		else if($row['status']=='1')
		{
			$status = 'Preparing';
		}
		else if($row['status']=='2')
		{
			$status = 'Awaiting Delivery';
		}
		else if($row['status']=='3')
		{
			$status = 'Out for Delivery';
		}
		else if($row['status']=='4')
		{
			$status = 'Delivered';
		}
		else if($row['status']=='5' || $row['status']=='6')
		{
			$status = 'Cancelled';
		}

		echo $status;
	}
}

?>