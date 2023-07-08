@extends('layouts.base')

@section('title', 'Analytics')

@section('content')
<div class="main-analytics">
<div class="analytics">
<div class="insights_3 trendChart">
    <h3 class="cardTitle">Trends of Election petitions per Year</h3>
    <div class="year">
    <canvas id="yearlyChart" height="120"></canvas>
    </div>
</div>
<br>
</div>

<script>
    let yearlyScores = JSON.parse(`{!!$yearlyTrends!!}`);
    let yearsLabel = yearlyScores[0];
    let yearsData = yearlyScores[1];
    
    // add 2023 data
    yearsLabel.push(2023);
    yearsData.push({{$totalPetitions}});
</script>
@endsection