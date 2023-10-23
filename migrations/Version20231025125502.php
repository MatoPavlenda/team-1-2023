<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025125502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_employee DROP FOREIGN KEY FK_450860CCA76ED395');
        $this->addSql('DROP INDEX IDX_450860CCA76ED395 ON company_employee');
        $this->addSql('ALTER TABLE company_employee DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_employee ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE company_employee ADD CONSTRAINT FK_450860CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_450860CCA76ED395 ON company_employee (user_id)');
    }
}
