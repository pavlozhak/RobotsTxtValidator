<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Robots.txt Validator</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/app.css" type="text/css" />
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="jumbotron">
                <h1 class="display-4">Robots.txt Validator</h1>
                <p class="lead">Форма проверки файла Robots.txt</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-row">
                <div class="col-10">
                    <input type="text" class="form-control" id="validatorSiteUrlField" placeholder="Адрес сайта">
                </div>
                <div class="col-2">
                    <a class="btn btn-primary float-right" id="validatorRunTestsButton" href="#" role="button">Проверить</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="validatorResultsTableBox">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="table-cell-centered-vertical">№</th>
                    <th scope="col" class="table-cell-centered-vertical">Название проверки</th>
                    <th scope="col" class="table-cell-centered-vertical">Статус</th>
                    <th scope="col"></th>
                    <th scope="col" class="table-cell-centered-vertical">Текущее состояние</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="/Export/export" method="post" class="collapse">
                <input type="hidden" name="RobotsTxtValidateResultsJson" value="" />
                <input type="submit" name="export2exel" class="btn btn-success" value="Сохранить в Exel">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="dist/js/app.js"></script>

</body>
</html>