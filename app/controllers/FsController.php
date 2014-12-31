<?php
if (!ini_get('display_errors')) {
    ini_set('display_errors', 1);
}
class FsController extends BaseController {
	public function operation()
	{ 

		if(isset($_GET['operation'])) {
			$fs = new fs(public_path().DIRECTORY_SEPARATOR.'user-files' . DIRECTORY_SEPARATOR . Auth::user()->username . DIRECTORY_SEPARATOR);
			try {
				$rslt = null;

				switch($_GET['operation']) {
					case 'get_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->lst($node, (isset($_GET['id']) && $_GET['id'] === '#'));
						break;
					case 'run':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->run($node);
						break;
					case "get_content":
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->data($node);
						break;
					case "set_content":
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$content = $_POST['content'];
						$rslt = $fs->update($node,$content);
						break;
					case 'create_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->create($node, isset($_GET['text']) ? $_GET['text'] : '', isset($_GET['type']) ? $_GET['type'] : '');
						break;
					case 'rename_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->rename($node, isset($_GET['text']) ? $_GET['text'] : '');
						break;
					case 'delete_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$rslt = $fs->remove($node);
						break;
					case 'move_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
						$rslt = $fs->move($node, $parn);
						break;
					case 'copy_node':
						$node = isset($_GET['id']) && $_GET['id'] !== '#' ? $_GET['id'] : '/';
						$parn = isset($_GET['parent']) && $_GET['parent'] !== '#' ? $_GET['parent'] : '/';
						$rslt = $fs->copy($node, $parn);
						break;
					default:
						throw new Exception('Unsupported operation: ' . $_GET['operation']);
						break;
				}
				header('Content-Type: application/json; charset=utf-8');
				echo json_encode($rslt);
			}
			catch (Exception $e) {
				header($_SERVER["SERVER_PROTOCOL"] . ' 500 Server Error');
				header('Status:  500 Server Error');
				echo $e->getMessage();
			}
			die();
		}
	}
}

// ini_set('open_basedir', dirname(__FILE__) . DIRECTORY_SEPARATOR);

class fs
{
	protected $base = null;

