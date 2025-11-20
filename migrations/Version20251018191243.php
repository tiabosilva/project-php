<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251018191243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__galerie AS SELECT id, createur_id, description, publiee FROM galerie');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('CREATE TABLE galerie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, createur_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, publiee VARCHAR(255) NOT NULL, CONSTRAINT FK_9E7D159073A201E5 FOREIGN KEY (createur_id) REFERENCES member (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO galerie (id, createur_id, description, publiee) SELECT id, createur_id, description, publiee FROM __temp__galerie');
        $this->addSql('DROP TABLE __temp__galerie');
        $this->addSql('CREATE INDEX IDX_9E7D159073A201E5 ON galerie (createur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__galerie AS SELECT id, createur_id, description, publiee FROM galerie');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('CREATE TABLE galerie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, createur_id INTEGER NOT NULL, description VARCHAR(255) NOT NULL, publiee VARCHAR(255) NOT NULL, CONSTRAINT FK_9E7D159073A201E5 FOREIGN KEY (createur_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO galerie (id, createur_id, description, publiee) SELECT id, createur_id, description, publiee FROM __temp__galerie');
        $this->addSql('DROP TABLE __temp__galerie');
        $this->addSql('CREATE INDEX IDX_9E7D159073A201E5 ON galerie (createur_id)');
    }
}
