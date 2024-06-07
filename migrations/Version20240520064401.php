<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520064401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, ganger_id INT NOT NULL, name INT NOT NULL, cost INT NOT NULL, INDEX IDX_3F02D86B5D6DCB4 (ganger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, gang1_id INT NOT NULL, gang2_id INT NOT NULL, winner_id INT NOT NULL, scenario VARCHAR(255) NOT NULL, date DATE NOT NULL, background LONGTEXT DEFAULT NULL, INDEX IDX_FF232B315AB6770B (gang1_id), INDEX IDX_FF232B314803D8E5 (gang2_id), INDEX IDX_FF232B315DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gang (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, rating INT NOT NULL, credits INT NOT NULL, status TINYINT(1) NOT NULL, background LONGTEXT DEFAULT NULL, INDEX IDX_E6080363A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ganger (id INT AUTO_INCREMENT NOT NULL, gang_id INT NOT NULL, name VARCHAR(255) NOT NULL, move INT NOT NULL, weapon_skill INT NOT NULL, ballistic_skill INT NOT NULL, strength INT NOT NULL, toughness INT NOT NULL, wounds INT NOT NULL, initiative INT NOT NULL, attacks INT NOT NULL, leadership INT NOT NULL, background LONGTEXT DEFAULT NULL, alive TINYINT(1) NOT NULL, experience INT NOT NULL, cost INT NOT NULL, rating INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_308112DB9266B5E (gang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE injury (id INT AUTO_INCREMENT NOT NULL, victim_id INT NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BEE4371E44972A0E (victim_id), INDEX IDX_BEE4371EF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, ganger_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D53116705D6DCB4 (ganger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE territory (id INT AUTO_INCREMENT NOT NULL, gang_id INT NOT NULL, name VARCHAR(255) NOT NULL, income_fixed INT NOT NULL, income_variable INT NOT NULL, INDEX IDX_E0DBA3B69266B5E (gang_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weapon (id INT AUTO_INCREMENT NOT NULL, ganger_id INT NOT NULL, name VARCHAR(255) NOT NULL, cost INT NOT NULL, INDEX IDX_520EBBE15D6DCB4 (ganger_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_3F02D86B5D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_FF232B315AB6770B FOREIGN KEY (gang1_id) REFERENCES gang (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_FF232B314803D8E5 FOREIGN KEY (gang2_id) REFERENCES gang (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_FF232B315DFCD4B8 FOREIGN KEY (winner_id) REFERENCES gang (id)');
        $this->addSql('ALTER TABLE gang ADD CONSTRAINT FK_E6080363A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ganger ADD CONSTRAINT FK_308112DB9266B5E FOREIGN KEY (gang_id) REFERENCES gang (id)');
        $this->addSql('ALTER TABLE injury ADD CONSTRAINT FK_BEE4371E44972A0E FOREIGN KEY (victim_id) REFERENCES ganger (id)');
        $this->addSql('ALTER TABLE injury ADD CONSTRAINT FK_BEE4371EF675F31B FOREIGN KEY (author_id) REFERENCES ganger (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_D53116705D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id)');
        $this->addSql('ALTER TABLE territory ADD CONSTRAINT FK_E0DBA3B69266B5E FOREIGN KEY (gang_id) REFERENCES gang (id)');
        $this->addSql('ALTER TABLE weapon ADD CONSTRAINT FK_520EBBE15D6DCB4 FOREIGN KEY (ganger_id) REFERENCES ganger (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipement DROP FOREIGN KEY FK_3F02D86B5D6DCB4');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_FF232B315AB6770B');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_FF232B314803D8E5');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_FF232B315DFCD4B8');
        $this->addSql('ALTER TABLE gang DROP FOREIGN KEY FK_E6080363A76ED395');
        $this->addSql('ALTER TABLE ganger DROP FOREIGN KEY FK_308112DB9266B5E');
        $this->addSql('ALTER TABLE injury DROP FOREIGN KEY FK_BEE4371E44972A0E');
        $this->addSql('ALTER TABLE injury DROP FOREIGN KEY FK_BEE4371EF675F31B');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_D53116705D6DCB4');
        $this->addSql('ALTER TABLE territory DROP FOREIGN KEY FK_E0DBA3B69266B5E');
        $this->addSql('ALTER TABLE weapon DROP FOREIGN KEY FK_520EBBE15D6DCB4');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE gang');
        $this->addSql('DROP TABLE ganger');
        $this->addSql('DROP TABLE injury');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE territory');
        $this->addSql('DROP TABLE weapon');
    }
}
