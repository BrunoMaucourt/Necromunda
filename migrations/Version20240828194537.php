<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828194537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE territory DROP FOREIGN KEY FK_E0DBA3B69266B5E');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E97439669266B5E FOREIGN KEY (gang_id) REFERENCES gang (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE territory DROP FOREIGN KEY FK_E97439669266B5E');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E0DBA3B69266B5E FOREIGN KEY (gang_id) REFERENCES gang (id)');
    }
}
