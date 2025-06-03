<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250526074410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, birth_date DATE NOT NULL, medical_notes LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE child_user (child_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_38A275BBDD62C21B (child_id), INDEX IDX_38A275BBA76ED395 (user_id), PRIMARY KEY(child_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, child_id INT NOT NULL, check_in_by_id INT DEFAULT NULL, check_out_by_id INT DEFAULT NULL, date DATE NOT NULL, check_in_time TIME DEFAULT NULL, check_out_time TIME DEFAULT NULL, INDEX IDX_6977C7A5DD62C21B (child_id), INDEX IDX_6977C7A5DECA114 (check_in_by_id), INDEX IDX_6977C7A5A2BEEEEC (check_out_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_user ADD CONSTRAINT FK_38A275BBDD62C21B FOREIGN KEY (child_id) REFERENCES child (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_user ADD CONSTRAINT FK_38A275BBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5DD62C21B FOREIGN KEY (child_id) REFERENCES child (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5DECA114 FOREIGN KEY (check_in_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence ADD CONSTRAINT FK_6977C7A5A2BEEEEC FOREIGN KEY (check_out_by_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE child_user DROP FOREIGN KEY FK_38A275BBDD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE child_user DROP FOREIGN KEY FK_38A275BBA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5DD62C21B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5DECA114
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A5A2BEEEEC
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE child_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE presence
        SQL);
    }
}
