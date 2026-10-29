<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260117144526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(100) NOT NULL, txt VARCHAR(255) NOT NULL, note INT NOT NULL, user_avis_id INT NOT NULL, espace_avis_id INT NOT NULL, INDEX IDX_8F91ABF041736E95 (user_avis_id), INDEX IDX_8F91ABF04FDB75D6 (espace_avis_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE commodite (id INT AUTO_INCREMENT NOT NULL, nom_com VARCHAR(25) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE conversation_utilisateur (conversation_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_F3031EC39AC0396 (conversation_id), INDEX IDX_F3031EC3FB88E14F (utilisateur_id), PRIMARY KEY (conversation_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE espace (id INT AUTO_INCREMENT NOT NULL, cp_esp VARCHAR(5) NOT NULL, adresse_esp VARCHAR(50) NOT NULL, ville_esp VARCHAR(50) NOT NULL, titre_esp VARCHAR(255) NOT NULL, date_publi_esp DATETIME NOT NULL, surface DOUBLE PRECISION NOT NULL, desc_esp VARCHAR(255) NOT NULL, nb_max_coloc_esp INT NOT NULL, available_from_esp DATE NOT NULL, available_to_esp DATE NOT NULL, tarif INT NOT NULL, type_espace_id INT NOT NULL, owner_id INT NOT NULL, INDEX IDX_6AB096D24E1D7C (type_espace_id), INDEX IDX_6AB096D7E3C61F9 (owner_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE espace_commodite (espace_id INT NOT NULL, commodite_id INT NOT NULL, INDEX IDX_1B5D255DB6885C6C (espace_id), INDEX IDX_1B5D255DAE632A35 (commodite_id), PRIMARY KEY (espace_id, commodite_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, sender_id INT DEFAULT NULL, conversation_id INT DEFAULT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F9AC0396 (conversation_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE photo_espace (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, img LONGBLOB NOT NULL, img_type VARCHAR(10) NOT NULL, espace_id INT DEFAULT NULL, INDEX IDX_53147E45B6885C6C (espace_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE type_espace (id INT AUTO_INCREMENT NOT NULL, cd_tp_espace INT NOT NULL, tp_esp_lib VARCHAR(25) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom_util VARCHAR(50) NOT NULL, prenom_util VARCHAR(50) NOT NULL, cp_util VARCHAR(5) NOT NULL, adresse_util VARCHAR(50) NOT NULL, ville_util VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur_espace (utilisateur_id INT NOT NULL, espace_id INT NOT NULL, INDEX IDX_670633E6FB88E14F (utilisateur_id), INDEX IDX_670633E6B6885C6C (espace_id), PRIMARY KEY (utilisateur_id, espace_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur_utilisateur (utilisateur_source INT NOT NULL, utilisateur_target INT NOT NULL, INDEX IDX_E9FA6E203E2745F8 (utilisateur_source), INDEX IDX_E9FA6E2027C21577 (utilisateur_target), PRIMARY KEY (utilisateur_source, utilisateur_target)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF041736E95 FOREIGN KEY (user_avis_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF04FDB75D6 FOREIGN KEY (espace_avis_id) REFERENCES espace (id)');
        $this->addSql('ALTER TABLE conversation_utilisateur ADD CONSTRAINT FK_F3031EC39AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_utilisateur ADD CONSTRAINT FK_F3031EC3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espace ADD CONSTRAINT FK_6AB096D24E1D7C FOREIGN KEY (type_espace_id) REFERENCES type_espace (id)');
        $this->addSql('ALTER TABLE espace ADD CONSTRAINT FK_6AB096D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE espace_commodite ADD CONSTRAINT FK_1B5D255DB6885C6C FOREIGN KEY (espace_id) REFERENCES espace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espace_commodite ADD CONSTRAINT FK_1B5D255DAE632A35 FOREIGN KEY (commodite_id) REFERENCES commodite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE photo_espace ADD CONSTRAINT FK_53147E45B6885C6C FOREIGN KEY (espace_id) REFERENCES espace (id)');
        $this->addSql('ALTER TABLE utilisateur_espace ADD CONSTRAINT FK_670633E6FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_espace ADD CONSTRAINT FK_670633E6B6885C6C FOREIGN KEY (espace_id) REFERENCES espace (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E203E2745F8 FOREIGN KEY (utilisateur_source) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_utilisateur ADD CONSTRAINT FK_E9FA6E2027C21577 FOREIGN KEY (utilisateur_target) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF041736E95');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF04FDB75D6');
        $this->addSql('ALTER TABLE conversation_utilisateur DROP FOREIGN KEY FK_F3031EC39AC0396');
        $this->addSql('ALTER TABLE conversation_utilisateur DROP FOREIGN KEY FK_F3031EC3FB88E14F');
        $this->addSql('ALTER TABLE espace DROP FOREIGN KEY FK_6AB096D24E1D7C');
        $this->addSql('ALTER TABLE espace DROP FOREIGN KEY FK_6AB096D7E3C61F9');
        $this->addSql('ALTER TABLE espace_commodite DROP FOREIGN KEY FK_1B5D255DB6885C6C');
        $this->addSql('ALTER TABLE espace_commodite DROP FOREIGN KEY FK_1B5D255DAE632A35');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('ALTER TABLE photo_espace DROP FOREIGN KEY FK_53147E45B6885C6C');
        $this->addSql('ALTER TABLE utilisateur_espace DROP FOREIGN KEY FK_670633E6FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_espace DROP FOREIGN KEY FK_670633E6B6885C6C');
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E203E2745F8');
        $this->addSql('ALTER TABLE utilisateur_utilisateur DROP FOREIGN KEY FK_E9FA6E2027C21577');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE commodite');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE conversation_utilisateur');
        $this->addSql('DROP TABLE espace');
        $this->addSql('DROP TABLE espace_commodite');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photo_espace');
        $this->addSql('DROP TABLE type_espace');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_espace');
        $this->addSql('DROP TABLE utilisateur_utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
