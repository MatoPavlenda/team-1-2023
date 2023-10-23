<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025123653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE practice_offer (id INT AUTO_INCREMENT NOT NULL, tutor_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, position VARCHAR(255) NOT NULL, registration_date VARCHAR(255) NOT NULL, start DATE NOT NULL, end DATE NOT NULL, create_time DATETIME NOT NULL, student_count INT NOT NULL, INDEX IDX_119CF15208F64F1 (tutor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE practice_offer ADD CONSTRAINT FK_119CF15208F64F1 FOREIGN KEY (tutor_id) REFERENCES company_employee (id)');
        $this->addSql('ALTER TABLE company_employee ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company_employee ADD CONSTRAINT FK_450860CC979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_450860CC979B1AD6 ON company_employee (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE practice_offer DROP FOREIGN KEY FK_119CF15208F64F1');
        $this->addSql('DROP TABLE practice_offer');
        $this->addSql('ALTER TABLE company_employee DROP FOREIGN KEY FK_450860CC979B1AD6');
        $this->addSql('DROP INDEX IDX_450860CC979B1AD6 ON company_employee');
        $this->addSql('ALTER TABLE company_employee DROP company_id');
    }
}
