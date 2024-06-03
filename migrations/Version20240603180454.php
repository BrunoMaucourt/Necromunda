<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603180454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE advancement (id INT AUTO_INCREMENT NOT NULL, ganger_id INT NOT NULL, game_id INT NOT NULL, skill_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_9254210C5D6DCB4 (ganger_id), INDEX IDX_9254210CE48FD905 (game_id), INDEX IDX_9254210C5585C142 (skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE advancement ADD CONSTRAINT FK_9254210C5D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id)');
        $this->addSql('ALTER TABLE advancement ADD CONSTRAINT FK_9254210CE48FD905 FOREIGN KEY (game_id) REFERENCES games (id)');
        $this->addSql('ALTER TABLE advancement ADD CONSTRAINT FK_9254210C5585C142 FOREIGN KEY (skill_id) REFERENCES skills (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE advancement DROP FOREIGN KEY FK_9254210C5D6DCB4');
        $this->addSql('ALTER TABLE advancement DROP FOREIGN KEY FK_9254210CE48FD905');
        $this->addSql('ALTER TABLE advancement DROP FOREIGN KEY FK_9254210C5585C142');
        $this->addSql('DROP TABLE advancement');
    }
}
