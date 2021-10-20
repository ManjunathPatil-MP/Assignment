@extends('layout')
<div class="container">
<form method="post" action="{{route('GetAsteroid')}}">
@csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Start  Date</label>
    <input type="date" class="form-control" name="StartDate">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">End Date</label>
    <input type="date" class="form-control" name="EndDate">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@if(isset($FastestAsteroidValue) && isset($ClosestAsteroidValue) && isset($AverageSize))
  <div class="row">
    <div class="col-md-6">
      <label>Asteroid ID</label> : <h2>{{$FastestAsteroidID[0]}}</h2>
    </div>
    <div class="col-md-6">
      <label>Fastest Asteroid in km/h</label> : <h2>{{$FastestAsteroidValue}}</h2>
    </div>
  </div>
  <div class="row">
  <div class="col-md-6">
    <label>Asteroid ID</label> : <h2>{{$ClosestAsteroidID[0]}}</h2>
  </div>
  <div class="col-md-6">
    <label>Closest Asteroid</label> : <h2>{{$ClosestAsteroidValue}}</h2>
  </div>
  </div>
  <div class="row">
    <label>Average Size of the Asteroids in kilometers</label> : <h2>{{$AverageSize}}</h2>
  </div>
@endif
@if(isset($NumberOfDates) && isset($NumberOfAsteroids))
  <canvas id="myChart" ></canvas>
  @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script>
  
var xValues = <?php if(isset($NumberOfDates)){echo json_encode($NumberOfDates); } ?>;
var yValues = <?php if(isset($NumberOfAsteroids)) {echo json_encode($NumberOfAsteroids); } ?>;

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,255,1.0)",
      borderColor: "rgba(0,0,255,0.1)",
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [{ticks: {min: 5}}],
    }
  }
});
</script>