	protected function real($path) {
		$temp = realpath($path);
		if(!$temp) { throw new Exception('Path does not exist: ' . $path); }
		if($this->base && strlen($this->base)) {
			if(strpos($temp, $this->base) !== 0) { throw new Exception('Path is not inside base ('.$this->base.'): ' . $temp); }
		}
		return $temp;
	}
	protected function path($id) {
		$id = str_replace('/', DIRECTORY_SEPARATOR, $id);
		$id = trim($id, DIRECTORY_SEPARATOR);
		$id = $this->real($this->base . DIRECTORY_SEPARATOR . $id);
		return $id;
	}
	protected function id($path) {
		$path = $this->real($path);
		$path = substr($path, strlen($this->base));
		$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);
		$path = trim($path, '/');
		return strlen($path) ? $path : '/';
	}

	public function __construct($base) {
		try {
			$this->base = $this->real($base);
		} catch(Exception $e) {
			if(!is_dir($base)) {
				mkdir($base);
				$this->base = realpath($base);
			}
		}
		if(!$this->base) { throw new Exception('Base directory does not exist'); }
	}
	public function lst($id, $with_root = false) {
		$dir = $this->path($id);
		$lst = @scandir($dir);
		if(!$lst) { throw new Exception('Could not list path: ' . $dir); }
		$res = array();
		foreach($lst as $item) {
			if($item == '.' || $item == '..' || $item === null || 
				$item === '.cproject' || $item === '.javaproject' || $item === '.pythonproject') { continue; }
			$tmp = preg_match('([^ a-zа-я-_0-9.]+)ui', $item);
			if($tmp === false || $tmp === 1) { continue; }
			if(is_dir($dir . DIRECTORY_SEPARATOR . $item)) {
				$type = '';
				$itemDir = $dir . DIRECTORY_SEPARATOR . $item.DIRECTORY_SEPARATOR;
				if(file_exists($itemDir.'.cproject'))
					$type = 'cProject';
				else if(file_exists($itemDir.'.javaproject'))
					$type = 'javaProject';
				else if(file_exists($itemDir.'.pythonproject'))
					$type = 'pythonProject';
				else
					$type = 'folder';
				$res[] = array('text' => $item, 'children' => true,  'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'type' => $type);
			}
			else {
				// TODO: strrpos Makefile -> akefile
				$res[] = array('text' => $item, 'children' => false, 'id' => $this->id($dir . DIRECTORY_SEPARATOR . $item), 'type' => 'file', 'icon' => 'file file-'.substr($item, strrpos($item,'.') + 1));
			}
		}
		if($with_root && $this->id($dir) === '/') {
			$res = array(array('text' => basename($this->base), 'children' => $res, 'id' => '/', 'type'=>'root', 'state' => array('opened' => true, 'disabled' => true)));
		}
		return $res;
	}

	public function update($id,$content) {
		$dir = $this->path($id);
		$result = array();
		if(is_file($dir)) {
			file_put_contents($dir, $content);
			header('Content-Type: application/json; charset=utf-8');
			$result = array('success' => 'File Saved');
		} else
			$result = array('error' => 'Unable to find id:'+$id);
		return $result;
	}

	public function run($id) {
		$dir = dirname($this->path($id));
		$removedLines = (file_exists($dir.DIRECTORY_SEPARATOR.'.pythonproject')) ? 1 : 2;
		$output = array();
		exec('cd '.$dir.DIRECTORY_SEPARATOR." && make run",$output);
		$output = array_slice($output, $removedLines);
		$output = implode("\n",$output);
		// $output = preg_replace('/^.+\n/', '', $output);
		// die(var_dump('cd '.$dir.DIRECTORY_SEPARATOR." && make run"));
		return $output;
		// return ;
	}

	public function data($id) {
		if(strpos($id, ":")) {
			$id = array_map(array($this, 'id'), explode(':', $id));
			return array('type'=>'multiple', 'content'=> 'Multiple selected: ' . implode(' ', $id));
		}
		$dir = $this->path($id);
		
		if(is_dir($dir)) {
			return array('type'=>'folder', 'content'=> $id);
		}
		if(is_file($dir)) {
			$ext = strpos($dir, '.') !== FALSE ? substr($dir, strrpos($dir, '.') + 1) : '';
			$dat = array('type' => $ext, 'content' => '');
			switch($ext) {
				case 'txt':
				case 'text':
				case 'md':
				case 'js':
				case 'json':
				case 'css':
				case 'html':
				case 'htm':
				case 'xml':
				case 'c':
				case 'java':
				case 'cpp':
				case 'h':
				case 'sql':
				case 'log':
				case 'py':
				case 'rb':
				case 'htaccess':
				case 'php':
				case 'Makefile':
					$dat['content'] = file_get_contents($dir);
					break;
				case 'jpg':
				case 'jpeg':
				case 'gif':
				case 'png':
				case 'bmp':
					$dat['content'] = 'data:'.finfo_file(finfo_open(FILEINFO_MIME_TYPE), $dir).';base64,'.base64_encode(file_get_contents($dir));
					break;
				default:
					$dat['content'] = file_get_contents($dir);
					break;
			}
			return $dat;
		}
		throw new Exception('Not a valid selection: ' . $dir);
	}
	public function create($id, $name, $type) {
		$mkdir = ($type !== 'file');
		$dir = $this->path($id);
		if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
			throw new Exception('Invalid name: ' . $name);
		}
		$file = $dir. DIRECTORY_SEPARATOR . $name;
		if($mkdir) {
			mkdir($file);
		} else {
			file_put_contents($file, '');
		}

		$file = $dir. DIRECTORY_SEPARATOR . escapeshellarg($name);

		$userFilePath = public_path() . DIRECTORY_SEPARATOR .'user-files'.DIRECTORY_SEPARATOR;
		$cpCmd = '';
		switch ($type) {
			case 'cProject':
				$templatePath = $userFilePath.'C'.DIRECTORY_SEPARATOR.'.';
				$cpCmd = "cp -r $templatePath ".$file;
				break;
			case 'javaProject':
				$templatePath = $userFilePath.'Java'.DIRECTORY_SEPARATOR.'.';
				$cpCmd = "cp -r ".$templatePath.' '.$file;
				break;
			case 'pythonProject':
				$templatePath = $userFilePath.'Python'.DIRECTORY_SEPARATOR.'.';
				$cpCmd = "cp -r ".$templatePath.' '.$file;
				break;
		}
		$output = '';
		$retrun_var = '';
		if(!empty($cpCmd)) {
			$output = exec($cpCmd,$output, $retrun_var);
		}
		return array('id' => $this->id($dir . DIRECTORY_SEPARATOR . $name));
	}
	public function rename($id, $name) {
		$dir = $this->path($id);
		if($dir === $this->base) {
			throw new Exception('Cannot rename root');
		}
		if(preg_match('([^ a-zа-я-_0-9.]+)ui', $name) || !strlen($name)) {
			throw new Exception('Invalid name: ' . $name);
		}
		$new = explode(DIRECTORY_SEPARATOR, $dir);
		array_pop($new);
		array_push($new, $name);
		$new = implode(DIRECTORY_SEPARATOR, $new);
		if($dir !== $new) {
			if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }
			rename($dir, $new);
		}
		return array('id' => $this->id($new));
	}
	public function remove($id) {
		$dir = $this->path($id);
		if($dir === $this->base) {
			throw new Exception('Cannot remove root');
		}
		if(is_dir($dir)) {
			foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
				$this->remove($this->id($dir . DIRECTORY_SEPARATOR . $f));
			}
			rmdir($dir);
		}
		if(is_file($dir)) {
			unlink($dir);
		}
		return array('status' => 'OK');
	}
	public function move($id, $par) {
		$dir = $this->path($id);
		$par = $this->path($par);
		$new = explode(DIRECTORY_SEPARATOR, $dir);
		$new = array_pop($new);
		$new = $par . DIRECTORY_SEPARATOR . $new;
		rename($dir, $new);
		return array('id' => $this->id($new));
	}
	public function copy($id, $par) {
		$dir = $this->path($id);
		$par = $this->path($par);
		$new = explode(DIRECTORY_SEPARATOR, $dir);
		$new = array_pop($new);
		$new = $par . DIRECTORY_SEPARATOR . $new;
		if(is_file($new) || is_dir($new)) { throw new Exception('Path already exists: ' . $new); }

		if(is_dir($dir)) {
			mkdir($new);
			foreach(array_diff(scandir($dir), array(".", "..")) as $f) {
				$this->copy($this->id($dir . DIRECTORY_SEPARATOR . $f), $this->id($new));
			}
		}
		if(is_file($dir)) {
			copy($dir, $new);
		}
		return array('id' => $this->id($new));
	}


}
