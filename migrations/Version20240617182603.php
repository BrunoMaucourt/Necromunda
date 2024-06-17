<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617182603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE loot (id INT AUTO_INCREMENT NOT NULL, gang_id INT NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, INDEX IDX_A632D9F79266B5E (gang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE loot ADD CONSTRAINT FK_A632D9F79266B5E FOREIGN KEY (gang_id) REFERENCES gang (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE loot DROP FOREIGN KEY FK_A632D9F79266B5E');
        $this->addSql('DROP TABLE loot');
    }
}
