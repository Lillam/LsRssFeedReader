$(() => {
    let $body = $('body');
    $body.on('click', '.close-flash-message', function (event) {
        $(this).closest('.flash-message').remove();
    });

    if ($body.find('.feed_stats').length > 0) {
        setup_chart('feed_stats', 'doughnut', {
            datasets: [{
                data: [
                    $body.find('.feed_stats').data('total_posts'),
                    $body.find('.feed_stats').data('total_posts_read')
                ],
                backgroundColor: ['#f1f1f1', '#ffa500'],
                borderWidth: 1
            }],
            labels: [
                'Total Posts',
                'Total Posts Read'
            ]
        });
    }
});

/**
* This method is dedicated for setting up charts on a more dynamic way, without having to continously setting up a
* statement of newchart here and there when we can just simply pass in the element targeter, this is going to replace
* and reduce the amoount of code around the system (the need for duplicated setup methods of the charts)
*
* This construct of code is in need of chart.js which can be found at: https://www.chartjs.org/docs
*
* @param chart_element
* @param chart_type
* @param chart_data
*/
const setup_chart = function (chart_element, chart_type, chart_data) {
    if (window[`${chart_element}_graph`]) {
        window[`${chart_element}_graph`].destroy();
    }

    let chart_options = {
        type: chart_type,
        data: chart_data,
    };

    // if the graph type, is bar, then we are always going to want to start at 0...
    if (chart_type === 'bar') {
        chart_options.options = {
            scales: {
                yAxes: [{ ticks: { beginAtZero: true, min: 0 }}]
            }
        };
    }

    // assign this graph to a variable, which will be checked when the data is refreshed, and if it exists, this will
    // get purged and re-assigned to a variable; with the new data in question.
    window[`${chart_element}_graph`] = new Chart(
        $(`.${chart_element}`),
        chart_options
    );
};
