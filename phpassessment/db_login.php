<?php

   class dbConnection{
      // Store the single instance of Database 
      private static $m_pInstance; 
      private static $db_connection;

      private function __construct() {
         self::getConnection();
      }
      
      private static function getConnection(){

         $hostName = "localhost";
         // $hostName = '192.168.1.68';
         $dbname = "test";
         // $dbname = 'assessment';
         $userName = "postgres";
         $userPassword = "password";
         // $userName = 'psqladmin';
         // $userPassword = 'psqladmin';
         $port = "5432";

      
         $connStr = "host=$hostName dbname=$dbname user=$userName password=$userPassword";
         self::$db_connection = pg_connect($connStr);
      }

      public static function getInstance(){
         if (!self::$m_pInstance){
            self::$m_pInstance = new dbConnection();
         }

         return self::$m_pInstance;
      }
      
      public static function query($sqlStr){
         if(self::$db_connection != null){
            //self::getConnection();
            $result = pg_query(self::$db_connection, "$sqlStr");
            return $result;
         }
         return null;
      }
      
      public static function getTableHeaders($tableName){
         
         if(self::$db_connection != null){
            $sqlStr = "select column_name from information_schema.columns where table_name = '$tableName'";
            
            $result = pg_query(self::$db_connection, "$sqlStr");
            
            $resultArray = array();
            
            while($row = pg_fetch_array( $result )) {
                  array_push($resultArray, $row['column_name']);
            }
            
            return $resultArray;
            
         }
         
         return null;
      }
   }
   
   $conn = dbConnection::getInstance();
   
?>
