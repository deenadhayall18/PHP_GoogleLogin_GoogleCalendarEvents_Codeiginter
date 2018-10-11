<!DOCTYPE html>
<html lang="en">
<head>
	<title>Google Calendar</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
	.trcolor{color:#fff;background-color:#003a59;}
	table,tr,td{border:2px solid #001b28!important;}
	h2{color:#195411;font-weight:bold;}
	h3{color:#4e0b38;font-weight:bold;}
	span{text-align: center}
</style>
<script type="text/javascript">
	function load(){
		
	}
</script>
</head>
<body>
	<div class="container">
		<h2 class="text-center">Google Calendar Events</h2>
		<div class="text-right">
			<button class="btn btn-sm btn-danger" onclick="location.href = '<?php echo 'logout'; ?>';">Logout</button>
		</div>
		<div class="row text-center">
			<?php if(!empty($events_list[0]['organizer']['email'])){ ?>
			<h3>	<?php echo 'Email: '.$events_list[0]['organizer']['email'];  ?></h3>
			<?php } ?>
		</div>
		<div class="row text-center">
			<button class="btn btn-sm btn-success" onclick="load()">Refresh</button>
		</div>
		<br>
		<br>
		<div class="row">
			<div class="table-responsive">  
				<table class="table table-bordered">
					<thead>
						<tr class="trcolor ">
							<th>SLNO</th>
							<th>ID</th>
							<th>Summary</th>
							<th>STATUS</th>
							<th>Created Date</th>
							<th>Updated Date</th>
						</tr>
					</thead>
					<tbody>
						<!-- <?php if(empty($events_list)){ ?>
						<div class="text-center jumbotron">
							NO EVENTS IN YOUR GOOGLE CALENDAR
						</div>
						<?php 	} ?> -->


						<?php

						if(!empty($dbvalues)){
							$i=0; foreach ($dbvalues as $key => $value) {$i++;?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo (!empty($value['event_id'])?$value['event_id']:"Nil"); ?></td>
								<td><?php echo (!empty($value['summary'])?ucwords($value['summary']):"Nil"); ?></td>
								<td><?php echo (!empty($value['status'])?$value['status']:"Nil"); ?></td>
								<td><?php echo (!empty($value['created'])?substr($value['created'],0,10):"Nil");
								?></td>
								<td><?php echo (!empty($value['updated'])?substr($value['updated'],0,10):"Nil");
								?></td>

							</tr>
							<?php }}?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</body>
	</html>

