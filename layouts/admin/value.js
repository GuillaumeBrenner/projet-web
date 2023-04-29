// Initialiser jsChart
var options = {
    series: [{
      data: chartData
    }],
    chart: {
      type: 'bar',
      height: 350
    },
    plotOptions: {
      bar: {
        horizontal: true,
      }
    },
    dataLabels: {
      enabled: false
    },
    xaxis: {
      categories: chartData
    },
    yaxis: {
      title: {
        text: 'Nombre d\'employés'
      }
    }
  };
  
  var chart = new ApexCharts(document.querySelector("#chart"), options);
  chart.render();