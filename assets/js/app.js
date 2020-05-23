/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import '../bootstrap/dist/css/bootstrap.css'; // TODO below line should import from vendors, but not working, adding bootstrap files here works:(
// import 'bootstrap';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
import dt from 'datatables.net';
import 'datatables.net-dt/css/jquery.datatables.css';
// import 'bootstrap';
// import '../dist/jquery.canvasjs.min.js'

$(document).ready(function () {
    $("#historical_quotes_task_listing option:contains(AMZN)").attr('selected', 'selected');

    var pathStatus = $("#path-status").val();
    var pathQuotes = $("#path-quotes").val();

    if (pathStatus && pathQuotes) {
        // Use a named immediately-invoked function expression.
        (function worker() {
            $.get(pathStatus, function (statusData) {
                // Now that we've completed the request schedule the next one.
                if (statusData.is_retrieved_quotes === true) {
                    $.ajax({
                        url: pathQuotes,
                        context: document.body
                    }).done(function (quotes) {
                        console.log(quotes);

                        quotes.forEach(function (element) {
                            element.dateString = (new Date(element.date * 1000)).toISOString().slice(0,10);
                            element.dateObject = new Date(element.date * 1000);
                        });

                        console.log(quotes);

                        $("#wait").hide();

                        $(".datatable").DataTable({
                            data: quotes,
                            columns: [
                                {title: "Date", data: "dateString"},
                                {title: "Open", data: "open"},
                                {title: "High", data: "high"},
                                {title: "Low", data: "low"},
                                {title: "Close", data: "close"},
                                {title: "Volume", data: "volume"},
                            ]
                        });


                        var dataPointsOpen = quotes.map(function(quote) { return {x: quote.dateObject, y: quote.open}});
                        var dataPointsClose = quotes.map(function(quote) { return {x: quote.dateObject, y: quote.close}});

                        console.log(dataPointsOpen);

                        var chart = new CanvasJS.Chart("chartContainer", {
                            theme: "light1", // "light2", "dark1", "dark2"
                            animationEnabled: false, // change to true
                            title:{
                                text: "Basic Column Chart"
                            },
                            data: [
                                {
                                    type: "line",
                                    dataPoints: dataPointsOpen
                                },
                                {
                                    type: "line",
                                    dataPoints: dataPointsClose
                                }
                            ]
                        });
                        chart.render();
                    });
                } else {
                    setTimeout(worker, 5000);
                }
            });
        })();
    }
});