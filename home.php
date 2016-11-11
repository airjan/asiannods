<?php
include "heads.php";
$headers = array("AOToken: ".$_SESSION['AOToken']);
$headers = array_merge($headers,$config['headers']);
$parameters = array();
$Account = createRequest($_SESSION['Url'],"GetAccountSummary",true,$parameters, $headers);
$Account = json_decode($Account);

if ($Account->Code == "-1") {
	header("location: register.php");
	exit;
}
$User = createRequest($_SESSION['Url'],"GetUserInformation",true,$parameters, $headers);
$User = json_decode($User);
$Bookies = implode(",",$User->Result->ActiveBookies);

$parameters = array('from'=>'01/01/2016', 'to'=>'11/01/2016','bookies'=>$Bookies);
$History =  createRequest($_SESSION['Url'],"GetHistoryStatement",true,$parameters, $headers);
$History = json_decode($History);


$parameters = array("marketTypeId"=>0,'bookies'=>$Bookies);
$Matches = createRequest($_SESSION['Url'],"GetMatches",true,$parameters, $headers);
$Matches = json_decode($Matches);


$d = $Matches->Result->EventSportsTypes[0]->Events;

?>
<html lang="en">

<head>
  <title>Smart Guy</title>
  <meta charset="utf-8
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.3.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  
</head>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>

<body>

<div class="container">
  <h2></h2>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">Account Summary</a></li>
    <li><a data-toggle="tab" href="#menu1">History Statement</a></li>
	<li><a data-toggle="tab" href="#menu2">User Information </a></li>
	<li><a data-toggle="tab" href="#menu3">Matches Today </a></li>
    
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>Account Summary</h3>
      <p>
	<div class="row">
			<div class="col-sm-4">Credit</div>
			<div class="col-sm-8"><?php echo $Account->Result->Credit . " ". $Account->Result->CreditCurrency;?></div>
	</div>
	<div class="row">
			<div class="col-sm-4">Outstanding</div>
			<div class="col-sm-8"><?php echo $Account->Result->Outstanding . " ". $Account->Result->OutstandingCurrency;?></div>
	</div>
	
	<div class="row">
			<div class="col-sm-4">Today's Profit and Loss</div>
			<div class="col-sm-8"><?php echo $Account->Result->TodayPnL . " ". $Account->Result->TodayPnLCurrency;?></div>
	</div>
	
	<div class="row">
			<div class="col-sm-4">Yesterday's Profit and Loss</div>
			<div class="col-sm-8"><?php echo $Account->Result->YesterdayPnL . " ". $Account->Result->YesterdayPnLCurrency;?></div>
	</div>
	  </p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>History Statement for the month of January 2016 to Nov 1 2016</h3>
      <p>
	  <div class="row">
			<div class="col-sm-4">Total Commision</div>
			<div class="col-sm-8"><?php echo $History->Result->TotalCommision ;?></div>
		</div>
		
		<div class="row">
			<div class="col-sm-4">Total Turnover</div>
			<div class="col-sm-8"><?php echo $History->Result->TotalTurnover;?></div>
		</div>
		<div class="row">
			<div class="col-sm-4">Total WinLoss</div>
			<div class="col-sm-8"><?php echo $History->Result->TotalWinLoss;?></div>
		</div>
	  
	  </p>
    </div>
	<div id="menu2" class="tab-pane fade">
      <h3>User Information </h3>
      <p>
	  <div class="row">
				<div class="col-sm-4">User Id</div>
				<div class="col-sm-8"><?php echo $User->Result->UserId;?></div>
		</div>
		
		<div class="row">
			<div class="col-sm-4">Active Bookies</div>
			<div class="col-sm-8">
						<?php
							$Bookies = $User->Result->ActiveBookies;
							echo implode(",", $Bookies);
						?>
			</div>
		</div>
		<div class="row">
				<div class="col-sm-4">Odds Type</div>
				<div class="col-sm-8"><?php echo $User->Result->OddsType;?></div>
		</div>
		
	
	  </p>
    
      </div>
	  <div id="menu3" class="tab-pane fade">
	  <h3> Matches Today</h3>
		<p>
		<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>League Name</th>
                <th>Home</th>
                <th>Away</th>
                <th>Market Type</th>
                <th>Start On</th>
                <th>Bookies</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>League Name</th>
                <th>Home</th>
                <th>Away</th>
                <th>Market Type</th>
                <th>Start On</th>
                <th>Bookies</th>
            </tr>
        </tfoot>
        <tbody>
		<?php 
		foreach($d as $k) { ?>
	


            <tr>
                <td><?php echo $k->LeagueName;?></td>
                <td><?php echo $k->Home;?></td>
                <td><?php echo $k->Away;?></td>
                <td><?php echo $k->MarketType;?></td>
                <td><?php echo $k->StartsOn;?></td>
                <td><?php echo implode(",",$k->Bookies);?></td>
			</tr>
		<?php } ?>
            
			</tbody>
		</table>	
			<div> 
				<form method="post" action="sampletwitter.php" >
				<div class="form-group">
					<label for="exampleInputEmail1">Tweett what you think </label>
					<input type="text" class="form-control" name="tweetvalue"    id="tweetvalue" placeholder="great odda">
					<input type="submit" name="submit" value="submit">
					
				</div>
				</form>
			</div>
		</p>
	  </div>
</div>

</body>
</html>

