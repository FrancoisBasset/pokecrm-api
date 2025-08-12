<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250812153517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pokemon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, english_name VARCHAR(255) NOT NULL, generation INTEGER NOT NULL, sprite VARCHAR(255) NOT NULL, types CLOB NOT NULL --(DC2Type:array)
        , height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, catchrate INTEGER NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, storage VARCHAR(255) NOT NULL, accesstoken VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
        $this->addSql('CREATE TABLE user_pokemon (user_id INTEGER NOT NULL, pokemon_id INTEGER NOT NULL, PRIMARY KEY(user_id, pokemon_id), CONSTRAINT FK_3AD18EF9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3AD18EF92FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3AD18EF9A76ED395 ON user_pokemon (user_id)');
        $this->addSql('CREATE INDEX IDX_3AD18EF92FE71C3E ON user_pokemon (pokemon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_pokemon');
    }
}
