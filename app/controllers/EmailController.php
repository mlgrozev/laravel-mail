<?php

class EmailController extends BaseController {

	public function index()
	{
        $hostname = Config::get('imap.hostname');
        $email = Config::get('imap.email');
        $password = Config::get('imap.password');
        if($hostname == "{imat.to.the.server.with.port}" && $email == 'email@email' && $password == "password")
        {
            return "PLEASE PROVIDE CREDITENCIALS";
        }
        $folder = "INBOX";
        /* try to connect */
        $imap = imap_open($hostname, $email, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        
        $numMessages = imap_num_msg($imap);
      
		return View::make('email.index', ['numMessages' => $numMessages, 'imap' => $imap, 'folder' => $folder]);
        /* close the connection */
        imap_close($imap);
	}

    public function show($uid)
    {
        $hostname = Config::get('imap.hostname');
        $email = Config::get('imap.email');
        $password = Config::get('imap.password');
        $partNumber = 1;
        $imap = imap_open($hostname, $email, $password) or die('Cannot connect to Gmail: ' . imap_last_error());
        $structure = imap_fetchstructure($imap, $uid, FT_UID);
        $text = imap_fetchbody($imap, $uid, $partNumber, FT_UID);
        switch ($structure->encoding) {
            case 3:
                $text = imap_base64($text);
            case 4:
                $text = imap_qprint($text);
        }

        return View::make('email.show', ['imap' => $imap, 'text' => $text]);

    }

}
