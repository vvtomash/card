<?php

/**
 * Created by PhpStorm.
 * User: tomash
 * Date: 10.04.16
 * Time: 09:56
 */
class Loader {
	public static function autoLoad($class) {
		$includeFiles = Kohana::$config->load('loader')->as_array();
		if (isset($includeFiles[$class])) {
			require $includeFiles[$class];
			return true;
		}
		$includedDirs = [APPPATH.'classes/Lib'];
		foreach ($includedDirs as $dir) {
			$fileName = $dir.DIRECTORY_SEPARATOR.$class.'.php';
			if(file_exists($fileName)) {
				require $fileName;
				return true;
			}
		}
		return false;
	}
}