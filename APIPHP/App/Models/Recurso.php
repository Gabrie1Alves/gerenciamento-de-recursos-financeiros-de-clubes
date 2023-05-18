<?php
    namespace App\Models;

    class Recurso
    {
        //tabela do banco
        private static $recurso_tab = 'recursos';

        /**
         * Função que retorna todos os elementos do banco
         */
        public static function selectAllRecursos() {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$recurso_tab;
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum recurso cadastrado!");
            }
        }
        /**
         * Função que realiza a atualização de valores no banco
         */
        public static function updateRecurso($idRecurso, $saldo)
        {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'UPDATE '.self::$recurso_tab.' 
                SET saldo_disponivel = :sd
                WHERE id = :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $idRecurso);
            $stmt->bindValue(':sd', $saldo);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 1;
            } else {
                throw new \Exception("Falha ao atualizar recursos!");
            }
        }
    }