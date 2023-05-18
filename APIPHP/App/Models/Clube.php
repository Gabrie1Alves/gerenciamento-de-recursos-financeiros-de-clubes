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
        public static function update($data)
        {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'UPDATE '.self::$table.' 
                SET nome = :no, marca = :ma, ano = :an, descricao = :de, vendido = :ve
                WHERE id = :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $data[0]);
            $stmt->bindValue(':no', $data[1]);
            $stmt->bindValue(':ma', $data[2]);
            $stmt->bindValue(':an', $data[3]);
            $stmt->bindValue(':de', $data[4]);
            $stmt->bindValue(':ve', $data[5]);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Veículo atualizado com sucesso!';
            } else {
                throw new \Exception("Falha ao atualizar veículo!");
            }
        }
    }