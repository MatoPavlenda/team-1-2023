<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024231545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_school_contract ADD company_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company_school_contract ADD CONSTRAINT FK_58382660979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_58382660979B1AD6 ON company_school_contract (company_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_school_contract DROP FOREIGN KEY FK_58382660979B1AD6');
        $this->addSql('DROP INDEX IDX_58382660979B1AD6 ON company_school_contract');
        $this->addSql('ALTER TABLE company_school_contract DROP company_id');
    }
}
