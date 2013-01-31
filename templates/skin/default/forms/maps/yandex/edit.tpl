<p>
	{assign var=field_id value=$oField->getFieldId()}
	<label for="item_map">{$aLang.plugin.topiccck.field_map}:</label>
<div id="map">
<script src="http://api-maps.yandex.ru/2.0/?load=package.full&mode=release&lang=ru-RU" type="text/javascript"></script>
{literal}
<script type="text/javascript">
	var myPlacemark;
	ymaps.ready(function () {
		var myMap = new ymaps.Map("ItemMap", {
{/literal}
			center: [55.76, 37.64],
			zoom: {$oConfig->getValue('plugin.topiccck.map_zoom')},
			type: "yandex#map"
{literal}
		});

		myMap.controls.add("typeSelector").add("mapTools").add("zoomControl").add("searchControl");

		if (ymaps.geolocation) {
			center = [ymaps.geolocation.latitude,ymaps.geolocation.longitude];
		} else {
			center = [{/literal}{$oConfig->getValue('plugin.topiccck.map_center')}{literal}];
		}
		myMap.setCenter(center);


		{/literal}

		{if $_aRequest.fields.$field_id.1 != ''}
			{literal}
			myPlacemark = new ymaps.Placemark([{/literal} {$_aRequest.item_lat} {literal}, {/literal} {$_aRequest.item_lng} {literal}]);
			myMap.geoObjects.add(myPlacemark);
			{/literal}
		{/if}

		 myMap.events.add('click', function (e) {
			var coords = e.get('coordPosition');
			$("#item_lat").attr("value", coords[0].toPrecision(6));
			$("#item_lng").attr("value", coords[1].toPrecision(6));
			if(myPlacemark){
				myMap.geoObjects.remove(myPlacemark);
			}
			myPlacemark = new ymaps.Placemark(coords);
			myMap.geoObjects.add(myPlacemark);
                
		});

		{literal}

	});
</script>
{/literal}


<div id="ItemMap" style="width:{$oConfig->getValue('plugin.topiccck.map_width')};height:{$oConfig->getValue('plugin.topiccck.map_height')};"></div>

<input type="hidden" id="item_lat" name="fields[{$oField->getFieldId()}][0]" value="{$_aRequest.fields.$field_id.0}"/>
<input type="hidden" id="item_lng" name="fields[{$oField->getFieldId()}][1]" value="{$_aRequest.fields.$field_id.1}"/>


</div>
</p>