<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240526132543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements ADD weapon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipements ADD CONSTRAINT FK_3F02D86B95B82273 FOREIGN KEY (weapon_id) REFERENCES weapons (id)');
        $this->addSql('CREATE INDEX IDX_3F02D86B95B82273 ON equipements (weapon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipements DROP FOREIGN KEY FK_3F02D86B95B82273');
        $this->addSql('DROP INDEX IDX_3F02D86B95B82273 ON equipements');
        $this->addSql('ALTER TABLE equipements DROP weapon_id');
    }
}
