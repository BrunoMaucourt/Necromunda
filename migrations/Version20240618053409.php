<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618053409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_skill DROP FOREIGN KEY FK_1719F9C57FF61858');
        $this->addSql('ALTER TABLE game_skill DROP FOREIGN KEY FK_1719F9C597FFC673');
        $this->addSql('DROP TABLE game_skill');
        $this->addSql('ALTER TABLE equipement RENAME INDEX idx_3f02d86b5d6dcb4 TO IDX_B8B4C6F35D6DCB4');
        $this->addSql('ALTER TABLE equipement RENAME INDEX idx_3f02d86b95b82273 TO IDX_B8B4C6F395B82273');
        $this->addSql('ALTER TABLE game ADD gang1credits_after_game INT NOT NULL, ADD gang2credits_after_game INT NOT NULL, ADD summary LONGTEXT NOT NULL, DROP gang1gain, DROP gang2gain');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_ff232b315ab6770b TO IDX_232B318C5AB6770B');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_ff232b314803d8e5 TO IDX_232B318C4803D8E5');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_ff232b315dfcd4b8 TO IDX_232B318C5DFCD4B8');
        $this->addSql('ALTER TABLE game_ganger RENAME INDEX idx_f2a9fd6e97ffc673 TO IDX_4DB4BF13E48FD905');
        $this->addSql('ALTER TABLE game_ganger RENAME INDEX idx_f2a9fd6e5d6dcb4 TO IDX_4DB4BF135D6DCB4');
        $this->addSql('ALTER TABLE game_territory RENAME INDEX idx_7972d72897ffc673 TO IDX_3BD2F864E48FD905');
        $this->addSql('ALTER TABLE game_territory RENAME INDEX idx_7972d72833b9a304 TO IDX_3BD2F86473F74AD4');
        $this->addSql('ALTER TABLE game_injury RENAME INDEX idx_17e3502297ffc673 TO IDX_F77FF4E5E48FD905');
        $this->addSql('ALTER TABLE game_injury RENAME INDEX idx_17e350224799cda1 TO IDX_F77FF4E5ABA45E9A');
        $this->addSql('ALTER TABLE injury RENAME INDEX idx_bee4371e44972a0e TO IDX_8A4A592D44972A0E');
        $this->addSql('ALTER TABLE injury RENAME INDEX idx_bee4371ef675f31b TO IDX_8A4A592DF675F31B');
        $this->addSql('ALTER TABLE loot ADD game_id INT NOT NULL');
        $this->addSql('ALTER TABLE loot ADD CONSTRAINT FK_A632D9F7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_A632D9F7E48FD905 ON loot (game_id)');
        $this->addSql('ALTER TABLE skill RENAME INDEX idx_d53116705d6dcb4 TO IDX_5E3DE4775D6DCB4');
        $this->addSql('ALTER TABLE territory RENAME INDEX idx_e0dba3b69266b5e TO IDX_E97439669266B5E');
        $this->addSql('ALTER TABLE weapon RENAME INDEX idx_520ebbe15d6dcb4 TO IDX_6933A7E65D6DCB4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_skill (game_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_1719F9C597FFC673 (game_id), INDEX IDX_1719F9C57FF61858 (skill_id), PRIMARY KEY(game_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_skill ADD CONSTRAINT FK_1719F9C57FF61858 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_skill ADD CONSTRAINT FK_1719F9C597FFC673 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE weapon RENAME INDEX idx_6933a7e65d6dcb4 TO IDX_520EBBE15D6DCB4');
        $this->addSql('ALTER TABLE skill RENAME INDEX idx_5e3de4775d6dcb4 TO IDX_D53116705D6DCB4');
        $this->addSql('ALTER TABLE injury RENAME INDEX idx_8a4a592df675f31b TO IDX_BEE4371EF675F31B');
        $this->addSql('ALTER TABLE injury RENAME INDEX idx_8a4a592d44972a0e TO IDX_BEE4371E44972A0E');
        $this->addSql('ALTER TABLE game ADD gang1gain INT NOT NULL, ADD gang2gain INT NOT NULL, DROP gang1credits_after_game, DROP gang2credits_after_game, DROP summary');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_232b318c5ab6770b TO IDX_FF232B315AB6770B');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_232b318c4803d8e5 TO IDX_FF232B314803D8E5');
        $this->addSql('ALTER TABLE game RENAME INDEX idx_232b318c5dfcd4b8 TO IDX_FF232B315DFCD4B8');
        $this->addSql('ALTER TABLE game_territory RENAME INDEX idx_3bd2f864e48fd905 TO IDX_7972D72897FFC673');
        $this->addSql('ALTER TABLE game_territory RENAME INDEX idx_3bd2f86473f74ad4 TO IDX_7972D72833B9A304');
        $this->addSql('ALTER TABLE loot DROP FOREIGN KEY FK_A632D9F7E48FD905');
        $this->addSql('DROP INDEX IDX_A632D9F7E48FD905 ON loot');
        $this->addSql('ALTER TABLE loot DROP game_id');
        $this->addSql('ALTER TABLE game_ganger RENAME INDEX idx_4db4bf13e48fd905 TO IDX_F2A9FD6E97FFC673');
        $this->addSql('ALTER TABLE game_ganger RENAME INDEX idx_4db4bf135d6dcb4 TO IDX_F2A9FD6E5D6DCB4');
        $this->addSql('ALTER TABLE game_injury RENAME INDEX idx_f77ff4e5e48fd905 TO IDX_17E3502297FFC673');
        $this->addSql('ALTER TABLE game_injury RENAME INDEX idx_f77ff4e5aba45e9a TO IDX_17E350224799CDA1');
        $this->addSql('ALTER TABLE territory RENAME INDEX idx_e97439669266b5e TO IDX_E0DBA3B69266B5E');
        $this->addSql('ALTER TABLE equipement RENAME INDEX idx_b8b4c6f35d6dcb4 TO IDX_3F02D86B5D6DCB4');
        $this->addSql('ALTER TABLE equipement RENAME INDEX idx_b8b4c6f395b82273 TO IDX_3F02D86B95B82273');
    }
}
