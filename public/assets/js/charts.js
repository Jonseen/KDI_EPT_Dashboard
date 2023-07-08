var catChart = document.getElementById('catChart');
var geoChart = document.getElementById('geoChart');
var petitionGrounds = document.getElementById('myPetitionChart');
var yearlyChart = document.getElementById('yearlyChart');
// var petitionTrend = document.getElementById('petition-Trend');

var chartYearly, chartGeozones, chartPetitionGrounds, chartElectionTypes;

function loadCharts(){
  // ============petition scores by election type==========
  if(catChart !== null){
    chartElectionTypes = new Chart(catChart, {
      type: 'bar',
      data: {
        labels: (typeof(catsLabel) == 'undefined')? 0 : catsLabel,
        datasets: [{
          label: 'No of Petitions',
          data: (typeof(catsData) == 'undefined')? 0 : catsData,
          backgroundColor: [
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)'
            ],
            borderColor: [
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)',
              'rgb(115, 128, 236, 1)'
            ],
          borderWidth: 1,
          borderRadius: 6,
          
        }]
      },
      options: {
        responsive: true,
      }
    });
  }
  
  if(geoChart !== null){
      chartGeozones = new Chart(geoChart, {
      type: 'bar',
      data: {
        labels: (typeof(geoLabel) == 'undefined')? 0 : geoLabel,
        datasets: [{
          label: 'Number of Petitions',
          data: (typeof(geoData) == 'undefined')? 0 : geoData,
          backgroundColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(255, 159, 64, 1)',
              'rgba(255, 205, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(153, 102, 255, 1)'
            ],
            borderColor: [
              'rgb(255, 99, 132)',
              'rgb(255, 159, 64)',
              'rgb(255, 205, 86)',
              'rgb(75, 192, 192)',
              'rgb(54, 162, 235)',
              'rgb(153, 102, 255)'
            ],
          borderWidth: 1,
          borderRadius: 6,
          
        }]
      },
      options: {
        responsive: true,
      }
    });
  }  

  if(petitionGrounds !== null){
     // ==========PETITION GROUNDS CHART===============
      chartPetitionGrounds = new Chart(petitionGrounds, {
          type: 'bar',
          data: {
            labels: (typeof(groundsLabel) == 'undefined')? 0 : groundsLabel,
            datasets: [{
              label: 'Number of Petitions',
              data: (typeof(groundsData) == 'undefined')? 0 : groundsData,
              backgroundColor: [
                  'rgb(115, 128, 236, 1)',
                  'rgb(115, 128, 236, 1)',
                  'rgb(115, 128, 236, 1)'
                ],
                borderColor: [
                  'rgb(115, 128, 236, 1)',
                  'rgb(115, 128, 236, 1)',
                  'rgb(115, 128, 236, 1)'
                ],
              borderWidth: 1,
              borderRadius: 10
            }]
          },
          options: {
            responsive: true,
            indexAxis: 'y',
          }
        }); 
  }

  if(yearlyChart !== null){
      // ==========petition distribution by years===============
      chartYearly = new Chart(yearlyChart, {
          type: 'line',
          data: {
            labels: (typeof(yearsLabel) == 'undefined')? 0 : yearsLabel,
            datasets: [{
              label: 'Number of Petitions',
              data: (typeof(yearsData) == 'undefined')? 0 : yearsData,
              backgroundColor: [
                  'rgb(115, 128, 236, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 205, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(153, 102, 255, 1)'
                ],
                borderColor: [
                  'rgb(115, 128, 236, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 205, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(153, 102, 255, 1)'
                ],
              borderWidth: 3,
              borderRadius: 10
            }]
          },
          options: {
            responsive: true,
          }
        });
  }
}

function reloadCharts(){
  if(chartYearly){
    chartYearly.destroy();
  }
  if(chartGeozones){
    chartGeozones.destroy();
  }
  if(chartPetitionGrounds){
    chartPetitionGrounds.destroy();
  }
  if(chartElectionTypes){
    chartElectionTypes.destroy();
  }
  loadCharts();
}

window.addEventListener('load', ()=>{
  loadCharts();
});