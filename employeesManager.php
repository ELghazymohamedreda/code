<?php
include 'employees.php';
class EmployeesManager{

        private $connect = Null;

        private function getConnect(){
            if(is_null($this->connect)){
                $this->connect =  mysqli_connect('localhost','Root','','realisation');
            }

            else{

                if(!$this->connect){
                    $message = 'Data base connection error : ' . mysqli_connect_error();
                    throw new Exception($message);
                }
            }

            return $this->connect;
        }

    
    public function insertEmployees($employee){

        $firstName = $employee->getfirstName();
        $lastName = $employee->getlastName();
        $age = $employee->getAge();
      
        

 
        $insertDB = "INSERT INTO éemployees(first_name,last_name,age) VALUES('$firstName','$lastName','$age')";
        
        mysqli_query($this->getConnect(),$insertDB);
    }

    public function getAllEmployees(){

        $sqlGetData = "SELECT ID, first_name,last_name, age FROM éemployees";
        $result = mysqli_query($this->getConnect(), $sqlGetData);
        $datas = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $dataArray = array();

        foreach($datas as $data){

                $employe = new Employees();
                $employe->setId($data['ID']);
                $employe->setfirstName($data['first_name']);
                $employe->setlastName($data['last_name']);
                $employe->setAge($data['age']);           
                array_push($dataArray, $employe);


        }

        return $dataArray;

    }

    public function deleteEmployee($id){

      $deleteDB = "DELETE FROM éemployees WHERE ID = $id";
      mysqli_query($this->getConnect(), $deleteDB);
    }


    public function getById($id){

        $getById = "SELECT * FROM éemployees WHERE ID = $id";
        $result =  mysqli_query($this->getConnect(), $getById);
        $employeeData = mysqli_fetch_assoc($result);

        $employee = new Employees();
        $employee->setId($employeeData['ID']);
        $employee->setfirstName($employeeData['first_name']);
        $employee->setlastName($employeeData['last_name']);
        $employee->setAge($employeeData['age']);

        return $employee;


    }
    
    public function modifyEmployee($employee, $id){

        $id = $employee->getId();
        $first_Name =  $employee->getfirstName();
        $last_Name = $employee->getlastName();
        $age = $employee->getAge();
        $updateDB = "UPDATE éemployees SET first_name = '$first_Name',  last_name = '$last_Name', age = '$age' WHERE ID = $id";
        mysqli_query($this->getConnect(),$updateDB);
        
        if(mysqli_error($this->getConnect())){

            $message = "data base connection error " . mysqli_error($this->getConnect());
            throw new exception($message);
        }


        
    }



}



?>