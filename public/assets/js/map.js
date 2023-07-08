let loadMap = async function(){

    const topology = await fetch(
        'https://code.highcharts.com/mapdata/countries/ng/ng-all.topo.json'
    ).then(response => response.json());

    // Prepare demo data. The data is joined to map using value of 'hc-key'
    // property by default. See API docs for 'joinBy' for more info on linking
    // data and map.
    const data = stats;

    // Create the chart
    Highcharts.mapChart('container', {
        chart: {
            map: topology
        },

        title: {
            text: 'State Disaggregation of Number of Election Petitions - 2023'
        },

        subtitle: {
            text: 'Data Source: <a href="http://kdi.org.ng">KDI Election Petition Monitoring Team</a>'
        },

        mapNavigation: {
            enabled: true,
            buttonOptions: {
                verticalAlign: 'bottom'
            }
        },

        colorAxis: {
            min: 0
        },

        series: [{
            data: data,
            name: 'Number of Petitions',
            states: {
                hover: {
                    color: '#7380ec'
                }
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}'
            }
        }]
    });

};

loadMap();