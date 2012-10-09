<?php

	class Database {
	
		# Oppkobling til databasen
		public function kobling_db() {
			$kobling = mysql_connect ("localhost", "haiti", "d") or die ("Klarte ikke å koble til databasen");
			mysql_select_db ("haiti");
			
			return $kobling;
		}
		
		
		# Mysql escape
		public function escape_string($streng) {
			return mysql_real_escape_string(htmlspecialchars($streng, ENT_COMPAT));
		}
		
	}
	
?>