<?php
include 'include/header.php';
if(!empty($_GET['table'])){
	$connector = new DbConnector();
	$sql = "SELECT value FROM kanzi.flat_table_config WHERE name = '".$_REQUEST['table']."'";
	$ranksRes = $connector->query($sql);
	$ranksResRow = $connector->fetchAssocArray($ranksRes);
	$rankArray = json_decode($ranksResRow['value']);
	//echo "<pre>";print_r($rankArray->cardinal_array);
	
	
}
if(!empty($_REQUEST['hid-count'])){
$totalItems = $_POST["hid-count"];

for($i = 0; $i < $totalItems; $i++){
	if($_POST['flip-'.$i] == "on"){
		$cardinalArr[] = $_POST['hid-'.$i];
	}
}
$errorMsg = "";
if(count($cardinalArr) < 2)
{
 $errorMsg = "Please select atleast two columns";

}
else
{
$dataMineObj = new DataMiner();
$dataMineObj->drillDown($_GET['table'], $cardinalArr, $_GET['id']);
$message="Report generated sucessfully";
}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Data Mining</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" href="css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="css/bootstrap-responsive.css" type="text/css">
<link rel="stylesheet" href="css/styles.css" type="text/css">


<link rel="stylesheet" type="text/css" href="css/jquery.mobile-1.2.0.css">
<script type='text/javascript' src='js/jquery.min.js'></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery.mobile-1.2.0.js"></script>

<script type='text/javascript'>//<![CDATA[ 
$(window).load(function(){
var fixHelperModified = function(e, tr) {
    var $originals = tr.children();
    var $helper = tr.clone();
    $helper.children().each(function(index) {
        $(this).width($originals.eq(index).width())
    });
    return $helper;
},
    updateIndex = function(e, ui) {
        $('td.index', ui.item.parent()).each(function (i) {
            $(this).children().attr('name','hid-'+i);
        });
		
		$('td.togglebutton', ui.item.parent()).each(function (i) {
            $(this).children('select').attr('name','flip-'+i);
        });
    };

$("#sort tbody").sortable({
    helper: fixHelperModified,
    stop: updateIndex
}).disableSelection();
});//]]>  

</script>
</head>

<body>
<div class="page-wrap">
	<header class="header">	
    	<div class="navbar navbar-fixed-top">
        	<div class="navbar-inner">
        		<div class="container-fluid txtcenter">
                	<a class="brand fnone" href="#"><img src="img/Bonobo_logo.png"/></a>
                </div>
            </div>
        </div>
   	</header>

   	<section class="container-fluid dataform">
    	<div class="row-fluid">
		<div class="txtcenter">
            	<?php if(!empty($message)){
					echo $message;	?>	
			<br /> <br /> <button type="submit" class="btn btn-primary btn-custom" onClick="window.location='index.php';">Go To Dashboard</button>
			<?php	}else{ ?>                    
					<form name="data" class="form-horizontal" method="post" action="" data-ajax="false">
						<p style="color:#ff0000">
						<?php if(!empty($errorMsg)){
							echo $errorMsg;		
						} ?> </p>
							<h4>Please rearrange and activate columns as required</h4>
							<table id="sort" class="grid" align="center" width="25%">
								<tbody>
								<?php
									$i = 0;
									foreach($rankArray->cardinal_array as $key => $val)
									{
									?>
									<tr style="background: none repeat scroll 0 0 #EEEEEE;    border: 1px solid #CCCCCC;    color: #0088CC;   margin: 5px;    padding: 3px;">
										<td class="index"><input type="hidden" name="hid-<?php echo $i; ?>" value="<?php echo $key; ?>"></td>
										<td align="left" style="cursor:move"><?php echo $key; ?></td>
										<td class="togglebutton">
											<select name="flip-<?php echo $i; ?>" data-role="slider">
												<option value="off">Off</option>
												<option value="on" <?php echo $i == 0?'selected="selected"':''; ?>>On</option>
											</select> 
										</td>
									</tr>
								<?php
									$i++;
									}
								?>
								</tbody>
							</table>
							<br>
							<input type="hidden" name="hid-count" value="<?php echo $i; ?>">
							<button type="submit" class="btn btn-primary btn-custom">Submit</button>
						
						</form>
						</div>
					<?php } ?>
        </div>
    </section>
  
</div>
    
    <footer class="footer">
    	<div class="txtcenter">
    		<div>Designed and Powered by <a href="#">Bonobo</a></div>
        	<div>&copy;2013 Bonobo. All rights reserved. </div>
        </div>
    </footer>
<script src="js/bootstrap.js"></script>
<script src="js/placeholder.js"></script>

</body>
</html>
