@extends('layouts.default')
@section('content')
    @for ($i = $numMessages; $i > ($numMessages - 100); $i--)
        <? $header = imap_header($imap, $i);
        
        $fromInfo = $header->from[0];
        $replyInfo = $header->reply_to[0];
    //    dd($header);
        $details = array(
        "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
        ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        "fromName" => (isset($fromInfo->personal))
        ? $fromInfo->personal : "",
        "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
        ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        "replyName" => (isset($replyInfo->personal))
        ? $replyInfo->personal : "",
        "subject" => (isset($header->subject))
        ? $header->subject : "",
        "udate" => (isset($header->udate))
        ? $header->udate : "",
        "date" => (isset($header->date))
        ? $header->date : ""
        );
        $uid = imap_uid($imap, $i);?>
        <ul>
        <li><strong>From: </strong>{{$details["fromAddr"]}} - {{urldecode($details["fromName"])}}</li>
        <li><strong>Subject: </strong>{{$details["subject"]}}</li>
        <li><strong>Date: </strong>{{$details["date"]}}</li>
        <li>{{link_to("email/{$uid}", "Read")}}
    </ul>
    @endfor
@stop
