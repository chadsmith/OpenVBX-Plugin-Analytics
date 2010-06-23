<?php
$account = AppletInstance::getValue('account');
$url = AppletInstance::getValue('url');
$title = AppletInstance::getValue('title');
$next = AppletInstance::getDropZoneUrl('next');

if(AppletInstance::getFlowType() == 'voice'){
	$url = str_replace(
		array(
			'%caller%',
			'%number%'
		),
		array(
			$_REQUEST['Caller'],
			$_REQUEST['Called']
		),
		$url
	);
	$title = str_replace(
		array(
			'%caller%',
			'%number%'
		),
		array(
			$_REQUEST['Caller'],
			$_REQUEST['Called']
		),
		$title
	);
}
else{
	$url = str_replace(
		array(
			'%caller%',
			'%number%'
		),
		array(
			$_REQUEST['From'],
			$_REQUEST['To']
		),
		$url
	);
	$title = str_replace(
		array(
			'%caller%',
			'%number%'
		),
		array(
			$_REQUEST['From'],
			$_REQUEST['To']
		),
		$title
	);
}


include_once('Galvanize.php');
@$GA=new Galvanize($account);
@$GA->trackPageView($url,$title);

$response = new Response();
if(!empty($next))
{
    $response->addRedirect($next);
}

$response->Respond();