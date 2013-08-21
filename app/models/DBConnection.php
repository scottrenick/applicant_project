<?php
require( 'DBConfig.php' );

/* Singleton to get a persistant connection for 
 * all db requests.
 */
class DBConnection {
	private static $conn;

	static function get() {
		if( !self::$conn ) {
			self::$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if (mysqli_connect_errno(self::$conn)) {
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		}
		return self::$conn;
	}
}
