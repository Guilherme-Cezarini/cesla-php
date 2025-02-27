<?php

declare(strict_types=1);

namespace Config\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250227200323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE products ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(200) NOT NULL, price FLOAT NOT NULL, description TEXT NOT NULL )");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE products");

    }
}
