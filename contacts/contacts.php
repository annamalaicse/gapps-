<?php
require_once 'API.class.php';
require_once 'database.php';

class Contacts extends API
{
    protected $user;
    private $dbsource;
    private $entity;
    private $entityType;
    
    
    public function __construct($request, $origin)
    {
        parent::__construct($request);
        $result = array();
        if (!array_key_exists('apiKey', $this->rHeaders)) {
            $result = array(
                'body' => '',
                'code' => 100,
                'status' => false,
                'message' => 'Missing apiKey Parameter'
            );
            echo json_encode($result);
        } elseif (!array_key_exists('Content-Type', $this->rHeaders)) {
            $result = array(
                'body' => '',
                'code' => 100,
                'status' => false,
                'message' => 'Missing Content-Type Parameter'
            );
            echo json_encode($result);
            
        } elseif (!array_key_exists('Postman-Token', $this->rHeaders)) {
            $result = array(
                'body' => '',
                'code' => 100,
                'status' => false,
                'message' => 'Please use Postman'
            );
            echo json_encode($result);
        } else {
            
            if (trim($this->rHeaders['apiKey']) != (md5(date('Y-m-d') . 'rest_api_client'))) {
                $result = array(
                    'body' => '',
                    'code' => 101,
                    'status' => false,
                    'message' => 'ApiKey not valid'
                );
                echo json_encode($result);
            } else {
                $entityMethod = explode(".", $this->request['request']);
                if (empty($entityMethod[0]) || empty($entityMethod[1])) {
                    $result = array(
                        'body' => '',
                        'code' => 404,
                        'status' => false,
                        'message' => 'Invalid Entity Point'
                    );
                    echo json_encode($result);
                } else {
                    $this->entity     = $entityMethod[1];
                    $this->entityType = $entityMethod[0];
                    $this->_callAPI();
                }
            }
            
            
        }
        
        
    }
    
    
    
