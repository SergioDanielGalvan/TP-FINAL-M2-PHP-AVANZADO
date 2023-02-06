<?php

    class conexionDBMS {
        private static $url = "localhost";
        private static $user = "root";
        private static $password = "";
        private static $nombre_base = "utn-2023";
        private static $port = 3306;

        // Otros
        private static $strError = "";
        private static $codeError = 0;

        function __construct( $_url, $_user, $_password , $_nombre_base ) {
            if ( $_url !== "" ) {
                self::$url = $_url;
            }
            if ( $_user !== "" ) {
                self::$user = $_user;
            }
            if ( $_password !== "" ) {
                self::$password = $_password;
            }
            if ( $_nombre_base !== "" ) {
                self::$nombre_base = $_nombre_base;
            }
        }
    
        function __destruct() {
        }

        function conectar( $_url, $_user, $_password , $_nombre_base ) {
            if ( $_url !== "" ) {
                self::$url = $_url;
            }
            if ( $_user !== "" ) {
                self::$user = $_user;
            }
            if ( $_password !== "" ) {
                self::$password = $_password;
            }
            if ( $_nombre_base !== "" ) {
                self::$nombre_base = $_nombre_base;
            }
            $conection = mysqli_connect( self::$url, self::$user, self::$password, self::$nombre_base );
            $conection->query("SET NAMES 'utf8'");
            return $conection;
        }

        static function conexion() {
            $conection = mysqli_connect( self::$url, self::$user, self::$password, self::$nombre_base );
            $conection->query("SET NAMES 'utf8'");
            return $conection;
        }

        static function conexionPDO() {
            $strconection = "mysql:host=" . self::$url . ";port=" . self::$port . "; dbname=" . self::$nombre_base;
            $conection = null;

            try {
                // $conection = new PDO( $strconection, self::$user, self::$password);
                $conection = new PDO( $strconection, self::$user, self::$password);
                self::$strError = "";
                self::$codeError = 0;
            }
            catch (PDOException $e) {
                self::$strError = $e->getMessage();
                self::$codeError = $e->getCode();
                echo( "Error: " . self::$strError);
            }
            return $conection;
        }
    }
