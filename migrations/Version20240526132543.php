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
        $this->addSql('ALTER TABLE equipement ADD weapon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_3F02D86B95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_3F02D86B95B82273 ON equipement (weapon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_3F02D86B95B82273');
        $this->addSql('DROP INDEX IDX_3F02D86B95B82273 ON equipement');
        $this->addSql('ALTER TABLE equipement DROP weapon_id');
    }
}
