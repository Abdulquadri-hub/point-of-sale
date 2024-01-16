            <!-- Reports -->
            <div class="col-12">
              <div class="card"> 

            <div class="card-body">
              <h5 class="card-title">Daily Sales Report</h5>

              <!-- Line Chart -->
              <canvas id="lineChart" style="max-height: 400px;"></canvas>
              <script>
                // const dailyData = 
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#lineChart'), {
                    type: 'line',
                    data: {
                      labels: ['0', '1', '2', '3', '4', '5', '6', '7','8', '9', '10', '11', '12', '13', '14', '15','16', '17', '18', '19', '20', '21', '22', '23'],
                      datasets: [{
                        label: 'daily Sales Report',
                        data: <?php echo $daily_data; ?>,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Line CHart -->

            </div>

            <!-- monthly report -->
            <div class="card-body">
              <h5 class="card-title">Monthly Sales Report</h5>

              <!-- Line Chart -->
              <canvas id="lineChart1" style="max-height: 400px;"></canvas>
              <script>
                // const dailyData = 
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#lineChart1'), {
                    type: 'line',
                    data: {
                      labels: [],
                      datasets: [{
                        label: 'Monthly Sales Report',
                        data: <?php echo $monthlyData; ?>,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Line CHart -->

            </div>

            <!-- monthly report -->
            <div class="card-body">
              <h5 class="card-title">Yearly Sales Report</h5>

              <!-- Line Chart -->
              <canvas id="yearly" style="max-height: 400px;"></canvas>
              <script>
                // const dailyData = 
                document.addEventListener("DOMContentLoaded", () => {
                  new Chart(document.querySelector('#yearly'), {
                    type: 'line',
                    data: {
                      labels: [],
                      datasets: [{
                        label: 'Yearly Sales Report',
                        data: <?php echo $yearlyData; ?>,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                      }]
                    },
                    options: {
                      scales: {
                        y: {
                          beginAtZero: true
                        }
                      }
                    }
                  });
                });
              </script>
              <!-- End Line CHart -->

            </div>


                </div>
            </div>
            <!-- End Reports -->