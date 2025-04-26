@extends('layouts.admin')
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">
@section('content')
    <h1 class="mt-4">Admin Dashboard</h1>
<br>

 <!-- Chart Section with Title "Monthly Appointment Overview" -->
<div class="row mb-4">
    <div class="col-xl-12 col-md-12">
      
        <div style="background: linear-gradient(135deg, #f9f9f9, #cce6f1); border-radius: 16px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); padding: 30px; font-family: 'Source Sans Pro', sans-serif;">
       
            <div style="padding: 10px; font-size: 20px; font-weight: bold; color: #142c35; text-align: center;">
                Monthly Appointment Overview
            </div>
            <div id="calendar-container" style="text-align: center; margin-bottom: 30px;">
                
                <input type="month" id="calendar" class="form-control" style="width: 200px; display: inline-block;">
                <div style="padding: 20px; display: flex; justify-content: center; align-items: center;">
                 
                    <div id="line-chart" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
          
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    var categories = [
        @foreach($categoryQuantities as $category)
            '{{ $category->category }}',
        @endforeach
    ];

    var quantities = [
        @foreach($categoryQuantities as $category)
            {{ $category->total_quantity }},
        @endforeach
    ];

    var options = {
        chart: {
            type: 'line',
            height: 350,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        series: [{
            name: 'Quantity',
            data: quantities
        }],
        xaxis: {
            categories: categories,
            title: {
                text: 'Categories'
            },
            tickAmount: 10, // Reduce ticks to make the axis cleaner
            labels: {
                rotate: -45, // Rotate labels if needed
                style: {
                    fontSize: '10px', // Reduce font size for category names
                    fontWeight: 'normal',
                    colors: '#333' // Darker text color for better readability
                },
                padding: {
                    left: 10, // Add padding to the left of labels
                    right: 10, // Add padding to the right of labels
                    top: 5, // Add padding to the top of labels
                    bottom: 5 // Add padding to the bottom of labels
                }
            }
        },
        yaxis: {
            title: {
                text: 'Quantity'
            }
        },
        stroke: {
            width: 2 // Thin line for the chart
        },
        markers: {
            size: 0 // No markers to create a pure line appearance
        },
        grid: {
            borderColor: '#e1e1e1', // Lighter grid lines for better visual appeal
            strokeDashArray: 5
        },
        dataLabels: {
            enabled: false // Disable data labels
        },
        tooltip: {
            enabled: true,
            theme: 'light',
            x: {
                show: true
            },
            y: {
                formatter: function(val) {
                    return val;
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#quantityChart"), options);
    chart.render();
</script>


   <script>
        var proceduresData = @json($proceduresCount);

var chartData = Object.keys(proceduresData).map(function(procedure) {
    return { name: procedure, y: proceduresData[procedure] };
});

var totalProcedures = chartData.reduce(function(sum, item) {
    return sum + item.y;
}, 0);

var options = {
    chart: {
        type: 'donut',
        height: 360, // Ensures full height
        width: '100%', // Ensures full width
    },
    series: chartData.map(item => item.y),
    labels: chartData.map(function(item) {
        var percentage = ((item.y / totalProcedures) * 100).toFixed(2);
        return `${item.name} - ${percentage}% - (${item.y} session/s)`;
    }),
    plotOptions: {
        pie: {
            donut: {
                size: '60%'
            }
        }
    },
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '12px' // Increases text size for readability
        }
    },
    legend: {
        position: 'bottom', // Moves legend to bottom for better spacing
        fontSize: '11px'
    }
};

var chart = new ApexCharts(document.querySelector("#donut-chart"), options);
chart.render();
    </script>
    
    <script>
        var appointmentsThisMonth = @json($appointmentsThisMonth);
        var appointmentsPreviousMonth = @json($appointmentsPreviousMonth);
        var appointmentsNextMonth = @json($appointmentsNextMonth);
        var acceptedThisMonth = @json($acceptedThisMonth);
        var declinedThisMonth = @json($declinedThisMonth);
        var acceptedPreviousMonth = @json($acceptedPreviousMonth);
        var declinedPreviousMonth = @json($declinedPreviousMonth);
        var acceptedNextMonth = @json($acceptedNextMonth);
        var declinedNextMonth = @json($declinedNextMonth);
    
        var currentMonth = {{ Carbon\Carbon::now()->month }};
        var currentYear = {{ Carbon\Carbon::now()->year }};
    
        var monthNames = ["January", "February", "March", "April", "May", "June", 
                          "July", "August", "September", "October", "November", "December"];
    
        function getTotalCount(data) {
            return Object.values(data).reduce((a, b) => a + b, 0);
        }
    
        var options = {
            chart: {
                type: 'line',
                height: 350,
                zoom: { enabled: true },
                toolbar: { show: false }
            },
            stroke: { curve: 'smooth', width: 3 },
            markers: {
                size: 3, strokeColor: '#fff', strokeWidth: 2,
                hover: { size: 7 }
            },
            fill: { opacity: 0.5 },
            series: [
                { 
                    name: 'Accepted (Total: ' + getTotalCount(acceptedThisMonth) + ')', 
                    data: Object.values(acceptedThisMonth), 
                    color: '#28a745' 
                },
                { 
                    name: 'Declined (Total: ' + getTotalCount(declinedThisMonth) + ')', 
                    data: Object.values(declinedThisMonth), 
                    color: '#dc3545' 
                },
                { 
                    name: 'Appointments (Total: ' + getTotalCount(appointmentsThisMonth) + ')', 
                    data: Object.values(appointmentsThisMonth), 
                    color: '#00B5E2' 
                }
            ],
            xaxis: {
                categories: Array.from({ length: 31 }, (_, i) => i + 1),
                title: { text: 'Day of the Month' },
                labels: { style: { colors: '#6c757d', fontSize: '10.5px' } }
            },
            title: {
                text: `Appointments in ${monthNames[currentMonth - 1]} ${currentYear}`,
                align: 'center',
                style: { fontSize: '17px', fontWeight: 'bold', color: '#343a40' },
                margin: -10
            },
            yaxis: {
                title: { text: 'Appointments Count', style: { fontSize: '11px' } },
                labels: { style: { colors: '#6c757d', fontSize: '10.5px' } }
            },
            tooltip: {
                enabled: true, shared: true, intersect: false, theme: 'dark',
                x: { formatter: function (val) { return `Day ${val}`; } }
            },
            grid: {
                borderColor: '#e0e0e0',
                row: { colors: ['#f4f4f4', 'transparent'], opacity: 0.5 },
                column: { colors: ['#f4f4f4', 'transparent'], opacity: 0.5 }
            },
            responsive: [{ breakpoint: 1000, options: { chart: { height: 300 } } }]
        };
    
        var chart = new ApexCharts(document.querySelector("#line-chart"), options);
        chart.render();
    
        function updateChart(month, year) {
            var dataAppointments = [];
            var dataAccepted = [];
            var dataDeclined = [];
            var title = `Appointments in ${monthNames[month - 1]} ${year}`;
    
            if (month === currentMonth && year === currentYear) {
                dataAppointments = Object.values(appointmentsThisMonth);
                dataAccepted = Object.values(acceptedThisMonth);
                dataDeclined = Object.values(declinedThisMonth);
            } else if (month === currentMonth - 1 && year === currentYear) {
                dataAppointments = Object.values(appointmentsPreviousMonth);
                dataAccepted = Object.values(acceptedPreviousMonth);
                dataDeclined = Object.values(declinedPreviousMonth);
            } else if (month === currentMonth + 1 && year === currentYear) {
                dataAppointments = Object.values(appointmentsNextMonth);
                dataAccepted = Object.values(acceptedNextMonth);
                dataDeclined = Object.values(declinedNextMonth);
            }
    
            // Update the chart with the new data and updated counts
            chart.updateOptions({
                title: { text: title },
                series: [
                    { 
                        name: 'Accepted (Total: ' + getTotalCount(dataAccepted) + ')', 
                        data: dataAccepted, 
                        color: '#28a745' 
                    },
                    { 
                        name: 'Declined (Total: ' + getTotalCount(dataDeclined) + ')', 
                        data: dataDeclined, 
                        color: '#dc3545' 
                    },
                    { 
                        name: 'Appointments (Total: ' + getTotalCount(dataAppointments) + ')', 
                        data: dataAppointments, 
                        color: '#00B5E2' 
                    }
                ]
            });
        }
    
        document.getElementById('calendar').addEventListener('input', function(e) {
            var selectedMonthYear = e.target.value.split('-');
            var selectedMonth = parseInt(selectedMonthYear[1]);
            var selectedYear = parseInt(selectedMonthYear[0]);
    
            updateChart(selectedMonth, selectedYear);
        });
    </script>
    
    
      
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        
 

@endsection

