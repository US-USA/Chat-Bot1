<?php
error_reporting(0);
/*

░█████╗░░█████╗░██████╗░███████╗██╗░░░░░███████╗░█████╗░██╗░░██╗
██╔══██╗██╔══██╗██╔══██╗██╔════╝██║░░░░░██╔════╝██╔══██╗██║░██╔╝
██║░░╚═╝██║░░██║██║░░██║█████╗░░██║░░░░░█████╗░░███████║█████═╝░
██║░░██╗██║░░██║██║░░██║██╔══╝░░██║░░░░░██╔══╝░░██╔══██║██╔═██╗░
╚█████╔╝╚█████╔╝██████╔╝███████╗███████╗███████╗██║░░██║██║░╚██╗
░╚════╝░░╚════╝░╚═════╝░╚══════╝╚══════╝╚══════╝╚═╝░░╚═╝╚═╝░░╚═╝

[+] - https://t.me/CodeLeak
[+] - public
[+] - Owners @RRLRR , @Plugin
*/
ob_start();
define('API_KEY','2003918332:AAHtTybAi1Y-zKpeUD50Um8Fe**********'); // Put Your Token Here.
echo file_get_contents("https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME']);
function bot($method,$datas=[])
{
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
    var_dump(curl_error($ch));
}else{
    return json_decode($res);
}
}
function SendMessage($chat_id,$text,$parse_mode="MARKDOWN",$disable_web_page_preview=true,$reply_to_message_id=null,$keyboard=null)
{
    return bot('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>$parse_mode,
	'disable_web_page_preview'=>$disable_web_page_preview,
	'disable_notification'=>false,
	'reply_to_message_id'=>$reply_to_message_id,
	'reply_markup'=>$keyboard
	]);
}
function SendVideo($chat_id,$video,$caption=null,$parse_mode="MARKDOWN",$reply_to_message_id=null,$reply_markup=null)
{
	return bot('sendVideo',[
	'chat_id'=>$chat_id,
	'video'=>$video,
    'caption'=>$caption,
	'parse_mode'=>$parse_mode,
	'reply_to_message_id'=>$reply_to_message_id,
	'reply_markup'=>$reply_markup
	]);
}
function EditMessageText($chat_id,$message_id,$text,$inline_message_id=null,$parse_mode="MARKDOWN",$disable_web_page_preview=true,$keyboard=null)
{
	return bot('editMessageText',[
    'chat_id'=>$chat_id,
	'message_id'=>$message_id,
	'inline_message_id'=>$inline_message_id,
    'text'=>$text,
    'parse_mode'=>$parse_mode,
	'disable_web_page_preview'=>$disable_web_page_preview,
    'reply_markup'=>$keyboard
	]);
}
function SendChatAction($chat_id,$action)
{
	bot('sendChatAction',[
	'chat_id'=>$chat_id,
	'action'=>$action
	]);
}
function download($video)
    {

    $headers = array();
    $headers[] = 'content-type: application/x-www-form-urlencoded';
    $headers[] = 'origin: https://pinterestvideodownloader.com';
    $headers[] = 'referer: https://pinterestvideodownloader.com/';
    $headers[] = 'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36';

    $auther = "https://pinterestvideodownloader.com/";
    $data   = "url=".$video;

    $method = curl_init();

    curl_setopt($method, CURLOPT_URL, $auther);
    curl_setopt($method, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($method, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($method, CURLOPT_POST, true);
    curl_setopt($method, CURLOPT_POSTFIELDS, $data);
    curl_setopt($method, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($method, CURLOPT_RETURNTRANSFER, true);


    $response = curl_exec($method);
    curl_close($method);

    preg_match_all('/<td><a target="_blank" href="(.*?)" download=""/', $response, $result);
    $result = $result[1][0];

    return $result;
    
}
$update         = json_decode(file_get_contents('php://input'));
$message        = $update->message;
$chat_id        = $update->message->chat->id;
$message_id     = $message->message_id;
$chat_id2       = $update->callback_query->message->chat->id;
$message_id2    = $update->callback_query->message->message_id;
$from_id        = $update->message->from->id;
$name           = $update->message->from->first_name;
$text           = $update->message->text;
$about          = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getMe"));
$Roname         = $about->result->first_name;
$Rouser         = $about->result->username;

if( $text == "/start" ){

    $keyboard = [];
    $keyboard['inline_keyboard'][] =  [['text'=>'🪶','url'=>"https://t.me/".$Rouser]];
    $keyboard = json_encode($keyboard);
    SendMessage($chat_id,"*Hi ".$name."*\n\nI @".$Rouser." can download videos from Pintrest . First, submit a link to the video.\n\nThe bot works directly and in chats. Add the bot to the group then send the link to the video and the bot will send the video to the chat.\n\n/help - help with using\n/source - get bot file\n\nCreator: @CodeLeak","MARKDOWN",true,$message_id,$keyboard);

}elseif( $text == '/help' ){

    $keyboard = [];
    $keyboard['inline_keyboard'][] =  [['text'=>'🪶','url'=>"https://t.me/".$Rouser]];
    $keyboard = json_encode($keyboard);
    SendMessage($chat_id,"🤖 ".$Rouser." can download videos from Pintrest \n\nHow to download the video:\n  1. Go to the Pintrest app\n  2. Choose a video that interests you\n  3. Click on the Share icon or the three dots in the upper right corner.\n  4. Click the 'Copy Link' button.\n  5. Send the link to the bot and in a couple of seconds you will receive a video.","MARKDOWN",true,$message_id,$keyboard);

}elseif( $text == '/source' ){

    $keyboard = [];
    $keyboard['inline_keyboard'][] =  [['text'=>'🪶','url'=>"https://t.me/".$Rouser]];
    $keyboard = json_encode($keyboard);
    SendMessage($chat_id,"You can Get from @CodeLeak thats Free 🆓!","MARKDOWN",true,$message_id,$keyboard);

}elseif( preg_match('/https:\/\/(pin.it)|(pin.com)|(pintrest.com)|(pintrest.it)\//i', $text) ){

    $wait       = 0;
    SendMessage($chat_id,"*🗂 | Uploading $wait% $affect*","MARKDOWN",true,$message_id,null);
    for($i=0; $i<6; $i++){
    $affect     = ['..' , '...' , '...' , '.'][array_rand(['..' , '...' , '...' , '.'],1)];
    EditMessageText($chat_id,$message_id+1,"*🗂 | Uploading $wait% $affect*",null,"MARKDOWN",true,null);
    $wait += 20;
    usleep(500000);
    }
    EditMessageText($chat_id,$message_id+1,"*📦 | Sending ...*",null,"MARKDOWN",true,null);
    SendChatAction($chat_id,"upload_video");
    $keyboard = [];
    $keyboard['inline_keyboard'][] =  [['text'=>'🪶','url'=>"https://t.me/".$Rouser]];
    $keyboard = json_encode($keyboard);
    SendVideo($chat_id,new CURLFILE(download($text)),null,"MARKDOWN",$message_id,$keyboard);
    EditMessageText($chat_id,$message_id+1,"*✅ | download Complete*",null,"MARKDOWN",true,null);

}
