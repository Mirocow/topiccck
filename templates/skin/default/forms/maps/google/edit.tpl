<p><label for="item_map">{$aLang.plugin.topiccck.field_map}:</label>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script>
function setDaoCoordinates(lat,lng) {
	$('#item_lat').val(lat);
	$('#item_lng').val(lng);
}
var markersArray = [];
$(function() {
		var myOptions = {
		zoom: {$oConfig->getValue('plugin.topiccck.map_zoom')},
		center: new google.maps.LatLng({$oConfig->getValue('plugin.topiccck.map_center')}),
		panControl: true,
		zoomControl: true,
		scaleControl: true,
		mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("gmap"),myOptions);


		{if $_aRequest.item_lng != ''}
			var myLatlng = new google.maps.LatLng({$_aRequest.item_lat},{$_aRequest.item_lng});
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map
			});
			markersArray.push(marker);
		{/if}
		google.maps.event.addListener(map, 'click', function(event) {
			if (markersArray) {
				for (i in markersArray) {
				markersArray[i].setMap(null);
				}
				markersArray.length = 0;
			}
			var myLatlng = new google.maps.LatLng(event.latLng);
			var marker = new google.maps.Marker({
				position: event.latLng,
				map: map
			});
			markersArray.push(marker);
			setDaoCoordinates(event.latLng.lat(),event.latLng.lng());
		});

	});
</script>

<div id="gmap" style="width:{$oConfig->getValue('plugin.topiccck.map_width')};height:{$oConfig->getValue('plugin.topiccck.map_height')};"></div>

<input type="hidden" id="item_lat" name="item_lat" value="{$_aRequest.item_lat}"  class="w100p" />
<input type="hidden" id="item_lng" name="item_lng" value="{$_aRequest.item_lng}"  class="w100p" />
</p>