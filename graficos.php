<?php
$correo = (isset($_POST['correo'])) ? $_POST['correo'] : '';

$conexion = mysqli_connect('database-1.cvwyjl87rro2.us-east-1.rds.amazonaws.com', 'admin', 'administrador');

$db = 'poy_cognitive';

$con = mysqli_select_db($conexion, $db) or die("no podemos conectarnos ");

$consulta = "SELECT * from pulso where email=\"$correo\" ORDER BY id DESC LIMIT 15;";
$resultado = mysqli_query($conexion, $consulta);

$contador = 0;
$arreglo[] = array();
while ($traer = mysqli_fetch_array($resultado)) {

    $datos[$contador] = array($traer['id'], $traer['pulso']);
    $contador++;
}
$arreglo1 = json_encode($datos);

?>

<div class="card-body">
    <div id="line-chart" style="height: 300px;"></div>
</div>





    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/plugins/jquery.flot.resize.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/plugins/jquery.flot.pie.js"></script>
    <!-- AdminLTE for demo purposes -->

    <!-- Page specific script -->
    <script>
        $(function() {



            /*
             * LINE CHART
             * ----------
             */
            //LINE randomly generated data

            var sin=<?php echo $arreglo1; ?>;
            


            console.log(sin);
            var line_data1 = {
                data: sin,
                color: '#3c8dbc'
            }

            $.plot('#line-chart', [line_data1], {
                grid: {
                    hoverable: true,
                    borderColor: '#f3f3f3',
                    borderWidth: 1,
                    tickColor: '#f3f3f3'
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false,
                    color: ['#3c8dbc', '#f56954']
                },
                yaxis: {
                    show: true
                },
                xaxis: {
                    show: true
                }
            })
            //Initialize tooltip on hover
            $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
                position: 'absolute',
                display: 'none',
                opacity: 0.8
            }).appendTo('body')
            $('#line-chart').bind('plothover', function(event, pos, item) {

                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2)

                    $('#line-chart-tooltip').html(item.series.label + ' of ' + x + ' = ' + y)
                        .css({
                            top: item.pageY + 5,
                            left: item.pageX + 5
                        })
                        .fadeIn(200)
                } else {
                    $('#line-chart-tooltip').hide()
                }

            })
            /* END LINE CHART */



        })

        /*
         * Custom Label formatter
         * ----------------------
         */
        function labelFormatter(label, series) {
            return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">' +
                label +
                '<br>' +
                Math.round(series.percent) + '%</div>'
        }
    </script>
</body>

</html>