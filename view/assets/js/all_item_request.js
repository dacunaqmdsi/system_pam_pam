$(document).ready(function () {
    // Fetch data from the PHP endpoint
    $.ajax({
     url: 'backend/end-points/all_item_request.php',
     method: 'GET',
     success: function(response) {
         // Parse the response into a JavaScript object
         const data = JSON.parse(response);

         // Prepare data for the chart
         const labels = data.map(item => item.name);
         const totalRequests = data.map(item => item.totalRequest);

         // Create the ApexChart
         var options = {
             series: [{
                 name: 'Total Requests',
                 data: totalRequests
             }],
             chart: {
                 type: 'bar',
                 height: 350
             },
             xaxis: {
                 categories: labels,
             },
             yaxis: {
                 title: {
                     text: 'Total Requests'
                 }
             },
             title: {
                 text: 'All Request Item',
                 align: 'center'
             },
             colors: ['#80000f']
         };
         

         var chart = new ApexCharts(document.querySelector("#all_item_chart"), options);
         chart.render();
     },
     error: function(error) {
         console.error('Error fetching data:', error);
     }
 });
});