    /**
     * @author Annamalai
     * @version $1.0.0$
     * @copyright Annamalai 
     * @package default
     * @uses This function will  INSERT/UPDATE/SELECT Records from database as a Middle layer
     * @return json format 
     */
    public function _callAPI()
    {
        $currentTime = date('Y-m-d h:i:s');
        $result      = array();
        $db          = new Database();
        
        /*E2*/
        if ($this->entity == 'list' && $this->entityType == 'person') {
            $result = array(
                'body' => '',
                'status' => true,
                'message' => 'No Records Found!'
            );
            if (!empty($this->request['q'])) {
                $q           = $this->request['q'];
                $selectQuery = "SELECT * FROM users INNER JOIN user_emails ON users.id=user_emails.user_id 
                WHERE users.first_name LIKE '%$q%' OR 
                users.last_name LIKE '%$q%' OR 
                user_emails.email LIKE '%$q%'";
                
            }
            if (!empty($this->request['first_name']) && !empty($this->request['last_name'])) {
                $first_name  = $this->request['first_name'];
                $last_name   = $this->request['last_name'];
                $selectQuery = "SELECT * FROM users INNER JOIN user_emails ON users.id=user_emails.user_id 
                WHERE users.first_name LIKE '%$first_name%' OR 
                users.last_name LIKE '%$last_name%'";
            }
            if (!empty($this->request['first_name']) && empty($this->request['last_name'])) {
                $first_name  = $this->request['first_name'];
                $selectQuery = "SELECT * FROM users INNER JOIN user_emails ON users.id=user_emails.user_id 
                WHERE users.first_name LIKE '%$first_name%'";
            }
            if (empty($this->request['first_name']) && !empty($this->request['last_name'])) {
                $first_name  = $this->request['last_name'];
                $selectQuery = "SELECT * FROM users INNER JOIN user_emails ON users.id=user_emails.user_id 
                WHERE users.last_name LIKE '%$last_name%'";
            }
            
            if (!empty($selectQuery)) {
                $results = $db->findRecords($selectQuery);
            }
            if (!empty($results)) {
                $result = array(
                    'body' => $results,
                    'status' => true,
                    'message' => 'Records Found!'
                );
            }
            
        }
        
        
        /*E1*/
        if ($this->entity == 'create' && $this->entityType == 'person') {
            $objData = json_decode($this->rdata);
            
            
            if ($objData->user) {
                $insertQuery = "INSERT INTO users (first_name,last_name,is_active,created,modified) VALUES ('" . trim($objData->user->first_name) . "','" . trim($objData->user->last_name) . "','" . trim('Y') . "','" . trim($currentTime) . "','" . trim($currentTime) . "')";
                
                $lastInsertId = $db->insertRecords($insertQuery);
            }
            
            if ($objData->emails) {
                $insertQuery = "INSERT INTO user_emails (email,user_id,created,modified) VALUES ";
                foreach ($objData->emails as $key => $value) {
                    $insertQuery .= " ('" . trim($value) . "','" . $lastInsertId . "','" . $currentTime . "','" . $currentTime . "'),";
                }
                $insertQuery = rtrim($insertQuery, ",");
                ;
                $lastInsertEmailId = $db->insertRecords($insertQuery);
            }
            
            if ($objData->phone) {
                
                $insertQuery = "INSERT INTO user_phonenumbers (phone_no,user_id,type,created,modified) VALUES ";
                foreach ($objData->phone as $key => $value) {
                    $type = trim($key);
                    $insertQuery .= " ('" . trim($value) . "','" . $lastInsertId . "','" . $type . "','" . $currentTime . "','" . $currentTime . "'),";
                }
                $insertQuery     = rtrim($insertQuery, ",");
                $lastInsertPhnId = $db->insertRecords($insertQuery);
            }
            
            if ($objData->address) {
                $insertQuery = "INSERT INTO user_address ( address,user_id,city,state, country,created,modified) VALUES ";
                foreach ($objData->address as $key => $value) {
                    $insertQuery .= " ('" . trim($value->address) . "','" . $lastInsertId . "','" . trim($value->city) . "','" . trim($value->state) . "','" . trim($value->country) . "','" . $currentTime . "','" . $currentTime . "'),";
                }
                $insertQuery     = rtrim($insertQuery, ",");
                $lastInsertAdrId = $db->insertRecords($insertQuery);
            }
            $result = array(
                'body' => 'To do',
                'status' => true,
                'message' => 'Person created successfully!'
            );
            if (empty($lastInsertId) || empty($lastInsertEmailId) || empty($lastInsertPhnId) || empty($lastInsertAdrId)) {
                $mesg   = (!empty($lastInsertAdrId)) ? 'Person Record created! but other details missed!' : 'Person not created!';
                $result = array(
                    'body' => 'Error',
                    'code' => 200,
                    'status' => false,
                    'message' => $mesg
                );
            }
            
            
        }
        /*E3*/
        if ($this->entity == 'update' && $this->entityType == 'person') {
            $objData = json_decode($this->rdata);
            print_r($objData);
            if (!empty($objData)) {
                foreach ($objData as $key => $value) {
                    $updateQuery = "UPDATE  users SET first_name='" . trim($value->user->first_name) . "', last_name='" . trim($value->user->last_name) . "', modified='" . trim($currentTime) . "' WHERE id='" . $key . "'";
                    $isUpdated   = $db->updateRecords($updateQuery);
                }
            }
            $result = array(
                'body' => 'To do',
                'status' => true,
                'message' => 'Person updated successfully!'
            );
            if (empty($isUpdated)) {
                $result = array(
                    'body' => 'Error',
                    'code' => 200,
                    'status' => false,
                    'message' => 'Person not updated!'
                );
            }
            
            
        }
        
        /*E4*/
        if ($this->entity == 'create' && $this->entityType == 'group') {
            $objData = json_decode($this->rdata);
            $result  = array(
                'body' => '',
                'status' => false,
                'code' => 202,
                'message' => 'Group not created!'
            );
            if (isset($objData->group)) {
                $insertQuery = "INSERT INTO groups (name,count,modified) VALUES ('" . trim($objData->group->name) . "','" . trim(0) . "','" . trim($currentTime) . "')";
                
                $lastInsertId = $db->insertRecords($insertQuery);
                $result       = array(
                    'body' => 'To do',
                    'status' => true,
                    'message' => 'Group created successfully!'
                );
            }
        }
        
        if ($this->entity == 'join' && $this->entityType == 'group') {
            $objData    = json_decode($this->rdata);
            $prep       = $notExist = "";
            $joinGroups = (array) $objData->groups->join;
            
            $selectQuery  = "SELECT id FROM groups";
            $existingGrps = $db->findRecords($selectQuery, 'id');
            
            
            if (!empty($joinGroups)) {
                foreach ($joinGroups as $key => $value) {
                    $userData[$value->user_id] = $value->user_id;
                    $grpData[$value->group_id] = $value->group_id;
                    
                    if (!empty($existingGrps) && in_array($value->group_id, $existingGrps)) {
                        $prep .= "(" . $value->user_id . "," . $value->group_id . ",'" . trim($currentTime) . "','" . trim($currentTime) . "'),";
                        
                    } else {
                        $notExist .= $value->group_id . ',';
                    }
                    
                }
                if (strlen($prep) > 1) {
                    $insertQuery = "INSERT INTO user_groups ( user_id,group_id,created,modified) VALUES " . $prep;
                    $insertQuery = rtrim($insertQuery, ",");
                    $db->insertRecords($insertQuery);
                }
                
                $body   = (strlen($notExist) > 1) ? $notExist . ' Group id Not Exists' : '';
                $result = array(
                    'body' => $body,
                    'status' => true,
                    'message' => 'Users added to Group successfully!'
                );
            }
        }
        
        
        $this->headerLayout();
        echo json_encode($result);
    }
    
    
    
    public function headerLayout()
    {
        @header("Pragma: no-cache");
        @header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
        @header('Content-Type: text/json');
    }
    
    
    public function pr($data)
    {
        echo "<pre>";
        print_r($data);
        exit;
    }
    
}
?>