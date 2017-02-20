<?php

abstract class API
{
    protected $method = '';
    
    protected $endpoint = '';
    
    protected $verb = '';
    
    protected $args = Array();
    
    protected $file = Null;
    
    protected $rdata = Null;
    
    protected $rHeaders = Null;
    
    /**
     * Constructor: __construct
     * Allow for CORS, assemble and pre-process the data
     */
    public function __construct($request)
    {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");
        
        $this->args     = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }
        
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new Exception("Header is not valid");
            }
        }
        $this->rHeaders = $this->_getHeaders();
        switch ($this->method) {
            case 'GET':
                $this->request = $this->_cleanParams($_GET);
                break;
            case 'PUT':
                $this->request = $this->_cleanParams($_GET);
                $this->rdata   = file_get_contents("php://input");
                break;
            
            case 'DELETE':
                break;
            case 'POST':
                //$this->request = $this->_cleanParams($_POST);
                
                $this->request = $this->_cleanParams($_GET);
                $this->rdata   = file_get_contents("php://input");
                
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }
    }
    
    public function _getHeaders()
    {
        $headerData = array();
        foreach (getallheaders() as $name => $value) {
            $headerData[$name] = $value;
        }
        return $headerData;
    }
    
    public function processAPI()
    {
        
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No Endpoint: $this->endpoint", 404);
    }
    
    private function _response($data, $status = 200)
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data);
    }
    
    private function _cleanParams($data)
    {
        $clean_input = Array();
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $clean_input[$k] = $this->_cleanParams($v);
            }
        } else {
            $clean_input = trim(strip_tags($data));
        }
        
        return $clean_input;
    }
    
    private function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error'
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}
?>