<?php 

header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Credentials: true");
  header("Access-Control-Allow-Methods: PUT, POST, GET, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept,  X-Requested-With , x-xsrf-token");
  header("Content-Type: application/json; charset=utf-8");




  include "./config.php";

  $postjson = json_decode(file_get_contents('php://input'), true);

  $today = date('Y-m-d');

  if ($postjson['aksi']=='proses_register') {
      # code...
      $password = md5($postjson['password']);

      $query1 = mysqli_query($conn, " INSERT INTO customers SET
                                cusUsername = '$postjson[your_name]',
                                gender      = '$postjson[gender]',
                                DOB         = '$postjson[date_birth]',
                                cusEmail    = '$postjson[email_address]',
                                pass        = '$password',
                                created_at  = '$today'
                                 ");

    if ($query1) {
        # code...
        $result =  json_encode(array('success'=>true, 'msg'=> 'Successfully Signned Up'));

    }else {
        # code...
        $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
    }

    echo $result;

  }elseif ($postjson['aksi']=='proses_login') {
    # code...
    $password = md5($postjson['password']);

    $queryLogin = mysqli_fetch_array(mysqli_query($conn, " SELECT * FROM customers WHERE 
                    cusEmail = '$postjson[email_address]' AND pass = '$password'" ));
    
    
    $data =  array(
        'cid' => $queryLogin['cusId'],
        'your_name' => $queryLogin['cusUsername'],
        'gender '     => $queryLogin['gender'],
        'date_birth'         => $queryLogin['DOB'],
        'email_address'    => $queryLogin['cusEmail']



        );

  if ($queryLogin) {
      # code...
      $result =  json_encode(array('success'=>true, 'result'=> $data));

  }else {
      # code...
      $result =  json_encode(array('success'=>false));
  }

  echo $result;


}


//salon login

elseif ($postjson['aksi']=='proses_salonlogin') {
  # code...
  
  $data =  array();
  $queryLogin = mysqli_query($conn, " SELECT * FROM salon_info WHERE 
                   email = '$postjson[email]'" );
  
  
  while($rows = mysqli_fetch_array($queryLogin)){

    $data[] =  array(
      'salonId' =>         $rows['salonId'],
      'salonName' =>         $rows['salonName'],
      'email' => $rows['email'],
      'image1'     =>  $rows['image1'],
      'image2'     =>  $rows['image2'],
      'rating' => $rows['totalRate'],
      'subtopic1' => $rows['subtopic1'],
      'subtopic2' => $rows['subtopic2'],
      'subtopic3' => $rows['subtopic3'],
      'subtopic1Des' => $rows['subtopic1Des'],
      'subtopic2Des' => $rows['subtopic2Des'],
      'subtopic3Des' => $rows['subtopic3Des']

      );
  }
  
if ($queryLogin) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//salon owner login for create page

elseif ($postjson['aksi']=='proses_createsalonlogin') {
  # code...
  
  $data =  array();
  $queryLogin = mysqli_query($conn, " SELECT * FROM salonowners WHERE 
                   email = '$postjson[email]'" );
  
  
  while($rows = mysqli_fetch_array($queryLogin)){

    $data[] =  array(
      'salonUserId' =>         $rows['salonUserId'],
      'salonName' =>         $rows['salonName'],
      'email' => $rows['email']

      );
  }
  
if ($queryLogin) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//load rated salons
elseif ($postjson['aksi']=='load_salons') {
  # code...

  $data =  array();
  $queryLoading = mysqli_query($conn, " SELECT * FROM salon_info WHERE totalRate BETWEEN 50 AND 100 ORDER BY 
  rand() DESC LIMIT $postjson[start],$postjson[limit]" );
  
  while($rows = mysqli_fetch_array($queryLoading)){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image'     =>  $rows['image1'],
      'location' => $rows['location1']
      // ,
      // 'date_birth'         => $queryLogin['DOB'],
      // 'email_address'    => $queryLogin['cusEmail']



      );
  }
  

if ($queryLoading) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//load all salons
elseif ($postjson['aksi']=='load_all_salons') {
  # code...

  $data =  array();
  $queryAllSalons = mysqli_query($conn, " SELECT * FROM salon_info " );
  
  while($rows = mysqli_fetch_array($queryAllSalons)){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image'     =>  $rows['image1']
      // ,
      // 'date_birth'         => $queryLogin['DOB'],
      // 'email_address'    => $queryLogin['cusEmail']



      );
  }
  

if ($queryAllSalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//load salon by id
elseif ($postjson['aksi']=='load_salon_page') {
  # code...

  $data =  array();
  $queryLoadPage = mysqli_query($conn, " SELECT * FROM salon_info where salonId = '$postjson[id]' " );//id should pass here with submit button
  
  while($rows = mysqli_fetch_array($queryLoadPage )){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image1'     =>  $rows['image1'],
      'image2'     =>  $rows['image2'],
      'rating' => $rows['totalRate'],
      'subtopic1' => $rows['subtopic1'],
      'subtopic2' => $rows['subtopic2'],
      'subtopic3' => $rows['subtopic3'],
      'subtopic1Des' => $rows['subtopic1Des'],
      'subtopic2Des' => $rows['subtopic2Des'],
      'subtopic3Des' => $rows['subtopic3Des'],
      'mobile' => $rows['mobile']
      
   



      );
  }
  

if ($queryLoadPage ) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//appointment booking
elseif ($postjson['aksi']=='proses_appbooking') {
 

  $query1 = mysqli_query($conn, " INSERT INTO appoinment SET
  cusId = '$postjson[cusId]',
employeeId = '1',
status = '1',
rated = '50',
view = '0',
blocked = '0',
rateAmount = '4',
                            cusUsername = '$postjson[your_name]',
                            service     = '$postjson[services]',
                            bookingDate  = '$postjson[date_appointment]',
                            cusEmail    = '$postjson[email_address]',
                            employeeName = '$postjson[stylist]',
                            slotId = '$postjson[timeslot]',
                            salonName = '$postjson[salon_name]',
                            salonId=  '$postjson[salon_id]'
                             ");
                             //salon_id kiyanne leftside of aksi in ts

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}
//stylist booking
elseif ($postjson['aksi']=='proses_stylistbooking') {
 

  $query1 = mysqli_query($conn, " UPDATE appoinment SET
                            employeeName  = '$postjson[stylist]'
                    
                            WHERE salonId= '$postjson[salon_id] '
                             ");

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//load stylist
elseif ($postjson['aksi']=='load_stylist') {
  # code...

  $data =  array();
  $querySalons = mysqli_query($conn, " SELECT * FROM employee WHERE salonId = '$postjson[id]'  " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
      'employeeId' =>         $rows['employeeId'],
      'employeeName' => $rows['employeeName'],
      'employeeEmail'     =>  $rows['employeeEmail']
      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//load stylist
elseif ($postjson['aksi']=='load_timeslot') {
  # code...

  $data =  array();
  $querySalons = mysqli_query($conn, " SELECT * FROM timeslot " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
      'slotId' =>  $rows['slotId'],
      'time' => $rows['time']
      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}

//search salons
elseif ($postjson['aksi']=='search_salons') {
  # code...

  $data =  array();
  $sampleloaction=$postjson['salon_name'];
  $samplebname=$postjson['salon_name'];
  $querySalons = mysqli_query($conn, " SELECT * FROM salon_info WHERE location1 LIKE '%{$sampleloaction}%' or salonName LIKE '%{$samplebname}%' " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image'     =>  $rows['image1'],
      'location'     =>  $rows['location1']
      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//search salons by location
elseif ($postjson['aksi']=='search_Locations') {
  # code...

  $data =  array();
  $querySalons = mysqli_query($conn, " SELECT * FROM salon_info WHERE location1 LIKE '$postjson[location]'  " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image'     =>  $rows['image1'],
      'location'     =>  $rows['location1']
      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}

//customer notifications
elseif ($postjson['aksi']=='customer_notification') {
  # code...

  $data =  array();
  $querySalons = mysqli_query($conn, " SELECT * FROM appoinment WHERE cusId = '$postjson[id]'  " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
      'slid' =>       $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'service'     =>  $rows['service'],
      'employeeName' => $rows['employeeName'],
      'bookingDate' => $rows['bookingDate']
      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//salon notifications
elseif ($postjson['aksi']=='salon_notification') {
  # code...

  $data =  array();
  $querySalons = mysqli_query($conn, " SELECT * FROM appoinment WHERE salonId = '$postjson[id]' and blocked='0' " );
  
  while($rows = mysqli_fetch_array($querySalons)){

    $data[] =  array(
     
      'cusUsername' => $rows['cusUsername'],
      'bookingId' => $rows['bookingId'],
      'cusEmail'     =>  $rows['cusEmail'],
      'service' => $rows['service'],
      'employeeName' => $rows['employeeName'],
      'bookingDate' => $rows['bookingDate']

      

      );
  }
  

if ($querySalons) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}


//proses_rejectappoinment
elseif ($postjson['aksi']=='proses_rejectappoinment') {
 

  $query1 = mysqli_query($conn, " UPDATE appoinment SET
 
                            blocked = '1' 
                            
                           
                            
                            WHERE bookingId = '$postjson[bookingId]' 
                            
                            
                             ");
                             //salon_id kiyanne leftside of aksi in ts log wela in salon eke id eka

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//create salon page load salon 1 
elseif ($postjson['aksi']=='proses_createPage') {
  # code...

  
  $query1 = mysqli_query($conn, " INSERT INTO salon_info SET
  
                            salonName= '$postjson[salonName]',
                            location1 = '$postjson[location]',
                            mobile= '$postjson[mobile]',
                            email= '$postjson[email]',
                            about = '$postjson[about]',
                            subtopic1 = '$postjson[service1]',
                            subtopic2 = '$postjson[service2]',
                            subtopic3 = '$postjson[service3]',
                            subtopic1Des = '$postjson[des1]',
                            subtopic2Des = '$postjson[des2]',
                            subtopic3Des = '$postjson[des3]'
                             ");
                             //salon_id kiyanne leftside of aksi in ts

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}



//update salon
elseif ($postjson['aksi']=='update_salon') {
 

  $query1 = mysqli_query($conn, " INSERT INTO salon_info SET 
                            salonName = '$postjson[your_name]'
                             ");

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}elseif ($postjson['aksi']=='create_account') {
 

  $query1 = mysqli_query($conn, " INSERT INTO employee SET
                            employeeName = '$postjson[your_name]',
                            employeeEmail    = '$postjson[email_address]'
                             ");

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));
    



}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//create salon owner accout
elseif ($postjson['aksi']=='proses_createAccount') {
  # code...
  $password = md5($postjson['password']);

  $query1 = mysqli_query($conn, " INSERT INTO salonowners SET
                            salonUserName = '$postjson[salon_your_name]',
                            salonName = '$postjson[salon_name]',
                            ownerName = '$postjson[your_name]',
                            gender      = '$postjson[gender]',
                            DOB         = '$postjson[date_birth]',
                            email    = '$postjson[email_address]',
                            pass        = '$password',
                            NUM = '$postjson[mnumber]'
                             ");

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfully Signned Up'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//salon owner page load
elseif ($postjson['aksi']=='load_salon_owner_page') {
  # code...

  $data =  array();
  $queryLoadPage = mysqli_query($conn, " SELECT * FROM salon_info where salonId = '17' " ); //salon login weddi log wena kena ganna one
  
  while($rows = mysqli_fetch_array($queryLoadPage )){

    $data[] =  array(
      'id' =>         $rows['salonId'],
      'salon_name' => $rows['salonName'],
      'image1'     =>  $rows['image1'],
      'email'     =>  $rows['email'],
      'rating' => $rows['totalRate'],
      'subtopic1' => $rows['subtopic1'],
      'subtopic2' => $rows['subtopic2'],
      'subtopic3' => $rows['subtopic3'],
      'subtopic1Des' => $rows['subtopic1Des'],
      'subtopic2Des' => $rows['subtopic2Des'],
      'subtopic3Des' => $rows['subtopic3Des']



      );
  }
  

if ($queryLoadPage ) {
    # code...
    $result =  json_encode(array('success'=>true, 'result'=> $data));

}else {
    # code...
    $result =  json_encode(array('success'=>false));
}

echo $result;

}
//update salon
elseif ($postjson['aksi']=='proses_updatesalon') {
 

  $query1 = mysqli_query($conn, " UPDATE salon_info SET
 
                            salonName = '$postjson[salon_name]' ,
                            email = '$postjson[email]' ,
                            mobile = '$postjson[mobile]'
                           
                            
                            WHERE salonId = '$postjson[salon_id]' 
                            
                            
                             ");
                             //salon_id kiyanne leftside of aksi in ts log wela in salon eke id eka

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//proses_updatename
elseif ($postjson['aksi']=='proses_updatename') {
 

  $query1 = mysqli_query($conn, " UPDATE salon_info SET
 
                            salonName = '$postjson[salon_name]' 
                           
                            
                            WHERE salonId = '$postjson[salon_id]' 
                            
                            
                             ");
                             //salon_id kiyanne leftside of aksi in ts log wela in salon eke id eka

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}


//proses_updatemp
elseif ($postjson['aksi']=='proses_updatemp') {
 

  $query1 = mysqli_query($conn, " INSERT INTO employee SET
                            salonId = '$postjson[salon_id]' ,
                            employeeName = '$postjson[emp_name]' ,
                            employeeEmail = '$postjson[emp_email]' 
                            
                            
                            
                             ");
                             //salon_id kiyanne leftside of aksi in ts log wela in salon eke id eka

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}
//rate salon
elseif ($postjson['aksi']=='proses_rate') {
 

  $query1 = mysqli_query($conn, " UPDATE salon_info SET
 
                            totalRate =  totalRate + '$postjson[rate]' 
                            WHERE salonId = '$postjson[salon_id]' 
                            
                            
                             ");
                             //salon_id kiyanne leftside of aksi in ts log wela in salon eke id eka

if ($query1) {
    # code...
    $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

}else {
    # code...
    $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
}

echo $result;

}

//create salon
// elseif ($postjson['aksi']=='proses_createsalon') {
 

//   $query1 = mysqli_query($conn, " INSERT INTO salon_info SET
  
//   salon_name = '$postjson[salon_name]' 
//                              ");
//                              //salon_id kiyanne leftside of aksi in ts

// if ($query1) {
//     # code...
//     $result =  json_encode(array('success'=>true, 'msg'=> 'Successfull'));

// }else {
//     # code...
//     $result =  json_encode(array('success'=>false, 'msg'=> 'Error'));
// }

// echo $result;

// }

  ?>