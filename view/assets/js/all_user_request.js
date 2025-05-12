$(document).ready(function () {
    $.ajax({
        url: 'backend/end-points/all_user_request.php',
        method: 'GET',
        success: function(response) {
            const data = JSON.parse(response);

            // Filter and format
            const filteredData = data.filter(item => parseInt(item.totalRequest) > 0);
            const labels = filteredData.map(item => item.fullname);
            const totalRequests = filteredData.map(item => parseInt(item.totalRequest));

            var options = {
                series: totalRequests,
                chart: {
                    type: 'pie',
                    height: 400
                },
                labels: labels,
                title: {
                    text: 'All Requests (Pie Chart)',
                    align: 'center'
                },
                colors: ['#80000f', '#cc000f', '#ff3333', '#ff6666', '#ff9999', '#ffcccc']
            };

            var chart = new ApexCharts(document.querySelector("#all_request_chart"), options);
            chart.render();
        },
        error: function(error) {
            console.error('Error fetching data:', error);
        }
    });
});
