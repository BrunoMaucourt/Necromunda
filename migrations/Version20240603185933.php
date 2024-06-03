<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603185933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games_ganger (games_id INT NOT NULL, ganger_id INT NOT NULL, INDEX IDX_F2A9FD6E97FFC673 (games_id), INDEX IDX_F2A9FD6E5D6DCB4 (ganger_id), PRIMARY KEY(games_id, ganger_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games_territories (games_id INT NOT NULL, territories_id INT NOT NULL, INDEX IDX_7972D72897FFC673 (games_id), INDEX IDX_7972D72833B9A304 (territories_id), PRIMARY KEY(games_id, territories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games_injuries (games_id INT NOT NULL, injuries_id INT NOT NULL, INDEX IDX_17E3502297FFC673 (games_id), INDEX IDX_17E350224799CDA1 (injuries_id), PRIMARY KEY(games_id, injuries_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE games_skills (games_id INT NOT NULL, skills_id INT NOT NULL, INDEX IDX_1719F9C597FFC673 (games_id), INDEX IDX_1719F9C57FF61858 (skills_id), PRIMARY KEY(games_id, skills_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE games_ganger ADD CONSTRAINT FK_F2A9FD6E97FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_ganger ADD CONSTRAINT FK_F2A9FD6E5D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_territories ADD CONSTRAINT FK_7972D72897FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_territories ADD CONSTRAINT FK_7972D72833B9A304 FOREIGN KEY (territories_id) REFERENCES territories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_injuries ADD CONSTRAINT FK_17E3502297FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_injuries ADD CONSTRAINT FK_17E350224799CDA1 FOREIGN KEY (injuries_id) REFERENCES injuries (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_skills ADD CONSTRAINT FK_1719F9C597FFC673 FOREIGN KEY (games_id) REFERENCES games (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games_skills ADD CONSTRAINT FK_1719F9C57FF61858 FOREIGN KEY (skills_id) REFERENCES skills (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE games ADD gang1_rating_before_game INT NOT NULL, ADD gang1_rating_after_game INT NOT NULL, ADD gang2_rating_before_game INT NOT NULL, ADD gang2_rating_after_game INT NOT NULL, ADD gang1gain INT NOT NULL, ADD gang2gain INT NOT NULL, ADD gang1loots LONGTEXT NOT NULL, ADD gang2loots LONGTEXT NOT NULL, ADD gang1credits_before_game INT NOT NULL, ADD gang2credits_before_game INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE games_ganger DROP FOREIGN KEY FK_F2A9FD6E97FFC673');
        $this->addSql('ALTER TABLE games_ganger DROP FOREIGN KEY FK_F2A9FD6E5D6DCB4');
        $this->addSql('ALTER TABLE games_territories DROP FOREIGN KEY FK_7972D72897FFC673');
        $this->addSql('ALTER TABLE games_territories DROP FOREIGN KEY FK_7972D72833B9A304');
        $this->addSql('ALTER TABLE games_injuries DROP FOREIGN KEY FK_17E3502297FFC673');
        $this->addSql('ALTER TABLE games_injuries DROP FOREIGN KEY FK_17E350224799CDA1');
        $this->addSql('ALTER TABLE games_skills DROP FOREIGN KEY FK_1719F9C597FFC673');
        $this->addSql('ALTER TABLE games_skills DROP FOREIGN KEY FK_1719F9C57FF61858');
        $this->addSql('DROP TABLE games_ganger');
        $this->addSql('DROP TABLE games_territories');
        $this->addSql('DROP TABLE games_injuries');
        $this->addSql('DROP TABLE games_skills');
        $this->addSql('ALTER TABLE games DROP gang1_rating_before_game, DROP gang1_rating_after_game, DROP gang2_rating_before_game, DROP gang2_rating_after_game, DROP gang1gain, DROP gang2gain, DROP gang1loots, DROP gang2loots, DROP gang1credits_before_game, DROP gang2credits_before_game');
    }
}
