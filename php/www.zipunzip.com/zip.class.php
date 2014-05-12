<?php
/**
 * This is a class to handle functions dealing with .zip files
 * example use:
 * <code>
 * $myZipper = new Zipper($pathToWhereZipWillEndUp);
 * $myZipper->makeZipFile($pathToDirectoryToMakeIntoAZipFile);
 * </code>
 * @author Tim Golen <tim@golen.net> http://www.golen.net
 * 		11/01/2010 - (tg) created class
 * @version 1.0.0
 */
class Zipper {
	private $zipFile = null; // a ZipArchive() resource pointer
	private $pathToFile = ''; // the path to the .zip file
	/**
	 * Sets up our ZipArchive resource and sets the path to the .zip file
	 * also attempts to open the ZipArchive for writing
	 * @param unknown_type $filename
	 */
	public function __construct($filename)
	{
		
		$this->pathToFile = $filename;
		$this->zipFile = new ZipArchive();
		$res = $this->zipFile->open($filename, ZipArchive::CREATE);
		if ($res !== TRUE) {
		    exit("cannot open <$filename>\n");
		}
	}
	/**
	 * this function starts the process of making a zipfile from an existing directory
	 * uses the recursive function get_files_from_folder() to include all files and
	 * sub directories
	 * @param string $location
	 */
	public function makeZipFile($location)
	{
		$this->get_files_from_folder($location, '');
		$this->zipFile->close();
	}
	/**
	 * a recursive function to loop through a directory including all files and sub
	 * directories and puts them into our .zip file
	 * @param string $directory the directory on your hard drive that you want to scan
	 * @param string $put_into the name of the directory inside your .zip file to add folders to
	 *  you should leave this blank
	 */
	private function get_files_from_folder($directory, $put_into) {
		$handle = opendir($directory);
		if ($handle) {
			while (false !== ($file = readdir($handle))) {
				if (is_file($directory.$file)) {
					$this->addFile($directory.$file, $put_into.$file);
				} elseif ($file != '.' and $file != '..' and is_dir($directory.$file)) {
					$this->addDirectory($put_into.$file.'/');
					$this->get_files_from_folder($directory.$file.'/', $put_into.$file.'/');
				}
			}
		}
		closedir($handle);
	}
	/**
	 * adds a file to our .zip file.
	 * @param string $pathToFile the path on the hard drive where the file sits
	 * @param string $put_into the name of the folder inside the .zip file to put the file into
	 */
	private function addFile($pathToFile, $put_into)
	{
		$this->zipFile->addFromString( $put_into, file_get_contents($pathToFile) );
	}
	/**
	 * adds a folder inside of our .zip file to put files into
	 * @param string $name the name of the folder to add, can be nested folders as well like 
	 *  folder1/folder2/folder3 and all folders will be created
	 */
	private function addDirectory($name)
	{
		$this->zipFile->addEmptyDir($name);
	}
}