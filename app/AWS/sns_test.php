<?php

die();
/**
 * Copyright 2010-2019 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * This file is licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License. A copy of
 * the License is located at
 *
 * http://aws.amazon.com/apache2.0/
 *
 * This file is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied. See the License for the
 * specific language governing permissions and limitations under the License.
 *
 *  ABOUT THIS PHP SAMPLE: This sample is part of the SDK for PHP Developer Guide topic
 *
 *
 */
// snippet-start:[sns.php.publish_text_SMS.complete]
// snippet-start:[sns.php.publish_text_SMS.import]
require 'aws-autoloader.php';

use Aws\Sns\SnsClient; 
use Aws\Exception\AwsException;
// snippet-end:[sns.php.publish_text_SMS.import]

/**
 * Sends a a text message (SMS message) directly to a phone number using Amazon SNS.
 *
 * This code expects that you have AWS credentials set up per:
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html
 */
// snippet-start:[sns.php.publish_text_SMS.main]
$SnSclient = new SnsClient([
    'profile' => 'default',
    'region' => 'us-east-1',
    'version' => '2010-03-31',
	'scheme' => 'http'
]);
$message = 'You are a big fool. I am coming for you';
$phone = '+447393368256';

try {

    $result = $SnSclient->publish([
        'Message' => $message,
        'PhoneNumber' => $phone,
		'DefaultSenderID' => "SHARAN",
		'MessageAttributes'=> array(
			'AWS.SNS.SMS.SenderID' => array(
			  'DataType' => 'String',
			  'StringValue' => 'Aakarsh'   
			)
		)
    ]);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
} 
// snippet-end:[sns.php.publish_text_SMS.main]
// snippet-end:[sns.php.publish_text_SMS.complete]
// snippet-sourcedescription:[PublishTextSMS.php demonstrates how to send a text message.]
// snippet-keyword:[PHP]
// snippet-sourcesyntax:[php]
// snippet-keyword:[AWS SDK for PHP v3]
// snippet-keyword:[Code Sample]
// snippet-keyword:[Amazon Simple Notification Service]
// snippet-service:[sns]
// snippet-sourcetype:[full-example]
// snippet-sourcedate:[2018-09-20]
// snippet-sourceauthor:[jschwarzwalder]