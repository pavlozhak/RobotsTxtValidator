<?php
use Model\Model as Model;

class ExportControllerModel extends Model
{
    public function export2exel()
    {

        $results = json_decode($this->getVarFromPost('RobotsTxtValidateResultsJson'), true);
        $output = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 11">
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Hourly Summary Report</x:Name><x:WorksheetOptions><x:DefaultColumnWidth>16</x:DefaultColumnWidth><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
</head>
<body>
<table style="font-size: 14px; width: 100%" border="1">
                <thead>
                <tr>
                    <th width="20px" scope="col" style="vertical-align: middle; width: 30px">№</th>
                    <th width="40px" scope="col" style="vertical-align: middle; width: 200px">Название проверки</th>
                    <th width="50px" scope="col" style="vertical-align: middle; width: 100px">Статус</th>
                    <th width="60px" scope="col" style="width: 160px"></th>
                    <th width="70px" scope="col" style="vertical-align: middle; width: 500px">Текущее состояние</th>
                </tr>
                </thead>
                <tbody>
                ';
        foreach ($results as $result) {
            if($result !== null) {
                $statusColor = ($result['status'] === 'Ок') ? "#8EC481" : "#E86669";
                $output .= '<tr>
                    <td width="20" scope="row" rowspan="2" style="vertical-align: middle; text-align: center;">'.$result['checkNum'].'</td>
                    <td width="60" rowspan="2" style="vertical-align: middle">'.$result['checkName'].'</td>
                    <td width="30" rowspan="2" style="vertical-align: middle; text-align: center; background-color: '.$statusColor.'">'.$result['status'].'</td>
                    <td width="40" style="vertical-align: middle">Состояние</td>
                    <td width="100" style="vertical-align: middle">'.$result['state'].'</td>
                </tr>
                <tr>
                    <td width="40" style="vertical-align: middle">Рекомендации</td>
                    <td width="100" style="vertical-align: middle">'.$result['recommendations'].'</td>
                </tr>';
            }
        }
        $output .= '</tbody></table></body></html>';
        header('Content-Type: text/html; charset=utf-8');
        header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-transfer-encoding: binary');
        header('Content-Type: application/x-unknown');
        header("Content-Disposition: attachment; filename=ValidateResults.xls");
        echo $output;
    }
}