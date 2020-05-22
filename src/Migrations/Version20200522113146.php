<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522113146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE listing (id INT AUTO_INCREMENT NOT NULL, symbol VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CB0048D4ECC836F9 (symbol), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historical_quotes_task (uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', symbol VARCHAR(255) NOT NULL, date_from DATETIME NOT NULL, date_to DATETIME NOT NULL, email VARCHAR(255) NOT NULL, data JSON DEFAULT NULL, is_notified TINYINT(1) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE historical_quotes_task');
    }
}
