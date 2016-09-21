<?php
namespace Pd;

abstract class Controller {

	protected $_response;
	protected $_request;

	/**
	 * 结构: array($method=>$type)
	 *
	 * $type为Pd\Response定义TYPE_开头常量
	 * 默认为\Pd\Response::TYPE_VIEW
	 */
	protected $_responseTypeMap = array();
	/**
	 * 结构: array($method=>$viewfile)
	 *
	 * App::getViewPath.DIRECTORY_SEPARATOR.$viewfile为视图文件
	 * 默认是controller类名（包括命名空间）替换\为DIRECTORY_SEPARATOR所在文件夹下的method名.html的文件
	 */
	protected $_viewMap = array();

	public function _setRequest(Request $request) {
		$this->_request = $request;
	}

	public function _setResponse(Response $response) {
		$this->_response = $response;
	}

	public function _getResponseTypeMap($method) {
		return isset($this->_responseTypeMap[$method]) ? $this->_responseTypeMap[$method] : Response::TYPE_VIEW;
	}

	public function _getView($method) {
		$method = strtolower($method);
		$viewFile = isset($this->_viewMap[$method]) ? $this->_viewMap[$method] : (str_replace("\\", DIRECTORY_SEPARATOR,trim(substr(static::class, strpos(static::class, "\\")), "\\")).DIRECTORY_SEPARATOR.$method.".php");
	    return str_replace("/",DIRECTORY_SEPARATOR,$viewFile);
	}

}