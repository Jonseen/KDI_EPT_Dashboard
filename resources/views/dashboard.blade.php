@extends('layouts.base')

@section('title', 'Data Dashboard')

@section('content')

<div class="wrap-all">
    <div class="new-wrapper">


        <div class="top-wrapper">
            <div class="insights">
                    <div class="NumOfCases" onclick="location=`{{route('petitionLog')}}`">
                        <span class="material-icons-sharp">balance</span>
                        <div class="middle">
                            <div class="left">
                                <h3>Total Number of Petitions</h3>
                                <h1 id="value">{{$totalPetitions}}</h1>
                            </div>
                            <div class="progress">
                            <img src="/assets/images/coatOfArms.png" alt="" />
                            </div>
                        </div>
                        <!-- <small class="text-muted">Last 24 Hours</small> -->
                    </div>
                    <div class="geo_political">
                        <h3 class="cardTitle">Categories of Petitions</h3>
                        <div>
                            <canvas id="catChart"></canvas>
                        </div>
                    </div>
            </div>
        </div>


        <div class="bottom-wrapper">
            <div><h3>State Distribution of Petitions</h3></div>
            <div id="d-container">
                    
            </div>
            
        </div>

    </div>

        <div class="something">
            <div class="insights_2">
                            <div class="geo_political">
                                <h3>Geo-Political Analysis of Petitions</h3>
                                <div>
                                    <canvas id="geoChart"></canvas>
                                </div>
                            </div>
                            <!-- <div class="NumOfCases" onclick="location=`{{route('petitionLog')}}`">
                                    <span class="material-icons-sharp">balance</span>
                                    <div class="middle">
                                        <div class="left">
                                            <h3>Total Number of Petitions Dispensed</h3>
                                            <h1 id="value">{{$totalPetitions}}</h1>
                                        </div>
                                        <div class="progress">
                                        <img src="/assets/images/coatOfArms.png" alt=""/>
                                        </div>
                                    </div>
                            </div> -->
                            <div class="insights_4">
                            <div class="NumOfCasesRecorded" onclick="location=`{{route('judgementLog')}}`">
                            <span class="material-icons-sharp">gavel</span>
                            <div class="middle_4">
                                <div class="left">
                                    <h3>Total Number of Petitions Dispensed</h3>
                                    <h1 id="dispensedPertitions">{{$dispensedPetitions}}</h1>
                            </div>
                            <div class="progress_4">
                                <svg>
                                    <circle cx="38" cy="38" r="36"></circle>
                                </svg>
                                <div class="number_4">
                                    <p id="percentDispensed">{{$percentDispensed}}%</p>
                                </div>
                            </div>
                    </div>
            </div> 
                            </div>
                            <div class="GroundsOfPetition">
                                <h3>Grounds of Petition Filed</h3>
                                <small class="primary">
                                    <b>NQC</b> -Not qualified to contest
                                    <span class="primary"> | </span>
                                    <b>NCC</b> -Non-compliance/corrupt practices
                                    <span class="primary"> | </span> <br /><b>LMV</b> - Not Duly Elected by Majority of Lawful Votes Cast</small>
                                <div>
                                    <canvas id="myPetitionChart" height="130"></canvas>
                                </div>
                            </div>
            </div>
        </div>

   


</div>



























    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"
      integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script>    
    // variables to the used by index.js
    let totalPetitions = {{$totalPetitions}}
    let data = JSON.parse(`{!!$catStats!!}`);
    let catsLabel = data[0];
    let catsData = data[1];
    
    let gData = JSON.parse(`{!!$geozonesStats!!}`);
    let geoLabel = gData[0];
    let geoData = gData[1];

    let gopData = JSON.parse(`{!!$groundsOfPetitionStats!!}`);
    let groundsLabel = gopData[0];
    let groundsData = gopData[1];

    let dataFilter = null;
    let onFilter = (data)=>{
        totalPetitions = data.totalPetitions;
        // console.log(data['catStats']);
        cdata = JSON.parse(data['catStats']);
        catsLabel = cdata[0];
        catsData = cdata[1];
        
        gData = JSON.parse(data['geozonesStats']);
        console.log(gData);
        geoLabel = gData[0];
        geoData = gData[1];

        gopData = JSON.parse(data['groundsOfPetitionStats']);
        groundsLabel = gopData[0];
        groundsData = gopData[1];

        let cont = document.getElementById("value");
        document.querySelector("#dispensedPertitions").innerText = data['dispensedPetitions'];
        document.querySelector("#percentDispensed").innerText = data['percentDispensed'];
        animateValue(cont, 0, totalPetitions, 1000);
        reloadCharts();
    }   

    window.addEventListener('load', ()=>{
        let requestUrl = "{{route('filter.stats')}}";
        dataFilter = new DataFilter(requestUrl, onFilter);
    });
</script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<!-- <script>
	{{--let stats = JSON.parse(`{!!$stats!!}`);--}}
	let dataFilter = null;
	let onFilter = (data)=>{
		// stats = data;
		loadMap();
	}	

	window.addEventListener('load', ()=>{
    	let requestUrl = "{{route('filter.petitions.map')}}";
    	dataFilter = new DataFilter(requestUrl, onFilter);
	});
</script> -->
<script src="/assets/js/d-map.js"></script>
@endsection