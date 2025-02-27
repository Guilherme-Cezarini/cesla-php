<?php
namespace Cmd;
use Config\Database;
use Exception;

class LoadTest implements Cmd 
{
    private $table = 'products';

    public function handler() 
    {
        openlog("ceslaPHP", LOG_PID | LOG_PERROR, LOG_LOCAL0);
        $database = new Database();
        $conn = $database->connection();
        $batchSize = 1000;
        $values = [];
        syslog(LOG_INFO, "Tamanho do batch: $batchSize");

        $conn->beginTransaction();

        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        try {
            for($i = 0; $i < 1000000; $i++) { 
                $values[] = ["Produto $i", rand(1,100), "Descricao $i"];
                $valueNumber = $i+1;
                syslog(LOG_INFO, "Criando valor para produto $valueNumber");
                if(($i + 1) % $batchSize === 0) { 
                    $replace = implode(",", array_fill(0, count($values), '(?, ?, ?)'));
                    $sql = "INSERT INTO ". $this->table . " (name, price, description) VALUES $replace";
                    $insert = $conn->prepare($sql);
                    $mergeValues = array_merge(...array_map('array_values', $values));
                    $insert->execute($mergeValues);
                    $batchNumber = ($i + 1) / $batchSize;
                    syslog(LOG_INFO, "Executando PDO para batch de numero $batchNumber");
                    $values = [];
                }
            }

            if(!empty($values)) {
                $replace = implode(",", array_fill(0, count($values), '(?, ?, ?)'));
                $sql = "INSERT INTO ". $this->table . " (name, price, description) VALEUS $replace";
                $insert = $conn->prepare($sql);
                $mergeValues = array_merge(...array_map('array_values', $values));
                $insert->execute($mergeValues);
                syslog(LOG_INFO, "Executando o ultimo PDO do batch");
            }

            $conn->commit();
            syslog(LOG_INFO, "Transacoes commitadas");
        } catch (Exception $e) {
            $conn->rollback();
            syslog(LOG_ERR, "Erro: ". $e->getMessage());
            
        }

        closelog();

        $endTime = microtime(true);
        $endMemory = memory_get_usage();
        $executionTime = $endTime - $startTime;
        $memoryUsage = $endMemory - $startMemory;
        $load = sys_getloadavg();
        $report = "Relatório de Execução:\n";
        $report .= "Tempo de execução: " . $executionTime . " segundos\n";
        $report .= "Consumo de memória: " . $memoryUsage . " bytes\n";
        $report .= "Carga média do sistema (1 min): " . $load[0] . "\n";
        $report .= "Carga média do sistema (5 min): " . $load[1] . "\n";
        $report .= "Carga média do sistema (15 min): " . $load[2] . "\n";


        file_put_contents('relatorio.txt', $report);

    }
}