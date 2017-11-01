<?php

/*
 * sectionen updaten DVD-R = DVDR etc... function?
 * crap entfernen!
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);
	
	$host = "localhost"; //mySQL-Server
	$user = "root"; // Benutzername
	$pw   = ""; //Passwort
	$db   = "test"; //Datenbankname
	
	$source = "pre";
	$good	= "pre_clean";
	$bad	= "pre_spam";

//regex Spam  & Valide
		$release_regex[][] = array('regex'  => "/^[a-zA-Z0-9]-.$/",      'reason' => "LEGIT name",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^[a-zA-Z0-9.]+$/",      'reason' => "NO GROUP NAME",    'status' => "deny");
		
		/*
		$release_regex[][] = array('regex'  => "/^TestsNow.Novell./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[lL]([.])?[eE3]([.])?[eE3]([.])?[tT7]./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Broken.Bones./",       'reason' => "LEGIT MP3 RELEASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[fF]([-_.])?[bB]([-_.])?[iI1]./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.2007-hXc$/",       'reason' => "LEGIT RELEASE GROUP",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[fF]([-_.])?[eE3]([-_.])?[dD]([-_.])?[sS]./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Prequel./",       'reason' => "LEGIT WORD",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[oO]^6,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Cell.Test./",       'reason' => "FIRST LETTER LOWERCASE",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^-^3,./",       'reason' => "MORE THAN 3 REPEATING SEPERATORS - POSSIBLE BAD ECHO",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[sS]([-_.])?[iI1l]([-_.])?[tT7]([-_.])?[eE3]([-_.])?[bB6]([-_.])?[uU]([-_.])?[sS]([-_.])?[tT7]./",       'reason' => "SCENE NOTICE OR PURE SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[0-9]^4-[0-9]^2-[0-9]^2$/",       'reason' => "SPAM (OR BAD ECHO)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[0-9]^1,$/",       'reason' => "SPAM (OR BAD ECHO)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[a-zA-Z0-9]+$/",       'reason' => "NO GROUP NAME",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[a-zA-Z0-9.]+$/",       'reason' => "NO GROUP NAME",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^TestsNow.IBM.$/",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^[-_.a-zA-Z0-9()]^1,9$/",       'reason' => "SPAM (LESS THAN 10 CHARS)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[-_.].$/",       'reason' => "SPAM (BAD ECHO)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[aA][sS][dD][fF][gG].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[qQ][wW][eE][rR][tT].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[gG][rR][eE][aA][tT][eE][sS][tT].$/",       'reason' => "Possible MP3 CD TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^ACTUALTESTS.$/",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[cC][oO][nN][tT][eE][sS][tT].$/",       'reason' => "Possible MP3 CD TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[tT][eE][sS][tT]([-_.])?[dD][rR][iI][vV][eE].$/",       'reason' => "PC/CONSOLE GAME NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[pP][lL1][zZ][-_.].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Blind_Test.$/",       'reason' => "POSSIBLE MP3 TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.ADISASTA.WinMobile.Torrent.$/",       'reason' => "LEGIT APP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Torrent.Search.Expert.$/",       'reason' => "LEGIT APP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[dD]([-_.])?[oO0]([-_.])?[nN]([-_.])?[tT7]([-_.])?[tT7]([-_.])?[rR]([-_.])?[aA4]([-_.])?[dD]([-_.])?[eE3].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.DVDRip.XviD-LALALALALA$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[xX]^3.-RELOADED$/",       'reason' => "SPAM (RELOADED NEVER RELEASE XXX)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[xX]^3.-DEViANCE$/",       'reason' => "SPAM (DEViANCE NEVER RELEASE XXX)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[aA]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[bB]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[cC]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[dD]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[eE]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[fF]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[gG]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[hH]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[iI]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[jJ]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[kK]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[lL]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[mM]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[nN]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Latest.Fashion./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[pP]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[qQ]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[rR]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[sS]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[tT]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[uU]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[vV]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[wW]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[xX]^7,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[yY]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[zZ]^4,.$/",       'reason' => "SPAM (Repeating letter)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^World.Trade.Center.2006./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Aaaahhhh./",       'reason' => "LEGIT MP3 TITLE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Alte.Stiefel./",       'reason' => "LEGIT NAME (tv epi)",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Ep2.PDTV.XviD./",       'reason' => "LEGIT TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^is_a_whore./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-ZzZz$/",       'reason' => "LEGIT GROUP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.FBI.Files./",       'reason' => "LEGIT RLS NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^[mM]ichael_[fF]akesch./",       'reason' => "LEGIT MP3 SINGER",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Waterproof./",       'reason' => "LEGIT TAG NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Waterproof-Big./",       'reason' => "LEGIT TAG NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.-ReQuiN$/",       'reason' => "LEGIT GROUP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Prequal./",       'reason' => "LEGIT TAG NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Tout_Est./",       'reason' => "LEGIT TAG NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^ACTUALTESTS.LOTUS./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Complete.Story./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.-WLM.2$/",       'reason' => "LEGIT RELEASE GROUP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Et_La.-FR-.$/",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Unit.Testing.in.$/",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Most_Requested.[0-9]^4.$/",       'reason' => "LEGIT MP3 RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.2007-eST$/",       'reason' => "LEGIT MP3 RELEASE GROUP NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Celeste.Star./",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Testimony./",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^07.Estella./",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^schoenste.Stunde./",       'reason' => "LEGIT RELEASE GERMAN NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Lazy.Leech.$/",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^COMPLETE.STV./",       'reason' => "LEGIT RELEASE NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.-SoRRY$/",       'reason' => "LEGIT RELEASE GROUP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Pirate.Stories./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Requiem./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^_^7,./",       'reason' => "MORE THAN 6 REPEATING SEPERATORS - POSSIBLE BAD ECHO",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^These_Silhouettes./",       'reason' => "LEGIT RELEASE NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Niente_Stanca./",       'reason' => "LEGIT NAME TAG",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^..SE[0-9]^2../",       'reason' => "SPAM (BOT FUCKEDUP ECHO)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^..S[0-9]^2E[^0-9]../",       'reason' => "SPAM (BOT FUCKEDUP ECHO)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Someone.Hates.And.The.Number./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Rogue.Traders.S[0-9]^2E[0-9]^2./",       'reason' => "LEGIT RELEASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^ActualTests.Microsoft.$/",       'reason' => "LEGIT RELEASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.CTRL-ALT-DELETE./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.SUPER.DUPER.FUCKING.PROPER./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Requirements./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Actualtests.Cisco./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Actualtests.IBM./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Frequency./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Fate.Stay./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^..K1ck.Me./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^..Judaz./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^MathWorks.SystemTest./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Actualtests./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^TestKing.Cisco./",       'reason' => "LEGIT RELASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.Basstest./",       'reason' => "LEGIT name",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Best_Of_Tests./",       'reason' => "LEGIT rls",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Actualtests./",       'reason' => "LEGIT rls",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^White_Stripes./",       'reason' => "LEGIT ame",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Lexware.QuickBooks./",       'reason' => "LEGIT name",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.(RISE[0-9]+)./",       'reason' => "LEGIT name",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^Rogue_Traders-.(.)-[0-9]^4-./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^[rR][eE][qQ]-./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^TestsNow.BEA./",       'reason' => "LEGIT NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^This.Is.England.2006.DVDRip.XVID.AC3.iNT-./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.How.Ya.Doing./",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.WEB-2007-eST$/",       'reason' => "LEGIT GRP NAME",    'status' => "allow");
		$release_regex[][] = array('regex'  => "speedtest/",       'reason' => "PRESPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Fuxors-Fuck$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Are.You.Also.Fucking.-YOUTUBE$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.1S7.22l.28/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.157.221.28/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.lS7.221.28/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.1S7.221.28/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^pre.test/",       'reason' => "PRESPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Tradewind.Solutions.-TE/",       'reason' => "LEGIT RELEASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.-glfinish$/",       'reason' => "SPAM (torrent rls)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-glfinish$/",       'reason' => "SPAM (torrent rls)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-NiNA$/",       'reason' => "SPAM (torrent rls)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[Ll][eA3][aA4][Kk].[Tt7][eE34][sS][tT7].$/",       'reason' => "SPAM (LEAK TEST)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Discovery.Turbo.Auto.Trader.Episode.[0-9]+.PDTV.XviD-FTP$/",       'reason' => "LEGIT release",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^.[Nn][oO0][oO0][Dd][eE3][Ll1][sS].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[tT7][eE3][hH][-_.][sS][cC][eE3][nN][eE3].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Bb][Aa4][mM][Bb][Aa4][mM].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Pp][lL1][eE3][Aa4][Ss][eE3].[Jj][Oo0][Ii1][Nn].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[iI1][rR][cC]2[kK].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[sS][uU][pP][eE3][rR][-_.][sS][mM][3eE][sS][hH].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^UNZEKUR3.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.dreampre.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[iI1][nN][ZzsS][eE3][cC][uU][rR][eE3].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Dr34mpre.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Ss][Hh][iI1][Bb][Bb].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[pP][oO0][kK][oO0].$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Vv][aA4][nN][qQ][uU][I1i][sS][hH].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^FILLED-.$/",       'reason' => "SPAM (site newdir echo)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^./.$/",       'reason' => "BAD ECHO OR SPAM (contains dir path)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.LiMiTEDDVDRipXviD.$/",       'reason' => "BAD ECHO (NO DOTS)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.CAMXViD.$/",       'reason' => "BAD ECHO (NO DOTS)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.%.$/",       'reason' => "SPAM (invalid char detected)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.#.$/",       'reason' => "SPAM (invalid char detected)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.@.$/",       'reason' => "SPAM (invalid char detected)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.!.$/",       'reason' => "SPAM (invalid char detected)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.TSXViD.$/",       'reason' => "BAD ECHO (NO DOTS)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Sample$/",       'reason' => "BAD ECHO (sample dir)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^KD[0-9]+.-CD-2007-iPC$/",       'reason' => "CUT ECHO",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^KD[0-9]+.-CD-2008-iPC$/",       'reason' => "CUT ECHO",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-TESTPRE$/",       'reason' => "SPAM (TEST PRE)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^[Bb]4[nN].$/",       'reason' => "SPAM (ban user pre)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Gg][aA4][yY][Bb][oO0][Tt7].$/",       'reason' => "SPAM (gay bot pre)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^SERIES-[0-9]+_ARC.$/",       'reason' => "SPAM (spam attack)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Hi.Yall.$/",       'reason' => "SPAM (spam attack)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Ev0lotuiOn.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Stop.the.double.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Im.going.to.die.on.the.way.home.from.town.tonight.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^NUKE.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.addold.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-OrG2k8$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.sitepre.$/",       'reason' => "SPAM (pre spam)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.MrSmooth.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.XVIDcla-1_ARC.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Eskimo.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.-SCREETERS$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Some.Weird.Adds.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Danishbits.org.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.DE_LE_TE-ME.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.PU_RG_E.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.We.are.l[eE3aA4].$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[Dd]([-_.])?[eE]([-_.])?[cC]([-_.])?[o0O]([-_.])?[Dd][Ee3].$/",       'reason' => " SPAM (dec0de)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^TestKing.Microsoft.$/",       'reason' => "LEGIT RELEASE",    'status' => "allow");
		$release_regex[][] = array('regex'  => "/^One.Tree.Hill.S.E..GERMAN.WS.DVDRiP.XviD-DASLiEBEN$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.ceneHaven.org.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.[aA4][Pp][Rr][1Ii][lL1].[Ff][Oo0][Oo0][L1l][Ss].$/",       'reason' => "SPAM (April Fools)",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Fub4r.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.Did.You.Know.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.OKAY.Im.Bored.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.NoOnesTakenThis.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.L0VEMACHiNE$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.ENJOY.LOOL.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.MarkyB.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.ZeraDaMan.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.DDOS.MY.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.DDOS.ME.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.DDOS.HIM.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^.ABCDEF.GHIJK.LMNOP.$/",       'reason' => "SPAM",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^HEY.I.Am.GAY.$/",       'reason' => "SPAM ATTACL",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^We_Luvz_The_Analsex-FLT$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^We_Luvz_.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^I.AM.ANALSEX.KiNG-DEViANCE$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		$release_regex[][] = array('regex'  => "/^Can.I.Plaese.Get.To.Exploit.$/",       'reason' => "SPAM ATTACK",    'status' => "deny");
		*/
		
		
