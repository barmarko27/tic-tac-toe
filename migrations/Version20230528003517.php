<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230528003517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INT NOT NULL, next_player_id INT DEFAULT NULL, winner_player_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318CDE6C20EC ON game (next_player_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_232B318C6874926C ON game (winner_player_id)');
        $this->addSql('COMMENT ON COLUMN game.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN game.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE move (id INT NOT NULL, game_id INT NOT NULL, player_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, x SMALLINT NOT NULL, y SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EF3E3778E48FD905 ON move (game_id)');
        $this->addSql('CREATE INDEX IDX_EF3E377899E6F5DF ON move (player_id)');
        $this->addSql('COMMENT ON COLUMN move.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE player (id INT NOT NULL, game_id INT NOT NULL, player_number INT NOT NULL, symbol_assigned VARCHAR(1) NOT NULL, name VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98197A65E48FD905 ON player (game_id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CDE6C20EC FOREIGN KEY (next_player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6874926C FOREIGN KEY (winner_player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE move ADD CONSTRAINT FK_EF3E3778E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE move ADD CONSTRAINT FK_EF3E377899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318CDE6C20EC');
        $this->addSql('ALTER TABLE game DROP CONSTRAINT FK_232B318C6874926C');
        $this->addSql('ALTER TABLE move DROP CONSTRAINT FK_EF3E3778E48FD905');
        $this->addSql('ALTER TABLE move DROP CONSTRAINT FK_EF3E377899E6F5DF');
        $this->addSql('ALTER TABLE player DROP CONSTRAINT FK_98197A65E48FD905');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE move');
        $this->addSql('DROP TABLE player');
    }
}
