<?php
    namespace App\Models;

    class Clube
    {
        //tabela do banco
        private static $clube_tab = 'clubes';

        /**
         * Função que retorna todos os elementos do banco
         */
        public static function selectAllClubes() {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$clube_tab;
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum clube cadastrado!");
            }
        }

        /**
         * Função que realiza o insert de um novo valor no banco banco
         */
        public static function insertClube($data)
        {

            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'INSERT INTO '.self::$clube_tab.' (clube, saldo_disponivel) VALUES (:cl, :sd)';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':cl', $data[0]);
            $stmt->bindValue(':sd', $data[1]);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Clube inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir clube!");
            }
        }
        /**
         * Função que realiza a atualização de valores no banco
         */
        public static function update($idClube, $saldo)
        {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'UPDATE '.self::$clube_tab.' 
                SET saldo_disponivel = :sd
                WHERE id = :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $idClube);
            $stmt->bindValue(':sd', $saldo);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 1;
            } else {
                throw new \Exception("Falha ao atualizar saldo do clube!");
            }
        }
    }