<?php

class EmailController extends BaseController {

	public function index()
	{
        $hostname = Config::get('imap.hostname');
        $email = Config::get('imap.email');
        $password = Config::get('imap.password');
        $folder = "INBOX";
        /* try to connect */
        $imap = imap_open($hostname, $email, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        
        $numMessages = imap_num_msg($imap);
      
        /* close the connection */
		return View::make('email.index', ['numMessages' => $numMessages, 'imap' => $imap, 'folder' => $folder]);
        imap_close($imap);
	}

    public function show($uid)
    {
//        dd($uid);
        $hostname = Config::get('imap.hostname');
        $email = Config::get('imap.email');
        $password = Config::get('imap.password');
        $folder = "INBOX";
        $partNumber = 1;
        $imap = imap_open($hostname, $email, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $structure = imap_fetchstructure($imap, $uid, FT_UID);
//        $primaryMimetype = array("TEXT", "MULTIPART", "MESSAGE", "APPLICATION", "AUDIO", "IMAGE", "VIDEO", "OTHER");
//        $mimeType = "TEXT/PLAIN";
//        if ($structure->subtype) {
//            $mimeType = $primaryMimetype[(int)$structure->type] . "/" . $structure->subtype;
//        }
//        dd($structure);
        $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
        switch ($structure->encoding) {
            case 3:
                $text = imap_base64($text);
            case 4:
                $text = imap_qprint($text);
        }
        /* try to connect */

        return View::make('email.show', ['imap' => $imap, 'text' => $text]);

    }

}