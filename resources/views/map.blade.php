@extends('layouts.base')

@section('title', 'Petition Data Map')

@section('content')
<br>
<div id="container">
    
</div>
<script>
    
</script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script>
	let stats = JSON.parse(`{!!$stats!!}`);
	let dataFilter = null;
	let onFilter = (data)=>{
		stats = data;
		loadMap();
	}	

	window.addEventListener('load', ()=>{
    	let requestUrl = "{{route('filter.petitions.map')}}";
    	dataFilter = new DataFilter(requestUrl, onFilter);
	});
</script>
<script src="/assets/js/map.js"></script>
@endsection