<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250801095922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pokemon AS SELECT id, name, generation, sprite, types, height, weight, catchrate FROM pokemon');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('CREATE TABLE pokemon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, generation INTEGER NOT NULL, sprite VARCHAR(255) NOT NULL, types CLOB NOT NULL --(DC2Type:array)
        , height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, catchrate INTEGER NOT NULL)');
        $this->addSql('INSERT INTO pokemon (id, name, generation, sprite, types, height, weight, catchrate) SELECT id, name, generation, sprite, types, height, weight, catchrate FROM __temp__pokemon');
        $this->addSql('DROP TABLE __temp__pokemon');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__pokemon AS SELECT id, name, generation, sprite, types, height, weight, catchrate FROM pokemon');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('CREATE TABLE pokemon (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, generation INTEGER NOT NULL, sprite BLOB NOT NULL, types CLOB NOT NULL --(DC2Type:array)
        , height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, catchrate INTEGER NOT NULL)');
        $this->addSql('INSERT INTO pokemon (id, name, generation, sprite, types, height, weight, catchrate) SELECT id, name, generation, sprite, types, height, weight, catchrate FROM __temp__pokemon');
        $this->addSql('DROP TABLE __temp__pokemon');
    }
}
