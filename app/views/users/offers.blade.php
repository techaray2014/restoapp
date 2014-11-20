<?php
		//print_r($offers);
?>
<style>
	.offersResult li{
		min-height: 100px;
		border:solid thin #333;
		margin: 10px 0;
		border-radius: 7px;
		padding: 5px;
		text-transform: capitalize;
		box-shadow: 1px 2px 3px #333;
	}
	.rimg{
		width: 15%;
		//height: 150px;
		float: left;
		//border:solid thin;
		text-align: center;
	}
	.rdesc{
		float: left;
		//border:solid thin;
		width: 82%;
		margin: 0 10px;
		min-height: 150px;
	}
	.rtakebutton{
		float: right;
		//border:solid thin;
		width: 20%;
	}
	.rtakebutton button{
	}
	.clear{
		clear: both;
	}
	.offername{
		float: left;
		//border: solid thin;
		//text-align: center;
		width: 75%;
	}
	.offerDesc{
		//border: solid thin;
		min-height: 80px;
	}
	.offerDesc p{
		line-height: 15px;
	}
</style>
<div class="container" style="border:none thin #333;margin:5px 0">
<h2>Here Are Offers Matching Your Needs</h2><hr>
<?php
	if(empty($offers)){
		echo '<h1 style="color:#f00;text-align:center">No Offers Found Please Try Later Or Try Changing Search parameters!!</h1>';
	}
	else{
		
			foreach ($offers as $offer) {
				# code...
	//			print_r($offer);
				//echo '<hr>';
		
?>
	<ul class="nav offersResult">
			<li>
				<div class="rimg">
					{{ HTML::image('images/close_button.png') }}

					<h3><?php echo $offer->offername; ?></h3>
					
				</div>
				<div class="rdesc">
					<div class="offername">
						<h3><?php //echo $offer->offername; ?></h3>
					</div>
					<div class="clear"> </div>
					<div class="offerDesc">
						<p><b>Offer Contains: </b><?php echo $offer->offer_content; ?> </p>
						<p><b>Location: </b><?php echo $offer->location; ?></p>
						<p><b>Resturant: </b><?php echo $offer->resturant_name; ?></p>
						<p><b>Price: $</b><?php echo $offer->price; ?></p>
						{{ Form::open( array(
						    'route' => 'users.myoffers',
						    'method' => 'post',
						    'id' => 'form-myoffers'
						) ) }}
					
						<p><b>Available On: </b>
							<select name="day_id">
							<?php 
								//$tmp = 0;
								$days = explode(",", $offer->days);
								foreach ($days as $singledayid) {
									$dayname = DB::select("select name from days where iddays=".$singledayid);
									echo "<option value = $singledayid>".$dayname[0]->name.'</option>';
									/*$tmp++;
									if($tmp<count($days)){
										echo ', ';
									}*/
								}
							?>
							</select>
						</p>
						<p><b>Minimum Guests Required: </b><?php echo $offer->min_guests; ?></p>
						<p><b>Maximum Guests Allowed: </b><?php echo $offer->max_guests; ?></p>
						<p><b>Offer Time: </b><?php echo $offer->time; ?></p>
						<p><b>Offer Available Till</b>: 
							<?php 
								$hour_one = $offer->time;
								$hour_two = $offer->validity_in_hours;
								$h =  strtotime($hour_one);
								$h2 = strtotime($hour_two);
								$minute = date("i", $h2);
								$second = date("s", $h2);
								$hour = date("H", $h2);
								$convert = strtotime("+$minute minutes", $h);
								$convert = strtotime("+$second seconds", $convert);
								$convert = strtotime("+$hour hours", $convert);
								$new_time = date('H:i:s', $convert);
								echo $new_time; 
							?>
						<br>
							<sub><i>(note:You can avial the next offer on this location after this time)</i></sub><br>
						</p>
					</div>
				</div>
					<div class="rtakebutton">
						<!--<button class="btn btn-large btn-primary btn-block" id="<?php echo  $offer->idresturants_offers ?>">Take this offer</button>
						-->
						<input type="hidden"  name="resturant_offer_id"  value="<?php echo $offer->idresturants_offers; ?>" /> 
						<input type="hidden"  name="starting_at"  value="<?php echo $offer->time; ?>" /> 
						<input type="hidden"  name="validity"  value="<?php echo $offer->validity_in_hours; ?>" /> 
						<input type="hidden"  name="ending_at"  value="<?php echo $new_time; ?>" /> 
						{{ Form::submit( 'Take this offer!!', array(
						    'id' => 'btn-add-setting',
						    'class' => 'btn btn-large btn-primary btn-block'
						) ) }}
						 
						{{ Form::close() }}
					</div>

				<div class="clear"></div>
			</li>
			</ul>

		
<?php
			}
	}
	
?>

</div>