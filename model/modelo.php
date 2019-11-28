<?php
/*
	* Aqui no Model é onde fica a parte lógica da aplicação.
	* Neste exemplo temos uma classe extremamente simples que retorna apenas uma
	* mensagem de texto, mas em aplicações maiores aqui é o local onde seriam feitas
	* as comunicações com Banco de Dados por exemplo, as validações, etc.
é preciso optimizar

*/

class Modelo
{


    public function getMensagem()
    {
        return "Contéudo";
    }
}

class PioRest {

    public function getCourses() {

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/courseservice/retrievecourses",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3000,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\r\n\t\"ou\":\"ISCAC\",\r\n\t\"academicSystem\":\"nonio\",\r\n\t\"language\":\"PT\"\r\n\t\r\n}",
                CURLOPT_HTTPHEADER => array(
                    "Accept: */*",
                    "Accept-Encoding: gzip, deflate",
                    "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                    "Connection: keep-alive",
                    "Content-Length: 69",
                    "Content-Type: application/json"
                ),
            ));


            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);



            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $retrieved_data = json_decode($response, true);
                $courses = $retrieved_data["courses"];
                return $courses;
            }
        }


    public function getStudents() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/studentservice/searchstudents",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n     \"ou\":\"ISCAC\",\r\n     \"name\":\"*\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Connection: keep-alive",
                "Content-Length: 41",
                "Content-Type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $retrieved_data = json_decode($response, true);
                $students = $retrieved_data["students"];
                return $students;
            }




    }

    public function getStudentList($course) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/courseservice/retrievecourseenrolledstudents",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n\"ou\":\"ISCAC\",\r\n\"lectiveYear\":\"201920\",\r\n\"courseCode\":\"$course\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 68",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $retrieved_data = json_decode($response, true);
            $students = $retrieved_data["students"];
            return $students;
        }
    }


    public function getStudentDetails($numSGA,$courseCode) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/studentservice/retrievestudentdetail",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\r\n     \"ou\":\"ISCAC\",\r\n     \"numSGA\": \"2018072573\",\r\n     \"courseCode\":\"5091860\"\r\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 90",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $retrieved_data = json_decode($response, true);
             return $retrieved_data;
        }
    }

    public function getTeachers() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/hrservices/rest/v1/employeeservice/searchemployees",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"criteria\":{\n\"name\":\"\",\n\t\t\"ou\":\"ISCAC\"\n\t}\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 46",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $retrieved_data = json_decode($response, true);
            $teachers = $retrieved_data["employeesFound"];
            return $teachers;
        }
    }



    public function getSubjects() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/courseservice/retrievesubjects",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 3000,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\n\t\t\"ou\":\"ISCAC\",\n\t\t\"academicSystem\":\"nonio\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Connection: keep-alive",
                "Content-Length: 47",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $retrieved_data = json_decode($response, true);
            $teachers = $retrieved_data["subjects"];
            return $teachers;
        }
    }

    public function getStudentList2($course,$subject) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pio.intranet.ipc.pt/asservices/rest/v1/subjectservice/retrievesubjectenrolledstudents",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\n\t\t\"ou\":\"ISCAC\",\n\t\t\"courseCode\":\"$course\",\n\t\t\"subjectCode\":\"$subject\",\n\t\t\"lectiveYear\":\"201920\"\n}",
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Authorization: Basic aXNjYWM6Zmhoam1jMzQ0JiZIb3BkcDQ1",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Length: 99",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);


        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $retrieved_data = json_decode($response, true);
            $students2 = $retrieved_data["students"];
            return $students2;
        }
    }

}


?>