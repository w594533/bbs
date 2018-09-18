<?php
namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;

class SlugTranslateHandler {

  protected $api_baidu_translate = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';

  public function translate($text)
  {
    $appid = config('services.translate.api_key');
    $appsecret = config('services.translate.api_secret');

    //没有配置翻译，返回拼音结果
    if (!$appid || !$appsecret) {
      return self::pinyin($text);
    }

    //组装query字段
    $field = [
      'q' => $text,
      'from' => 'auto',
      'to' => 'en',
      'appid' => $appid,
      'salt' => time(),
    ];
    $sign = md5($appid.$field['q'].$field['salt'].$appsecret);
    $field['sign'] = $sign;
    $query = http_build_query($field);

    $client = new Client();
    $response = $client->get($this->api_baidu_translate.$query);
    $result = json_decode($response->getBody(), true);
    if (isset($result['trans_result'][0]['dst'])) {
      return str_slug($result['trans_result'][0]['dst']);
    } else {
      return self::pinyin($text);
    }
  }


  public static function pinyin($text)
  {
    return app(Pinyin::class)->permalink($text);
  }
}