//regex Section
		$sections_regex[] = array('regex' => "", 'section' => "0DAY");
		$sections_regex[] = array('regex' => "", 'section' => "MP3");
		$sections_regex[] = array('regex' => "", 'section' => "FLAC");
		/*
		$sections_regex[][] = array('regex' => "", 'section' => "");
		$sections_regex[][] = array('regex' => "", 'section' => "");
		$sections_regex[][] = array('regex' => "", 'section' => "");
		$sections_regex[][] = array('regex' => "", 'section' => "");
		$sections_regex[][] = array('regex' => "", 'section' => "");
		*/
		
		

//cleaner Release array	
		$invalid_chars = array("","","","%","!","[","]","{","}","'","\\","&","?");
	
	$link = mysqli_connect($host,$user, $pw, $db);
	if (!$link) {
		echo 'Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error();
	}

//zähler
$i=1; //zähler
$g=0; //good
$b=0; //bad
$u=0; //unknown


echo "\e[33mRelease werden geholt\e[0m\n";

$result = mysqli_query($link, "SELECT * FROM `$source` LIMIT 10") or die ("Errormessage: ".mysqli_error($link)."\n");

while($ds = mysqli_fetch_array($result)) {
	$release 		= $ds['release'];
	$files			= $ds['files'];
	$size			= $ds['size'];
	$nuked			= $ds['nuked'];
	$nukereason		= $ds['nuke_reason'];
	$genre			= $ds['genre'];
	$time			= $ds['time'];
	
	//vor cleanen farcodes etc.
	$release = str_replace($invalid_chars, "", $release);
	
	
	for ($r=0; $r < count($release_regex); $r++) {
		if (preg_match($release_regex[$r][0]['regex'], $release)) {
			//debug
			echo $i." \e[34m".$release."\e[0m\e[32m Matcht mit Regex ".$release_regex[$r][0]['reason']." Status: ".$release_regex[$r][0]['status']."\e[0m\n";
				//set section
				for ($s=0; $s < count($sections_regex); $s++) {
					if (preg_match($sections_regex[$r]['regex'], $release)) {
						$section = $sections_regex[$r]['section'];
						//debug
						echo "Section = ".$section."\n";
						/*insert in good
						mysqli_query($link, "INSERT INTO `$good` ( `section`, `release`, `time`, `files`, `size`, `genre`, `nuked`, `nuke_reason` ) 
							VALUES  ( '$section' , '$release' , '$time', '$files', '$size', '$genre', '$nuked', '$nukereason' )");
						//delete from source
						mysqli_query($link, "DELETE FROM `$source` WHERE `release` = '$release'") or die ("Errormessage: ".mysqli_error($link)."\n");
						*/
						$g++;
					}
				}
	} else {
			//debug
			echo $i." \e[34m".$release."\e[0m\e[31m Matcht nicht Regex ".$release_regex[$r][0]['regex']." Reason: ".$release_regex[$r][0]['reason']." Status: ".$release_regex[$r][0]['status']."\e[0m\n";
	
			//posible Spam
			/*insert into bad
			mysqli_query($link, "INSERT INTO `$bad` ( `section`, `release`, `time`, `files`, `size`, `genre`, `nuked`, `nuke_reason` )
					VALUES  ( 'SPAM' , '$release' , '$time', '$files', '$size', '$genre', '$nuked', '$nukereason' )");
			//delete from source
			mysqli_query($link, "DELETE FROM `$source` WHERE `release` = '$release'") or die ("Errormessage: ".mysqli_error($link)."\n");
			*/
			$b++;
			}
	}
	$i++;
}

echo "\n\e[5mCheck done.\e[0m\n";
echo "Statistik\n";
echo "Es wurden ".($i-1)." Release durchlaufen.\n";
echo $g." good.\n";
echo $b." possible Spam.\n";


?>
