$(function () {
    // Validator run button click handler
    $('a#validatorRunTestsButton').on('click', function (e) {
        e.preventDefault();
        var siteUrl = $('input#validatorSiteUrlField').val();
        if(siteUrl.length > 0) {
            $.ajax({
                url: '/Validator/run',
                type: 'post',
                data: {
                    siteUrl: siteUrl
                }
            }).done(function (response) {
                $('input[name="RobotsTxtValidateResultsJson"]').val(JSON.stringify(response));
                $('table tbody').html('');
                $.each(response, function (i,e) {
                    if(e !== null) {
                        var cellClass = (e.status === "Ок") ? 'cell-background-success' : 'cell-background-error';
                        var row = '<tr>\n' +
                            '                    <th scope="row" rowspan="2" class="table-cell-centered">' + e.checkNum + '</th>\n' +
                            '                    <td rowspan="2" class="table-cell-centered-vertical">' + e.checkName + '</td>\n' +
                            '                    <td rowspan="2" class="table-cell-centered ' + cellClass + '">' + e.status + '</td>\n' +
                            '                    <td class="table-cell-centered-vertical">Состояние</td>\n' +
                            '                    <td class="table-cell-centered-vertical">' + e.state + '</td>\n' +
                            '                </tr>\n' +
                            '                <tr>\n' +
                            '                    <td class="table-cell-centered-vertical">Рекомендации</td>\n' +
                            '                    <td class="table-cell-centered-vertical">' + e.recommendations + '</td>\n' +
                            '                </tr>';
                        $('table tbody').append(row);
                    }
                });
                $('form').removeClass('collapse');
            }).fail(function () {
                console.log('Request send fail');
            });
        }
    });
});