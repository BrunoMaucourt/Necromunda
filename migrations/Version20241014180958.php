<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241014180958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_rules ADD rocket_flare TINYINT(1) NOT NULL, ADD blind_fight_removed TINYINT(1) NOT NULL, ADD re_roll_advancement_dices TINYINT(1) NOT NULL, ADD scenario_modifier TINYINT(1) NOT NULL, DROP photon_flare, DROP blind_fight');
        $this->addSql('ALTER TABLE gang ADD destiny_score INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gang DROP destiny_score');
        $this->addSql('ALTER TABLE custom_rules ADD photon_flare TINYINT(1) NOT NULL, ADD blind_fight TINYINT(1) NOT NULL, DROP rocket_flare, DROP blind_fight_removed, DROP re_roll_advancement_dices, DROP scenario_modifier');
    }
}
