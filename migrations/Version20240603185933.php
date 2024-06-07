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
        $this->addSql('CREATE TABLE game_ganger (game_id INT NOT NULL, ganger_id INT NOT NULL, INDEX IDX_F2A9FD6E97FFC673 (game_id), INDEX IDX_F2A9FD6E5D6DCB4 (ganger_id), PRIMARY KEY(game_id, ganger_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_territory (game_id INT NOT NULL, territory_id INT NOT NULL, INDEX IDX_7972D72897FFC673 (game_id), INDEX IDX_7972D72833B9A304 (territory_id), PRIMARY KEY(game_id, territory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_injury (game_id INT NOT NULL, injury_id INT NOT NULL, INDEX IDX_17E3502297FFC673 (game_id), INDEX IDX_17E350224799CDA1 (injury_id), PRIMARY KEY(game_id, injury_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_skill (game_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_1719F9C597FFC673 (game_id), INDEX IDX_1719F9C57FF61858 (skill_id), PRIMARY KEY(game_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game_ganger ADD CONSTRAINT FK_F2A9FD6E97FFC673 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_ganger ADD CONSTRAINT FK_F2A9FD6E5D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_territory ADD CONSTRAINT FK_7972D72897FFC673 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_territory ADD CONSTRAINT FK_7972D72833B9A304 FOREIGN KEY (territory_id) REFERENCES territory (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_injury ADD CONSTRAINT FK_17E3502297FFC673 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_injury ADD CONSTRAINT FK_17E350224799CDA1 FOREIGN KEY (injury_id) REFERENCES injury (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_skill ADD CONSTRAINT FK_1719F9C597FFC673 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_skill ADD CONSTRAINT FK_1719F9C57FF61858 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD gang1_rating_before_game INT NOT NULL, ADD gang1_rating_after_game INT NOT NULL, ADD gang2_rating_before_game INT NOT NULL, ADD gang2_rating_after_game INT NOT NULL, ADD gang1gain INT NOT NULL, ADD gang2gain INT NOT NULL, ADD gang1loots LONGTEXT NOT NULL, ADD gang2loots LONGTEXT NOT NULL, ADD gang1credits_before_game INT NOT NULL, ADD gang2credits_before_game INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_ganger DROP FOREIGN KEY FK_F2A9FD6E97FFC673');
        $this->addSql('ALTER TABLE game_ganger DROP FOREIGN KEY FK_F2A9FD6E5D6DCB4');
        $this->addSql('ALTER TABLE game_territory DROP FOREIGN KEY FK_7972D72897FFC673');
        $this->addSql('ALTER TABLE game_territory DROP FOREIGN KEY FK_7972D72833B9A304');
        $this->addSql('ALTER TABLE game_injury DROP FOREIGN KEY FK_17E3502297FFC673');
        $this->addSql('ALTER TABLE game_injury DROP FOREIGN KEY FK_17E350224799CDA1');
        $this->addSql('ALTER TABLE game_skill DROP FOREIGN KEY FK_1719F9C597FFC673');
        $this->addSql('ALTER TABLE game_skill DROP FOREIGN KEY FK_1719F9C57FF61858');
        $this->addSql('DROP TABLE game_ganger');
        $this->addSql('DROP TABLE game_territory');
        $this->addSql('DROP TABLE game_injury');
        $this->addSql('DROP TABLE game_skill');
        $this->addSql('ALTER TABLE game DROP gang1_rating_before_game, DROP gang1_rating_after_game, DROP gang2_rating_before_game, DROP gang2_rating_after_game, DROP gang1gain, DROP gang2gain, DROP gang1loots, DROP gang2loots, DROP gang1credits_before_game, DROP gang2credits_before_game');
    }
}
