<?php
App::import('Core', 'Xml');
class Smiley extends AppModel {
/**
 * undocumented function
 *
 * @param string $file 
 * @return void
 * @access public
 */
	function import($file) {
		$source = file_get_contents($file);
		$xml = new Xml($source);
		$result = $xml->toArray();
		$result = $result['Xmlarchive']['Fileset']['File'];
		if (empty($result)) {
			return false;
		}

		$count = 0;
		foreach ($result as $smiley) {
			$name = $smiley['filename'];
			$content = $smiley['content'];
			$content = preg_replace('/\s/', '', $content);
			$content = base64_decode($content);
			$filePath = SMILEY_PATH . $name;

			if (file_exists($filePath)) {
				continue;
			}

			$this->create(array(
				'code' => ':' . r('.gif', '', $name) . ':',
				'filename' => $name
			));
			$this->save();
			$f = fopen($filePath, 'w+');
			fwrite($f, $content);
			fclose($f);
			$count++;
		}

		return $count;
	}
}
?>