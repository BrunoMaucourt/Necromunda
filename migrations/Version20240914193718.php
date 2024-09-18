<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914193718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP gang1loots, DROP gang2loots');
        $this->addSql('ALTER TABLE equipement ADD free TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE weapon ADD free TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE loot ADD free TINYINT(1) NOT NULL');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD gang1loots LONGTEXT NOT NULL, ADD gang2loots LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE equipement DROP free');
        $this->addSql('ALTER TABLE weapon DROP free');
        $this->addSql('ALTER TABLE loot DROP free');
    }
}