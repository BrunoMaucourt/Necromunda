<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627185533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD history LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE gang ADD history LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE ganger ADD history LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE weapon CHANGE ganger_id ganger_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE weapon CHANGE ganger_id ganger_id INT NOT NULL');
        $this->addSql('ALTER TABLE game DROP history');
        $this->addSql('ALTER TABLE gang DROP history');
        $this->addSql('ALTER TABLE ganger CHANGE history history LONGTEXT NOT NULL');
    }
}
