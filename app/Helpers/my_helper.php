<?php

if (!function_exists('indoDate')) {
    function indoDate($timestamp = '', $date_format = 'l, j F Y | H:i', $suffix = '')
    {
        if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace("/S/", "", $date_format);
        $pattern = array(
            '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
            '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
            '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
            '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
            '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
            '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
            '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
            '/November/', '/December/',
        );
        $replace = array(
            'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
            'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'Sepember',
            'Oktober', 'November', 'Desember',
        );
        $date = date($date_format, $timestamp);
        $date = preg_replace($pattern, $replace, $date);
        if ($suffix) {
            $date = "{$date} {$suffix}";
        }
        return $date;
    }
}

if (!function_exists('statusPendaftaran')) {
    function statusPendaftaran($param = null)
    {

        $data = [
            'belum_bayar' => 'Belum Bayar',
            'sudah_bayar' => 'Sudah Bayar',
            'sukses' => 'Sukses',
            'gagal' => 'Gagal',
        ];


        if (!empty($param)) {
            return isset($data[$param]) ? $data[$param] : $data;
        }
        return $data;
    }
}

if (!function_exists('tipePendaftaran')) {
    function tipePendaftaran($param = null)
    {

        $data = [
            'eb' => 'Early Bird',
            'r' => 'Regular',
            'ots' => 'On The Spot/ Onsite',
        ];


        if (!empty($param)) {
            return isset($data[$param]) ? $data[$param] : $data;
        }
        return $data;
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        $hasil = "Rp. " . number_format($angka, 0, ',', ',');
        return $hasil;
    }
}

if (!function_exists('sendMail')) {
    function sendMail($recipient, $subjectFrom, $subject, $message)
    {
        $db = \Config\Database::connect();
        $encrypter = \Config\Services::encrypter();
        $errors = [];
        $settings = $db->table('settings')
            ->where('param', 'email_email')
            ->orWhere('param', 'email_password')
            ->get()->getResultArray();

        $setting_email = [];
        foreach ($settings as $k => $v) {
            $setting_email[$v['param']] = $v['value'];
        }
        if (!isset($setting_email['email_email'])) {
            $errors[] = 'Email belum diset';
        }
        if (!isset($setting_email['email_password'])) {
            $errors[] = 'Password Email belum diset';
        }

        if (empty($errors)) {


            $from = "pogiriau@gmail.com";
            $password = $encrypter->decrypt(hex2bin($setting_email['email_password']));
            $config = config('Email');
            $config->SMTPUser = $setting_email['email_email'];
            $config->SMTPPass = $password;

            $email = \Config\Services::email();
            $email->initialize($config);
            $email->SMTPPass = $password;
            $email->setTo($recipient);
            $email->setFrom($from, $subjectFrom);
            $email->setSubject($subject);
            $email->setMessage($message);

            if (!$email->send()) {
                $errors[] = $email->printDebugger(['headers']);
            }
        }

        if (empty($errors)) {
            $success = true;
            $message = "Berhasil mengirim email";
        } else {
            $success = false;
            $message = "<div class=\"list-error\"><ul><li>" . implode("</li><li>", $errors) . "</li></ul></div>";
        }

        return [
            'success' => $success,
            'message' => $message,
        ];
    }
}

if (!function_exists('alert')) {
    function alert($tipe, $message)
    {

        $alertClass = '';
        $alertIcon = '';
        switch ($tipe) {
            case 'info':
                $alertClass = "alert-info";
                $alertIcon = "info_outline";
                break;
            case 'success':
                $alertClass = "alert-success";
                $alertIcon = "check";
                break;
            case 'warning':
                $alertClass = "alert-warning";
                $alertIcon = "warning";
                break;
            case 'error':
                $alertClass = "alert-danger";
                $alertIcon = "error_outline";
                break;
            default:
                break;
        }

        $html = "";
        $html .= '<div class="alert ' . $alertClass . '">';
        $html .= '<div class="alert-icon">';
        $html .= '<i class="material-icons">' . $alertIcon . '</i>';
        $html .= '</div>';
        $html .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        $html .= '<span aria-hidden="true"><i class="material-icons">clear</i></span>';
        $html .= '</button>';
        $html .= $message;
        $html .= '</div>';

        return $html;
    }
}

if (!function_exists('uploadErrors')) {
    function uploadErrors($code = null)
    {

        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );

        if ($code !== null) {
            if (isset($phpFileUploadErrors[$code])) {
                return $phpFileUploadErrors[$code];
            } else {
                return $phpFileUploadErrors;
            }
        }
    }
}

if (!function_exists('getDaftarTanggalHotel')) {
    function getDaftarTanggalHotel($index = null)
    {
        $data =  [
            '2022-07-21',
            '2022-07-22',
            '2022-07-23',
            '2022-07-24',
            '2022-07-25',
            '2022-07-26',
            '2022-07-27',
        ];

        if ($index == null) {
            return $data;
        }

        return (isset($data[$index])) ? $data[$index] : null;
    }
}

if (!function_exists('dateFormatConverter')) {
    function dateFormatConverter($inputDate, $inputFormat = 'Y-m-d', $outputFormat = 'd-m-Y')
    {
        $myDateTime = DateTime::createFromFormat($inputFormat, $inputDate);
        $newDateString = $myDateTime->format($outputFormat);
        return $newDateString;
    }
}
