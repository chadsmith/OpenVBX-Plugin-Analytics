<?php
$account = AppletInstance::getValue('account');
$url = AppletInstance::getValue('url');
$title = AppletInstance::getValue('title');
$next = AppletInstance::getDropZoneUrl('next');

if(!empty($_REQUEST['From'])) {
    $from = normalize_phone_to_E164($_REQUEST['From']);
    $to = normalize_phone_to_E164($_REQUEST['To']);
    $url = str_replace(array('%caller%', '%number%'), array($from, $to), $url);
    $title = str_replace(array('%caller%','%number%'), array($from, $to), $title);
    $ch = curl_init('http://www.google-analytics.com/collect');
    $fields = array(
      'v' => 1,
      'tid' => $account,
      'cid' => substr($from, 1),
      't' => 'pageview',
      'dp' => $url,
      'dt' => $title
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
    curl_exec($ch);
    curl_close($ch);
}

$response = new TwimlResponse;

if(!empty($next))
	$response->redirect($next);

$response->respond();