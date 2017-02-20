<?php  $create = array( 'user'=>array("first_name"=>"Annamalai",'last_name'=>"Soman"),
            'email'=>array('annamalai19@gmail.com','annamalai19+test@gmail.com'),
            'phone'=>array("home"=>"1010","office"=>"13434"),
            'address'=>array(
              
              array("address"=>"Jurong West","city"=>"Singapore","state"=>"Singapore","country"=>"SG"),
              array("address"=>"Holland Village","city"=>"Singapore","state"=>"Singapore","country"=>"SG"),
              array("address"=>"Menara Jaya","city"=>"Petaling Jaya","state"=>"Kuala Lumpur","country"=>"MY"),
              ),
            'groups' =>array("1","2"));
$update = array( '16'=>array('user'=>array("first_name"=>"Annamalai",'last_name'=>"Soman")));

$groupcreate =array('group'=>array('name'=>'Friends'));

$groupjoin =array('groups'=>array(
          'join' => array(
             array(
              'user_id' =>1, 
              'group_id'=>1
              ),
             array(
              'user_id' =>1, 
              'group_id'=>2
              ),
             array(
              'user_id' =>1, 
              'group_id'=>5
              ),
            ),
          'remove'=> array()
          ));
echo "<h2>APIKEY :</h2>".md5(date('Y-m-d').'rest_api_client');
echo "<h2>person.create  Sample DATA AS follows</h2>";
print_r(json_encode($create));
echo "<h2><br/>person.update Sample DATA AS follows</h2>";
print_r(json_encode($update));
echo "<h2><br/>group.create Sample DATA AS follows</h2>";
print_r(json_encode($groupcreate));
echo "<h2><br/>group.join Sample DATA AS follows</h2>";
print_r(json_encode($groupjoin));



 ?>


