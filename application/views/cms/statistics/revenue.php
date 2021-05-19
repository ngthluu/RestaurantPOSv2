<!-- Main content -->
<div class="content">
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                <h3 class="card-title">Statistics Overview</h3>
                </div>
                <div class="card-body">
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-warning text-xl">
                    <i class="ion ion-ios-cart-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-up text-warning"></i> 0.8%
                    </span>
                    <span class="text-muted">SALES RATE</span>
                    </p>
                </div>
                <!-- /.d-flex -->
                <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-danger text-xl">
                    <i class="ion ion-ios-people-outline"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                    <span class="font-weight-bold">
                        <i class="ion ion-android-arrow-down text-danger"></i> 1%
                    </span>
                    <span class="text-muted">REGISTRATION RATE</span>
                    </p>
                </div>
                <!-- /.d-flex -->
                </div>
            </div>
            <!-- /.card -->

            <div class="card">
                <div class="card-header border-0">
                <h3 class="card-title">Menu</h3>
                </div>
                <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                    <th>Menu</th>
                    <th>Price</th>
                    <th>Sales</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Some Product
                    </td>
                    <td>$13 USD</td>
                    <td>
                        <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        12%
                        </small>
                        12,000 Sold
                    </td>
                    <td>
                        <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                        </a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Another Product
                    </td>
                    <td>$29 USD</td>
                    <td>
                        <small class="text-warning mr-1">
                        <i class="fas fa-arrow-down"></i>
                        0.5%
                        </small>
                        123,234 Sold
                    </td>
                    <td>
                        <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                        </a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Amazing Product
                    </td>
                    <td>$1,230 USD</td>
                    <td>
                        <small class="text-danger mr-1">
                        <i class="fas fa-arrow-down"></i>
                        3%
                        </small>
                        198 Sold
                    </td>
                    <td>
                        <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                        </a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                        <img src="dist/img/default-150x150.png" alt="Product 1" class="img-circle img-size-32 mr-2">
                        Perfect Item
                        <span class="badge bg-danger">NEW</span>
                    </td>
                    <td>$199 USD</td>
                    <td>
                        <small class="text-success mr-1">
                        <i class="fas fa-arrow-up"></i>
                        63%
                        </small>
                        87 Sold
                    </td>
                    <td>
                        <a href="#" class="text-muted">
                        <i class="fas fa-search"></i>
                        </a>
                    </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Sales</h3>
                </div>
                </div>
                <div class="card-body">
                <div class="d-flex">
                    <p class="d-flex flex-column">
                    <span class="text-bold text-lg">$18,230.00</span>
                    <span>Sales Over Time</span>
                    </p>
                    <p class="ml-auto d-flex flex-column text-right">
                    <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                    </span>
                    <span class="text-muted">Since last month</span>
                    </p>
                </div>
                <!-- /.d-flex -->

                <div class="position-relative mb-4">
                    <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                    <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> This year
                    </span>

                    <span>
                    <i class="fas fa-square text-gray"></i> Last year
                    </span>
                </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-md-6 -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
/* global Chart:false */

document.addEventListener("DOMContentLoaded", function (event) {

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  var $visitorsChart = $('#visitors-chart')
  // eslint-disable-next-line no-unused-vars
  var visitorsChart = new Chart($visitorsChart, {
    data: {
      labels: ['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
      datasets: [{
        type: 'line',
        data: [100, 120, 170, 167, 180, 177, 160],
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },
      {
        type: 'line',
        data: [60, 80, 70, 67, 80, 77, 100],
        backgroundColor: 'tansparent',
        borderColor: '#ced4da',
        pointBorderColor: '#ced4da',
        pointBackgroundColor: '#ced4da',
        fill: false
        // pointHoverBackgroundColor: '#ced4da',
        // pointHoverBorderColor    : '#ced4da'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 200
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
});

});
</script>