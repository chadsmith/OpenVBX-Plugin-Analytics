<?php
$account = AppletInstance::getValue('account');
$url = AppletInstance::getValue('url');
$title = AppletInstance::getValue('title');
$next = AppletInstance::getDropZoneUrl('next');

if(AppletInstance::getFlowType() == 'voice'){
	$caller = normalize_phone_to_E164($_REQUEST['Caller']);
	$called = normalize_phone_to_E164($_REQUEST['Called']);
	$url = str_replace(array('%caller%', '%number%'), array($caller, $called), $url);
	$title = str_replace(array('%caller%', '%number%'), array($caller, $called), $title);
}
else{
	$from = normalize_phone_to_E164($_REQUEST['From']);
	$to = normalize_phone_to_E164($_REQUEST['To']);
	$url = str_replace(array('%caller%', '%number%'), array($from, $to), $url);
	$title = str_replace(array('%caller%','%number%'), array($from, $to), $title);
}

include_once('Galvanize.php');
@$GA = new Galvanize($account);
@$GA->trackPageView($url, $title);

$response = new Response();
if(!empty($next))
{
    $response->addRedirect($next);
}

$response->Respond();