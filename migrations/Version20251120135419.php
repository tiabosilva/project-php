<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251120135419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE collection_voitures (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, theme VARCHAR(100) DEFAULT NULL)');
        $this->addSql('CREATE TABLE galerie (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, createur_id INTEGER DEFAULT NULL, description VARCHAR(255) NOT NULL, publiee BOOLEAN NOT NULL, CONSTRAINT FK_9E7D159073A201E5 FOREIGN KEY (createur_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9E7D159073A201E5 ON galerie (createur_id)');
        $this->addSql('CREATE TABLE galerie_voiture (galerie_id INTEGER NOT NULL, voiture_id INTEGER NOT NULL, PRIMARY KEY(galerie_id, voiture_id), CONSTRAINT FK_5E46E084825396CB FOREIGN KEY (galerie_id) REFERENCES galerie (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5E46E084181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_5E46E084825396CB ON galerie_voiture (galerie_id)');
        $this->addSql('CREATE INDEX IDX_5E46E084181A8BA ON galerie_voiture (voiture_id)');
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collection_voitures_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, CONSTRAINT FK_70E4FA78506EFA9E FOREIGN KEY (collection_voitures_id) REFERENCES collection_voitures (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA78506EFA9E ON member (collection_voitures_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON member (email)');
        $this->addSql('CREATE TABLE voiture (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, collection_voitures_id INTEGER DEFAULT NULL, modele VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, annee VARCHAR(255) NOT NULL, CONSTRAINT FK_E9E2810F506EFA9E FOREIGN KEY (collection_voitures_id) REFERENCES collection_voitures (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_E9E2810F506EFA9E ON voiture (collection_voitures_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE collection_voitures');
        $this->addSql('DROP TABLE galerie');
        $this->addSql('DROP TABLE galerie_voiture');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
