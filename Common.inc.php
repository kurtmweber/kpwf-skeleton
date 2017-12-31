<?php
	require_once(__DIR__ . "/../Config.inc.php");
	
	function PageTop($title){
		printf("<HTML>\n");
		printf("\t<HEAD>\n");
		printf("\t\t<TITLE>Welcome to %s: %s</TITLE>\n", SITENAME, $title);
		printf("\t</HEAD>\n");
		printf("\t<BODY>\n");
		
		return;
		}
		
	function PageBottom(){
		printf("\t</BODY>\n");
		printf("</HTML>");
		
		return;
		}
		