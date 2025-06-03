<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526075644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE typical_week (id INT AUTO_INCREMENT NOT NULL, child_id INT DEFAULT NULL, planning JSON DEFAULT NULL, UNIQUE INDEX UNIQ_13B1631BDD62C21B (child_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE typical_week ADD CONSTRAINT FK_13B1631BDD62C21B FOREIGN KEY (child_id) REFERENCES child (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE typical_week DROP FOREIGN KEY FK_13B1631BDD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE typical_week
        SQL);
    }
}
