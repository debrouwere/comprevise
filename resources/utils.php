<?php

// Function returns the directories within given directory. Returns false if no directories are present.
function img_scooper($dir_name) {
	
	$types = array('png','jpeg','jpg','gif');
	
	if($dir_handle = @scandir($dir_name)) {
		$flag = 0;
		$files = array();
		$i=0;
		foreach($dir_handle as $file) {
			if ($file == '.' || $file == '..' || $file == '.DS_Store' || $file == 'Thumbs.db')
				continue;
			
			$file_info = explode('.', $file);
			if(in_array($file_info[count($file_info)-1], $types)) {
				$flag = 1;
				$files[$i]['file'] = $file;
				$files[$i]['name'] = $file_info[0];
				$files[$i]['time'] = '(latest ' . rel_time(filemtime($dir_name . '/' . $file)) . ')';
				$i++;
			}
		}
		if($flag == 1)
			return $files;
		else
			return false;
		
	} else
		return false;
	
}