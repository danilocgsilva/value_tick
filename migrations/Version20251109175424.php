<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251109175424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tick ADD unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tick ADD CONSTRAINT FK_16AF98CCF8BD700D FOREIGN KEY (unit_id) REFERENCES unit (id)');
        $this->addSql('CREATE INDEX IDX_16AF98CCF8BD700D ON tick (unit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tick DROP FOREIGN KEY FK_16AF98CCF8BD700D');
        $this->addSql('DROP TABLE unit');
        $this->addSql('DROP INDEX IDX_16AF98CCF8BD700D ON tick');
        $this->addSql('ALTER TABLE tick DROP unit_id');
    }
}
