<?php
use Model\Model as Model;

class ValidatorControllerModel extends Model
{
    private $file;
    private $fileUrl;
    private $fileSize;
    private $fileRows;
    private $fileSizeIsNormal;
    private $fileStatusCode;
    private $directives = array();

    private function getFileFromUrl()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->fileUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $this->file = curl_exec($curl);
        curl_close($curl);
    }

    private function getFileSize()
    {
        $ch = curl_init($this->fileUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_exec($ch);
        $this->fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
        $this->fileStatusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        $maxFileSize = 32*1024;
        $this->fileSizeIsNormal = ($this->fileSize < $maxFileSize) ? true : false;
        $roundFileSize = round($this->fileSize / 1024);

        $this->fileSize = ($roundFileSize > 0) ? $roundFileSize." Кб" : $this->fileSize." Б";

        return true;
    }

    private function explodeFileToRows()
    {
        $this->fileRows = explode(PHP_EOL, $this->file);
    }

    private function findDirective($directive)
    {
        foreach ($this->fileRows as $fileRow)
        {
            if(preg_match("/^{$directive}/i", trim($fileRow)) === 1)
            {
                $this->directives[$directive]++;
            }
        }
    }

    public function runValidate($siteUrl)
    {
        $this->fileUrl = $this->getVarFromPost($siteUrl).'/robots.txt';
        $this->getFileFromUrl();
        $this->getFileSize();
        $this->explodeFileToRows();
        $this->findDirective('Sitemap');
        $this->findDirective('Host');

        $robotsValidateResult = array(
            'fileAvailability' => array(
                'checkNum' => 1,
                'checkName' => "Проверка наличия файла robots.txt",
                'status' => ($this->file !== false && $this->fileStatusCode === 200) ? "Ок" : "Ошибка",
                'state' => ($this->file !== false && $this->fileStatusCode === 200) ? "Файл robots.txt присутствует" : "Файл robots.txt отсутствует",
                'recommendations' => ($this->file !== false && $this->fileStatusCode === 200) ? "Доработки не требуются" : "Программист: Создать файл robots.txt и разместить его на сайте."
            ),
            'hostDirective' => ($this->fileStatusCode !== 200) ? null : array(
                'checkNum' => 6,
                'checkName' => "Проверка указания директивы Host",
                'status' => (empty($this->directives['Host'])) ? "Ошибка" : "Ок",
                'state' => (empty($this->directives['Host'])) ? "В файле robots.txt не указана директива Host" : "Директива Host указана",
                'recommendations' => (empty($this->directives['Host'])) ? "Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил." : "Доработки не требуются"
            ),
            'hostDirectiveNotFound' => (!empty($this->directives['Host'])) ? null : array(
                'checkNum' => 8,
                'checkName' => "Проверка количества директив Host, прописанных в файле",
                'status' => "Ошибка",
                'state' => "Проверка невозможна, т.к. директива Host отсутствует",
                'recommendations' => "Программист: Для того, чтобы поисковые системы знали, какая версия сайта является основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, после всех правил."
            ),
            'hostDirectiveCount' => ((empty($this->directives['Host']) || ($this->fileStatusCode !== 200))) ? null : array(
                'checkNum' => 8,
                'checkName' => "Проверка количества директив Host, прописанных в файле",
                'status' => ($this->directives['Host'] === 1) ? "Ок" : "Ошибка",
                'state' => ($this->directives['Host'] === 1) ? "В файле прописана 1 директива Host": "В файле прописано несколько директив Host",
                'recommendations' => ($this->directives['Host'] === 1) ? "Доработки не требуются" : "Программист: Директива Host должна быть указана в файле толоко 1 раз. Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую основному зеркалу сайта"
            ),
            'fileSize' => ($this->fileStatusCode !== 200) ? null : array(
                'checkNum' => 10,
                'checkName' => "Проверка размера файла robots.txt",
                'status' => ($this->fileSizeIsNormal) ? "Ок" : "Ошибка",
                'state' => ($this->fileSizeIsNormal) ? "Размер файла robots.txt составляет {$this->fileSize}, что находится в пределах допустимой нормы" : "Размера файла robots.txt составляет {$this->fileSize}, что превышает допустимую норму",
                'recommendations' => ($this->fileSizeIsNormal) ? "Доработки не требуются" : "Программист: Максимально допустимый размер файла robots.txt составляем 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб"
            ),
            'sitemapDirective' => ($this->fileStatusCode !== 200) ? null : array(
                'checkNum' => 11,
                'checkName' => "Проверка указания директивы Sitemap",
                'status' => (empty($this->directives['Sitemap'])) ? "Ошибка" : "Ок",
                'state' => (empty($this->directives['Sitemap'])) ? "В файле robots.txt не указана директива Sitemap" : "Директива Sitemap указана",
                'recommendations' => (empty($this->directives['Sitemap'])) ? "Программист: Добавить в файл robots.txt директиву Sitemap" : "Доработки не требуются"
            ),
            'statusCode' => array(
                'checkNum' => 12,
                'checkName' => "Проверка кода ответа сервера для файла robots.txt",
                'status' => ($this->fileStatusCode === 200) ? "Ок" : "Ошибка",
                'state' => ($this->fileStatusCode === 200) ? "Файл robots.txt отдаёт код ответа сервера 200" : "При обращении к файлу robots.txt сервер возвращает код ответа {$this->fileStatusCode}",
                'recommendations' => ($this->fileStatusCode === 200) ? "Доработки не требуются" : "Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает код ответа 200"
            )
        );

        return $robotsValidateResult;
    }
}