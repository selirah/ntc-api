<?php

namespace App\Helpers;


class Helper
{
    public static function sendSMS($phone, $message, $sender = 'EBITS GH', $apiKey = 'DnVYnGb276yeMsyooGZata2SR')
    {
        $endPoint = "http://sms.ebitsgh.com/smsapi";
        $send = $endPoint . '?key=' . $apiKey . '&to=' . $phone . '&msg=' . $message . '&sender_id=' . $sender;
        return file_get_contents($send);
    }

    public function sendBulkSMS($college, array $student)
    {
        $apiKey = "DnVYnGb276yeMsyooGZata2SR";
        foreach ($student as $s) {
            $message = "Hello " . $s['surname'] . ' ' . $s['othernames'] . "\nYour login credentials: \nUsername - " . $s['student_id'] . ", \nPassword - " . $s['password'] . " \nURL - " . $college->student_url . "\nDo not share your credentials!";
            $this->_sendSMS($s['phone'], $message, $college->sender_id, $apiKey);
        }
    }

    private function _sendSMS($phone, $message, $senderId, $apiKey) {
        $endPoint = "http://sms.ebitsgh.com/smsapi";
        $message = urlencode($message);
        $send = $endPoint . '?key=' . $apiKey . '&to=' . $phone . '&msg=' . $message . '&sender_id=' . $senderId;
        return file_get_contents($send);
    }

    public static function generateCode($len = 5)
    {
        $code = substr(md5(time()), 10, $len);
        return $code;
    }

    public static function generateRandomPassword()
    {
        try {
            $bytes = random_bytes(3);
            $randomPassword = strtoupper(bin2hex($bytes));
            return $randomPassword;
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public static function sanitizePhone($phone)
    {
        $phone = str_replace(" ", "", $phone);
        $phone = str_replace("-", "", $phone);
        $phone = str_replace("+", "", $phone);
        filter_var($phone, FILTER_SANITIZE_NUMBER_INT);

        if ((substr($phone, 0, 1) == 0) && (strlen($phone) == 10)) {
            return substr_replace($phone, "233", 0, 1);
        } elseif ((substr($phone, 0, 1) != 0) && (strlen($phone) == 9)) {
            return "233" . $phone;
        } elseif ((substr($phone, 0, 3) == "233") && (strlen($phone) == 12)) {
            return $phone;
        } elseif ((substr($phone, 0, 5) == "00233") && (strlen($phone) == 14)) { //if number begin with 233 and length is 12
            return substr_replace($phone, "233", 0, 5);
        } else {
            return $phone;
        }
    }

    public static function generateApiToken($length = 60)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public static function generateGravatar($email, $s = 200, $r = 'pg', $d = 'mm')
    {
        $email = md5(strtolower(trim($email)));
        $gravatarUrl = "http://www.gravatar.com/avatar/" . $email . "?d=" . $d . "&s=" . $s . "&r=" . $r;
        return $gravatarUrl;
    }

    public static function getMonth($m)
    {
        $MONTHS = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        return $MONTHS[$m - 1];
    }
}
