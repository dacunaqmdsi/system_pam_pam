$(document).ready(function () {

    const getCount = () => {
        $.ajax({
        url: "backend/end-points/count_notification.php",
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            //   console.log(response.PendingCounts);
    
              let PendingCounts = response.PendingCounts;
              $('#PendingCounts').text(PendingCounts);
    
              if (PendingCounts > 0) {
                  $('#PendingCounts').show();
              } else {
                  $('#PendingCounts').hide();
              }
       
              let UnderMaintenanceCounts = response.UnderMaintenanceCounts;
              $('#UnderMaintenanceCounts').text(UnderMaintenanceCounts);
    
              if (UnderMaintenanceCounts > 0) {
                  $('#UnderMaintenanceCounts').show();
              } else {
                  $('#UnderMaintenanceCounts').hide();
              }
       
              
              
          },
          error: function(xhr, status, error) {
              console.error("Error fetching order status counts:", error);
          }
      });
    };
    
    setInterval(() => {
        getCount();
      }, 3000);
    
    
      getCount();
    });