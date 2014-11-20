<div class="container">
		<table border="1" cellspacing="5" cellpadding="10" style="width:100%;border:dashed thin">
			<tr><th colspan="2"><h3>My Profile Info</h3>
				</th>
			</tr>
			<Tr>
				<td style="width:300px;text-align:right">Time of meal</td>
				<td><?php echo Auth::user()->time_of_meal; ?></td>
			</Tr>
			<Tr>
				<td style="width:300px;text-align:right">Budget</td>
				<td>$<?php echo Auth::user()->budget; ?></td>
			</Tr>
			<Tr>
				<td style="width:300px;text-align:right">Location</td>
				<td>
					<?php 
						$value = DB::select("select loc_name from locations where loc_id=".Auth::user()->location_id.' limit 1');  
						echo @$value[0]->loc_name;
					?>
				</td>
			</Tr>
			<Tr>
				<td style="width:300px;text-align:right">Guests</td>
				<td><?php echo Auth::user()->no_of_guests; ?></td>
			</Tr>
			<tr>
				<th colspan="2">
							<button class='btn btn-large btn-primary' id="showmepopup"> Add/Update My Info</button>
				</th>
			</tr>
		</table>
		<div id="popup" style='position:fixed;top:0;left:0;bottom:0;right:0;background:rgba(25,25,25,.8);z-index:2100;display:none'>
			<div id="popupInner" style="margin:200px auto;background:#fff;border:solid thin;border-raduis:20px;width:800px;padding:30px;position:relative">
					<div id="closepop" style="position:absolute;right:-7px;top:-7px;width:50px;height:50px;cursor:pointer">
						{{ HTML::image('images/close_button.png') }}
					</div>				    
				    <h2 class="form-signup-heading" style="text-align:center">Please take a moment and tell us about yourself !</h2>
				    <hr>
				{{ Form::open(array('url'=>'users/userinfo', 'class'=>'form-signup','style'=>'width:600px')) }}
				  
				    <ul>
				        @foreach($errors->all() as $error)
				            <li>{{ $error }}</li>
				        @endforeach
				    </ul>
				    {{ Form::text('time_of_meal', null, array('class'=>'input-block-level', 'id'=>'time_of_meal', 'placeholder'=>'When time do you like to eat? (e.g. HH:MM 24Hr-	format)')) }}
				    {{ Form::number('budget', null, array('class'=>'input-block-level', 'id'=>'budget', 'placeholder'=>'How much $ do you like to spent on eating? (e.g. 30)')) }}
				    {{ Form::number('location', null, array('class'=>'input-block-level', 'id'=>'location', 'placeholder'=>'Any specific location? (e.g. 1=East Village, 2=Williamsburg, 3=Midtown etc.)')) }}
				    {{ Form::number('no_of_guests', null, array('class'=>'input-block-level', 'id'=>'no_of_guests', 'placeholder'=>'So how many members are you?')) }}
				    {{ Form::submit('Update My Info', array('class'=>'btn btn-large btn-primary btn-block'))}}
				{{ Form::close() }}
			</div>
		</div>

<!-- My offers section -->
	<div>
		<table border="1" cellspacing="5" cellpadding="10" style="width:100%; margin:50px 0;border:dashed thin">
			<tr>
				<th colspan="3">	
					<h3>My Offers</h3>

				</th>
			</tr>
			<tr>
				<th>
					<ul class="offerContainer">	
						<?php
							if(!empty($rows)){
								foreach ($rows as $row ) {
							
									echo "<li class='singleOffer'>";
									echo "<b><i>".$row->offername."</i></b><hr>";
									echo "<br>";
									echo "Resturant : ".$row->r_name;
									echo "<br>";
									echo "Start Time : ".$row->starting_at;
									echo "<br>";
									echo "End Time: ".$row->ending_at;
									echo "<br>";
									echo "Taken at : ".$row->taken_at;
									echo "<br>";
									echo "Location: ".$row->loc_name;
									echo "<br>";
									echo "Day: ".date('l',strtotime($row->starting_at));
									echo "<br>";
									echo "Price : $".$row->price;
									
									echo "</li>";
										}
							}
							else{
								echo "<h5>No offers click below to take one!</h5>";
							}
						?>

								<li class="clear"></li>		
					</ul>
				</th>
			</tr>
			<tr>
				<tH>
									
<div style="margin:10px 0;text-align:center">
{{ Form::open(array('action' => 'UsersController@getOffers','method'=>'get', 'style'=>'margin:10px 0')) }}

{{ Form::submit('Find An Offer!!', array('class'=>'btn btn-large btn-primary')) }}

{{ Form::close() }}
</div>
				</tH>
			</tr>
		</table>
	</div>
<!-- My offers section ends-->

</div>
<?php
//echo '<pre>';
//print_r($rows);
//echo '</pre>';
?>
	
<style>
.offerContainer{
	padding: 30px;
	//border: solid; thin;
}

	.singleOffer{
		border: solid thin;
		height: 350px;
		width: 30%;
		margin: 10px;
		float: left;
		list-style: none;
		text-align: center;
		font-weight: normal;
		text-transform: capitalize;
	}
	.clear{
		clear: both;
		list-style: none;	
	}
</style>